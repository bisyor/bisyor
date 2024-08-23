<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chats}}`.
 */
class m200318_104516_create_chats_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chats}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
            'status' => $this->integer()->comment("Статус"),
            'type' => $this->integer()->comment("Тип чата"),
            'field_id' => $this->integer()->comment("Id поля"),
        ]);
        $this->createIndex(
            'idx-chats-type',
            'chats',
            'type'
        );
        $this->createIndex(
            'idx-chats-field_id',
            'chats',
            'field_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-chats-type',
            'chats'
        );
        $this->dropIndex(
            'idx-chats-field_id',
            'chats'
        );
        $this->dropTable('{{%chats}}');
    }
}
