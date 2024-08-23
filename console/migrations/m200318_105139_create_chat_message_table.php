<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chat_message}}`.
 */
class m200318_105139_create_chat_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chat_message}}', [
            'id' => $this->primaryKey(),
            'chat_id' => $this->integer()->comment("Чат"),
            'user_id' => $this->integer()->comment("Пользователь"),
            'message' => $this->text()->comment("Сообщение"),
            'file' => $this->string(255)->comment("Файл"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
            'is_read' => $this->boolean()->comment("Прочитано"),
            'answer_to' => $this->integer()->comment("Ответ на сообщени"),
            'is_moderated' => $this->boolean()->comment("Прошёл из модерации"),
        ]);

        // creates index for column `chat_id`
        $this->createIndex(
            '{{%idx-chat_message-chat_id}}',
            '{{%chat_message}}',
            'chat_id'
        );

        // add foreign key for table `{{%chats}}`
        $this->addForeignKey(
            '{{%fk-chat_message-chat_id}}',
            '{{%chat_message}}',
            'chat_id',
            '{{%chats}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-chat_message-user_id}}',
            '{{%chat_message}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-chat_message-user_id}}',
            '{{%chat_message}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
         $this->createIndex(
            '{{%idx-chat_message-answer_to}}',
            '{{%chat_message}}',
            'answer_to'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-chat_message-answer_to}}',
            '{{%chat_message}}',
            'answer_to',
            '{{%chat_message}}',
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
            '{{%fk-chat_message-chat_id}}',
            '{{%chat_message}}'
        );

        // drops index for column `chat_id`
        $this->dropIndex(
            '{{%idx-chat_message-chat_id}}',
            '{{%chat_message}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-chat_message-user_id}}',
            '{{%chat_message}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-chat_message-user_id}}',
            '{{%chat_message}}'
        );
        // drops foreign key for table `{{%chat_message}}`
        $this->dropForeignKey(
            '{{%fk-chat_message-answer_to}}',
            '{{%chat_message}}'
        );

        // drops index for column `answer_to`
        $this->dropIndex(
            '{{%idx-chat_message-answer_to}}',
            '{{%chat_message}}'
        );

        $this->dropTable('{{%chat_message}}');
    }
}
