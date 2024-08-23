<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sendmail_template}}`.
 */
class m200513_114242_create_sendmail_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sendmail_template}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->comment('Заголовок'),
            'content' => $this->text()->comment('Текст шаблона'),
            'is_html' => $this->boolean()->comment('Текст содержит HTML теги'),
            'num' => $this->integer()->comment('Номер'),
            'date_cr' => $this->dateTime()->comment('Дата создание'),
            'date_up' => $this->dateTime()->comment('Дата изменение'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sendmail_template}}');
    }
}
