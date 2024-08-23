<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%items_limits_users}}`.
 */
class m200507_065111_create_items_limits_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%items_limits_users}}', [
            'id' => $this->primaryKey(),
            'active' => $this->tinyInteger(),
            'user_id' => $this->integer(),
            'cat_id' => $this->integer(),
            'free_id' => $this->integer(),
            'paid_id' => $this->integer(),
            'items' => $this->integer(),
            'shop' => $this->tinyInteger(),
            'expire' => $this->dateTime(),
            'created' => $this->dateTime(),
            'bill_id' => $this->text(),
            'need_check' => $this->integer(),
        ]);
//        users relation
        $this->createIndex(
            '{{%idx-items_limits_users-user_id}}',
            '{{%items_limits_users}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-items_limits_users-user_id}}',
            '{{%items_limits_users}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-items_limits_users-cat_id}}',
            '{{%items_limits_users}}',
            'cat_id'
        );

        $this->addForeignKey(
            '{{%fk-items_limits_users-cat_id}}',
            '{{%items_limits_users}}',
            'cat_id',
            '{{%categories}}',
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
            '{{%fk-items_limits_users-user_id}}',
            '{{%items_limits_users}}'
        );

        $this->dropIndex(
            '{{%idx-items_limits_users-user_id}}',
            '{{%items_limits_users}}'
        );

        $this->dropForeignKey(
            '{{%fk-items_limits_users-cat_id}}',
            '{{%items_limits_users}}'
        );

        $this->dropIndex(
            '{{%idx-items_limits_users-cat_id}}',
            '{{%items_limits_users}}'
        );

        $this->dropTable('{{%items_limits_users}}');
    }
}
