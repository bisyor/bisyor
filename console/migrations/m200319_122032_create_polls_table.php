<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%polls}}`.
 */
class m200319_122032_create_polls_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%polls}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('Название опроса'),
            'start' => $this->datetime()->comment('Дата начало'),
            'finish' => $this->datetime()->comment('Дата завершени'),
            'status' => $this->integer()->comment('Статус'),
            'finish_type' => $this->integer()->comment('Дата завершени'),
            'ownoption' => $this->boolean()->comment('Свой вариант'),
            'ownoption_text' => $this->text()->comment('Текст подсказки'),
            'choice' => $this->integer()->comment('Выбор ответа'),
            'view_result' => $this->integer()->comment('Отображать результаты'),
            'resultvotes' => $this->boolean()->comment('Отображать количество голосов'),
            'showfinishing' => $this->boolean()->comment('Отображать дату завершения'),
            'audience' => $this->integer()->comment('Участники'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%polls}}');
    }
}
