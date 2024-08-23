<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_rating}}`.
 */
class m201219_101907_create_shops_rating_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_rating}}', [
            'id' => $this->primaryKey(),
            'ball' => $this->float()->comment('Очков'),
            'date_cr' => $this->dateTime()->comment('Дата создание'),
            'shop_id' => $this->integer()->comment('Магазин'),
            'user_id' => $this->integer()->comment('Пользователь'),
        ]);
        $this->createIndex(
            '{{%idx-shops_rating-shop_id}}',
            '{{%shops_rating}}',
            'shop_id'
        );

        $this->addForeignKey(
            '{{%fk-shops_rating-shop_id}}',
            '{{%shops_rating}}',
            'shop_id',
            '{{%shops}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-shops_rating-user_id}}',
            '{{%shops_rating}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-shops_rating-user_id}}',
            '{{%shops_rating}}',
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
            '{{%fk-shops_rating-shop_id}}',
            '{{%shops_rating}}'
        );
        $this->dropIndex(
            '{{%idx-shops_rating-shop_id}}',
            '{{%shops_rating}}'
        );
        $this->dropForeignKey(
            '{{%fk-shops_rating-user_id}}',
            '{{%shops_rating}}'
        );
        $this->dropIndex(
            '{{%idx-shops_rating-user_id}}',
            '{{%shops_rating}}'
        );
        $this->dropTable('{{%shops_rating}}');
    }
}
