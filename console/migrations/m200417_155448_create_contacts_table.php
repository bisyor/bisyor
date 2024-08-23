<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contacts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m200417_155448_create_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contacts}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->comment("Тип"),
            'user_id' => $this->integer()->comment("Пользователь"),
            'user_ip' => $this->string(255)->comment("IP"),
            'name' => $this->string(255)->comment("Наименование"),
            'email' => $this->string(255)->comment("E-mail"),
            'message' => $this->text()->comment("Сообщение"),
            'useragent' => $this->text()->comment("Браузер пользователья"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
            'date_up' => $this->datetime()->comment("Дата изменение"),
            'viewed' => $this->boolean()->comment("Статус"),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-contacts-user_id}}',
            '{{%contacts}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-contacts-user_id}}',
            '{{%contacts}}',
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
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-contacts-user_id}}',
            '{{%contacts}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-contacts-user_id}}',
            '{{%contacts}}'
        );

        $this->dropTable('{{%contacts}}');
    }
}
