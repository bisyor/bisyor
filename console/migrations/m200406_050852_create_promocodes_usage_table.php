<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%promocodes_usage}}`.
 */
class m200406_050852_create_promocodes_usage_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%promocodes_usage}}', [
            'id' => $this->primaryKey(),
            'promocode_id' => $this->integer()->comment('Промокоды'),
            'user_id' => $this->integer()->comment('Пользователь'),
            'category_id' => $this->integer()->comment('Категория'),
            'category_root_id' => $this->integer(),
            'item_id' => $this->integer()->comment('Объявление'),
            'shop_id' => $this->integer()->comment('Магазин'),
            'shop_categories' => $this->text()->comment('Категория магазина '),
            'is_active' => $this->boolean()->comment('Актино или нет'),
            'success' => $this->boolean()->comment('Статус'),
            'used_at' => $this->datetime()->comment('Использован'),
        ]);

        $this->createIndex(
            '{{%idx-promocodes_usage-user_id}}',
            '{{%promocodes_usage}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-promocodes_usage-user_id}}',
            '{{%promocodes_usage}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-promocodes_usage-promocode_id}}',
            '{{%promocodes_usage}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-promocodes_usage-promocode_id}}',
            '{{%promocodes_usage}}',
            'promocode_id',
            '{{%promocodes}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-promocodes_usage-category_id}}',
            '{{%promocodes_usage}}',
            'category_id'
        );

        $this->addForeignKey(
            '{{%fk-promocodes_usage-category_id}}',
            '{{%promocodes_usage}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-promocodes_usage-item_id}}',
            '{{%promocodes_usage}}',
            'item_id'
        );

        $this->addForeignKey(
            '{{%fk-promocodes_usage-item_id}}',
            '{{%promocodes_usage}}',
            'item_id',
            '{{%items}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-promocodes_usage-shop_id}}',
            '{{%promocodes_usage}}',
            'shop_id'
        );

        $this->addForeignKey(
            '{{%fk-promocodes_usage-shop_id}}',
            '{{%promocodes_usage}}',
            'shop_id',
            '{{%shops}}',
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
            '{{%fk-promocodes_usage-user_id}}',
            '{{%promocodes_usage}}'
        );

        $this->dropIndex(
            '{{%idx-promocodes_usage-user_id}}',
            '{{%promocodes_usage}}'
        );
        $this->dropForeignKey(
            '{{%fk-promocodes_usage-promocode_id}}',
            '{{%promocodes_usage}}'
        );

        $this->dropIndex(
            '{{%idx-promocodes_usage-promocode_id}}',
            '{{%promocodes_usage}}'
        );
        $this->dropForeignKey(
            '{{%fk-promocodes_usage-category_id}}',
            '{{%promocodes_usage}}'
        );

        $this->dropIndex(
            '{{%idx-promocodes_usage-category_id}}',
            '{{%promocodes_usage}}'
        );
        $this->dropForeignKey(
            '{{%fk-promocodes_usage-item_id}}',
            '{{%promocodes_usage}}'
        );

        $this->dropIndex(
            '{{%idx-promocodes_usage-item_id}}',
            '{{%promocodes_usage}}'
        );
        $this->dropForeignKey(
            '{{%fk-promocodes_usage-shop_id}}',
            '{{%promocodes_usage}}'
        );

        $this->dropIndex(
            '{{%idx-promocodes_usage-shop_id}}',
            '{{%promocodes_usage}}'
        );
        $this->dropTable('{{%promocodes_usage}}');
    }
}
