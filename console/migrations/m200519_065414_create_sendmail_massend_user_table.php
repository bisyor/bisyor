<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sendmail_massend_user}}`.
 */
class m200519_065414_create_sendmail_massend_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sendmail_massend_user}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'to_phone' => $this->boolean(),
            'to_email' => $this->boolean(),
            'massend_id' => $this->integer(),
            'title' => $this->string(255),
            'text' => $this->text(),
            'status' => $this->integer(),
            'date_cr' => $this->dateTime(),
        ]);
        $this->createIndex(
            '{{%idx-sendmail_massend_user-user_id}}',
            '{{%sendmail_massend_user}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-sendmail_massend_user-user_id}}',
            '{{%sendmail_massend_user}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-sendmail_massend_user-massend_id}}',
            '{{%sendmail_massend_user}}',
            'massend_id'
        );

        $this->addForeignKey(
            '{{%fk-sendmail_massend_user-massend_id}}',
            '{{%sendmail_massend_user}}',
            'massend_id',
            '{{%sendmail_massend}}',
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
            '{{%fk-sendmail_massend_user-user_id}}',
            '{{%sendmail_massend_user}}'
        );

        $this->dropIndex(
            '{{%idx-sendmail_massend_user-user_id}}',
            '{{%sendmail_massend_user}}'
        );
        $this->dropForeignKey(
            '{{%fk-sendmail_massend_user-massend_id}}',
            '{{%sendmail_massend_user}}'
        );

        $this->dropIndex(
            '{{%idx-sendmail_massend_user-massend_id}}',
            '{{%sendmail_massend_user}}'
        );
        $this->dropTable('{{%sendmail_massend_user}}');
    }
}
