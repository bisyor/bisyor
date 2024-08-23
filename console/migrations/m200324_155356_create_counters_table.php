<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%counters}}`.
 */
class m200324_155356_create_counters_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%counters}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->comment('Заголовок'),
            'code' => $this->text(),
            'code_position' => $this->integer(),
            'enabled' => $this->boolean()->comment('Статус'),
            'date_cr' => $this->datetime()->comment('Дата создание'),
            'num' => $this->integer()->comment('Сортировка'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%counters}}');
    }
}
