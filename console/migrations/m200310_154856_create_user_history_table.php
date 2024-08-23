<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_history}}`.
 */
class m200310_154856_create_user_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_history}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("Пользователь"),
            'date_cr' => $this->datetime()->comment("Дата создание"),
            'type' => $this->integer()->comment("Тип"),
            'title' => $this->string(255)->comment("Заголовок"),
            'value' => $this->text()->comment("Значение"),
        ]);
        $this->createIndex(
            'idx-user_history-user_id',
            'user_history',
            'user_id'
        );
        $this->addForeignKey(
            'fk-user_history-user_id',
            'user_history',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_history-user_id', 'user_history');
        $this->dropIndex(
            '{{%idx-user_history-user_id}}',
            '{{%user_history}}'
        );
        $this->dropTable('{{%user_history}}');
    }
}
