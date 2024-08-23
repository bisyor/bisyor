<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chats_user}}`.
 */
class m200318_104617_create_chat_users_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%chat_users}}', [
            'id' => $this->primaryKey(),
            'chat_id' => $this->integer()->comment("Чат"),
            'user_id' => $this->integer()->comment("Пользователи"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
        ]);

        // creates index for column `chat_id`
        $this->createIndex(
            '{{%idx-chat_users-chat_id}}',
            '{{%chat_users}}',
            'chat_id'
        );

        // add foreign key for table `{{%chats}}`
        $this->addForeignKey(
            '{{%fk-chat_users-chat_id}}',
            '{{%chat_users}}',
            'chat_id',
            '{{%chats}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-chat_users-user_id}}',
            '{{%chat_users}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-chat_users-user_id}}',
            '{{%chat_users}}',
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
        // drops foreign key for table `{{%chats}}`
        $this->dropForeignKey(
            '{{%fk-chat_users-chat_id}}',
            '{{%chat_users}}'
        );

        // drops index for column `chat_id`
        $this->dropIndex(
            '{{%idx-chat_users-chat_id}}',
            '{{%chat_users}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-chat_users-user_id}}',
            '{{%chat_users}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-chat_users-user_id}}',
            '{{%chat_users}}'
        );

        $this->dropTable('{{%chat_users}}');
    }
}
