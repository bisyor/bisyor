<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_requests}}`.
 */
class m200525_144210_create_user_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_requests}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('Пользователь'),
            'link' => $this->text()->comment('Ссылка'),
            'date_cr' => $this->dateTime()->comment('Дата создание'),
        ]);
        $this->createIndex(
            '{{%idx-user_requests-user_id}}',
            '{{%user_requests}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-user_requests-user_id}}',
            '{{%user_requests}}',
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
        $this->dropForeignKey(
            '{{%fk-user_requests-user_id}}',
            '{{%user_requests}}'
        );

        $this->dropIndex(
            '{{%idx-user_requests-user_id}}',
            '{{%user_requests}}'
        );
        $this->dropTable('{{%user_requests}}');
    }
}
