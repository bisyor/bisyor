<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%alerts}}`.
 */
class m200613_091054_create_alerts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%alerts}}', [
            'id' => $this->primaryKey(),
            'email' => $this->boolean()->comment(""),
            'sms' => $this->boolean()->comment(""),
            'title' => $this->string(255)->comment("Заголовок"),
            'text' => $this->text()->comment("Текст"),
            'key' => $this->string(255)->comment("Ключ"),
            'key_title' => $this->string(255)->comment("Заголовок ключа"),
            'key_text' => $this->text()->comment("Текст ключа"),
            'type' => $this->string(255)->comment("Тип"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%alerts}}');
    }
}
