<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancy_resume}}`.
 */
class m210308_072348_create_vacancy_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancy_resume}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'phone' => $this->string(255)->comment("Телефон"),
            'file' => $this->string(255)->comment("Файл"),
            'description' => $this->text()->comment("Описания"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vacancy_resume}}');
    }
}
