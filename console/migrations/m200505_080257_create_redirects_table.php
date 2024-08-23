<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%redirects}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m200505_080257_create_redirects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%redirects}}', [
            'id' => $this->primaryKey(),
            'from_uri' => $this->text()->comment('Исходный URL'),
            'to_uri' => $this->text()->comment('Итоговый URL'),
            'status' => $this->integer()->comment('Статус'),
            'is_relative' => $this->boolean(),
            'add_extra' => $this->boolean()->comment('Использовать локализацию/регион и подобные настройки из исходного URL'),
            'add_query' => $this->boolean()->comment('Использовать параметры запроса из исходного URL'),
            'enabled' => $this->boolean()->comment('Включен'),
            'date_cr' => $this->datetime()->comment('Дата создание'),
            'date_up' => $this->datetime()->comment('Дата изменение'),
            'user_id' => $this->integer()->comment('Пользователь'),
            'user_ip' => $this->string(255)->comment('IP пользователя'),
            'joined' => $this->integer(),
            'joined_module' => $this->text(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-redirects-user_id}}',
            '{{%redirects}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-redirects-user_id}}',
            '{{%redirects}}',
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
            '{{%fk-redirects-user_id}}',
            '{{%redirects}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-redirects-user_id}}',
            '{{%redirects}}'
        );

        $this->dropTable('{{%redirects}}');
    }
}
