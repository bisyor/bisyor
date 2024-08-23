<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sendmail_massend}}`.
 */
class m200513_114730_create_sendmail_massend_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sendmail_massend}}', [
            'id' => $this->primaryKey(),
            'from' => $this->string(255)->comment('От'),
            'name' => $this->string(255)->comment('ФИО'),
            'title' => $this->string(255)->comment('Тема'),
            'status' => $this->integer()->comment('Статус'),
            'text' => $this->text()->comment('Сообщение'),
            'to_phone' => $this->boolean()->comment('Отправить на телефон'),
            'shop_only' => $this->integer()->comment('Только для пользователей магазинов'),
            'template_id' => $this->integer()->comment('Шаблон'),
            'date_cr' => $this->dateTime()->comment('Дата создание'),
            'date_up' => $this->dateTime()->comment('Дата изменение'),
        ]);
        $this->createIndex(
            '{{%idx-sendmail_massend-template_id}}',
            '{{%sendmail_massend}}',
            'template_id'
        );

        $this->addForeignKey(
            '{{%fk-sendmail_massend-template_id}}',
            '{{%sendmail_massend}}',
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
            '{{%fk-sendmail_massend-template_id}}',
            '{{%sendmail_massend}}'
        );

        $this->dropIndex(
            '{{%idx-sendmail_massend-template_id}}',
            '{{%sendmail_massend}}'
        );
        $this->dropTable('{{%sendmail_massend}}');
    }
}
