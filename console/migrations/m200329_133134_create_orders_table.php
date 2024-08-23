<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m200329_133134_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'created_date' => $this->datetime()->comment("Дата создание"),
            'user_id' => $this->integer()->comment("Пользователь"),
            'user_balance' => $this->float()->comment("Баланс пользователя"),
            'amount' => $this->float()->comment("Сумма"),
            'state' => $this->integer()->comment("Статус"),
            'change_state' => $this->datetime()->comment("Дата изменение статуса"),
            'description' => $this->text()->comment("Описание"),
            'type' => $this->integer()->comment("Тип"),
        ]);

         $this->createIndex(
            'idx-orders-user_id',
            'orders',
            'user_id'
        );


        // add foreign key for table `orders`
        $this->addForeignKey(
            'fk-orders-user_id',
            'orders',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-orders-user_id', 'orders');
        $this->dropIndex(
            '{{%idx-orders-user_id}}',
            '{{%orders}}'
        );
        $this->dropTable('{{%orders}}');
    }
}
