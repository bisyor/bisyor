<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_banlist}}`.
 */
class m200324_161958_create_users_banlist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_banlist}}', [
            'id' => $this->primaryKey(),
            'ip_list' => $this->string(255)->comment('Ip Адрес'),
            'date_cr' => $this->datetime()->comment('Дата создание'),
            'finished' => $this->datetime()->comment('Дата окончание'),
            'type' => $this->integer()->comment('Тип'),
            'selected' => $this->integer()->comment('Выбранный'),
            'description' => $this->text()->comment('Причина блокировки доступа'),
            'reason' => $this->text()->comment('Причина, показываемая пользователья'),
            'exclude' => $this->boolean()->comment('Добавить в белый список'),
            'status' => $this->boolean()->comment('Статус'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users_banlist}}');
    }
}
