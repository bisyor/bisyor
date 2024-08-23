<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_subscribers}}`.
 */
class m201219_102224_create_shops_subscribers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_subscribers}}', [
            'id' => $this->primaryKey(),
            'date_cr' => $this->dateTime()->comment('Дата создание'),
            'shop_id' => $this->integer()->comment('Магазин'),
            'user_id' => $this->integer()->comment('Пользователь'),
        ]);
        $this->createIndex(
            '{{%idx-shops_subscribers-shop_id}}',
            '{{%shops_subscribers}}',
            'shop_id'
        );

        $this->addForeignKey(
            '{{%fk-shops_subscribers-shop_id}}',
            '{{%shops_subscribers}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-shops_subscribers-user_id}}',
            '{{%shops_subscribers}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-shops_subscribers-user_id}}',
            '{{%shops_subscribers}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-shops_subscribers-shop_id}}',
            '{{%shops_subscribers}}'
        );
        $this->dropIndex(
            '{{%idx-shops_subscribers-shop_id}}',
            '{{%shops_subscribers}}'
        );
        $this->dropForeignKey(
            '{{%fk-shops_subscribers-user_id}}',
            '{{%shops_subscribers}}'
        );
        $this->dropIndex(
            '{{%idx-shops_subscribers-user_id}}',
            '{{%shops_subscribers}}'
        );
        $this->dropTable('{{%shops_subscribers}}');
    }
}
