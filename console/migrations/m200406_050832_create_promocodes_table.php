<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%promocodes}}`.
 */
class m200406_050832_create_promocodes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%promocodes}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(255)->comment('Промокод'),
            'title' => $this->string(255)->comment('Название'),
            'type' => $this->integer()->comment('Тип'),
            'amount' => $this->integer()->comment('Сумма пополнения'),
            'usage_by' => $this->integer()->comment('Кто может применить'),
            'discount_type' => $this->integer()->comment('Вариант скидки'),
            'discount' => $this->integer()->comment('Размер скидки'),
            'usage_for' => $this->integer()->comment('Зона действия'),
            'category_list' => $this->text()->comment('Список категории'),
            'regions_list' => $this->text()->comment('Список регионов'),
            'active' => $this->boolean()->comment('Активен'),
            'active_to' => $this->datetime()->comment('Действует до'),
            'usage_limit' => $this->integer()->comment('Кол-во срабатываний'),
            'is_once' => $this->boolean()->comment('Доступно пользователю'),
            'break_days' => $this->integer()->comment('Не чаще чем'),
            'used' => $this->integer()->comment('Сколько использовано'),
            'created_at' => $this->datetime()->comment('Дата создание'),
            'active_from' => $this->datetime()->comment('Дата активации'),
            'service_id' => $this->integer()->comment('Услуга'),
        ]);

        $this->createIndex(
            '{{%idx-promocodes-service_id}}',
            '{{%promocodes}}',
            'service_id'
        );

        $this->addForeignKey(
            '{{%fk-promocodes-service_id}}',
            '{{%promocodes}}',
            'service_id',
            '{{%services}}',
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
            '{{%fk-promocodes-service_id}}',
            '{{%promocodes}}'
        );

        $this->dropIndex(
            '{{%idx-promocodes-service_id}}',
            '{{%promocodes}}'
        );
        $this->dropTable('{{%promocodes}}');
    }
}
