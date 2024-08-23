<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sendmail_listing}}`.
 */
class m200513_122352_create_sendmail_listing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sendmail_listing}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->comment('Тип'),
            'title' => $this->string(255)->comment('Заголовок'),
            'desctiption' => $this->text()->comment('Описание'),
            'for' => $this->string(255)->comment('Для чего'),
            'enabled' => $this->boolean()->comment('Статус'),
            'name' => $this->string(255)->comment('Наименование'),
            'text' => $this->text()->comment('Текст'),
            'template_id' => $this->integer()->comment('Шаблон'),
            'send_to_phone' => $this->boolean()->comment('Отправить на телефон'),
        ]);
        $this->createIndex(
            '{{%idx-sendmail_listing-template_id}}',
            '{{%sendmail_listing}}',
            'template_id'
        );

        $this->addForeignKey(
            '{{%fk-sendmail_listing-template_id}}',
            '{{%sendmail_listing}}',
            'template_id',
            '{{%sendmail_template}}',
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
            '{{%fk-sendmail_listing-template_id}}',
            '{{%sendmail_listing}}'
        );

        $this->dropIndex(
            '{{%idx-sendmail_listing-template_id}}',
            '{{%sendmail_listing}}'
        );
        $this->dropTable('{{%sendmail_listing}}');
    }
}
