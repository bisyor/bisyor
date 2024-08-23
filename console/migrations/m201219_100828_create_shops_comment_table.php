<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops_comment}}`.
 */
class m201219_100828_create_shops_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shops_comment}}', [
            'id' => $this->primaryKey(),
            'enabled' => $this->boolean()->comment('Статус'),
            'text' => $this->text()->comment('Текст'),
            'shop_id' => $this->integer()->comment('Магазин'),
            'user_ip' => $this->string(255)->comment('IP пользователья'),
            'fio' => $this->string(255)->comment('Фио пользователья'),
        ]);
        $this->createIndex(
            '{{%idx-shops_comment-shop_id}}',
            '{{%shops_comment}}',
            'shop_id'
        );

        $this->addForeignKey(
            '{{%fk-shops_comment-shop_id}}',
            '{{%shops_comment}}',
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
            '{{%fk-shops_comment-shop_id}}',
            '{{%shops_comment}}'
        );
        $this->dropIndex(
            '{{%idx-shops_comment-shop_id}}',
            '{{%shops_comment}}'
        );
        $this->dropTable('{{%shops_comment}}');
    }
}
