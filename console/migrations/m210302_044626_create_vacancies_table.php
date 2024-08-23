<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancies}}`.
 */
class m210302_044626_create_vacancies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancies}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->comment('Наименование'),
            'vacancy_count' => $this->integer()->comment('количество вакансий'),
        ]);

        $this->insert('vacancies',array(
            'title' => "Разработка",
            'vacancy_count' => 12,
        ));

        $this->insert('vacancies',array(
            'title' => "Аналитика",
            'vacancy_count' => 3,
        ));

        $this->insert('vacancies',array(
            'title' => "Дизайн",
            'vacancy_count' => 2,
        ));

        $this->insert('vacancies',array(
            'title' => "Стажировка",
            'vacancy_count' => 5,
        ));

        $this->insert('vacancies',array(
            'title' => "Развитие бизнеса",
            'vacancy_count' => 3,
        ));

        $this->insert('vacancies',array(
            'title' => "Маркетинг",
            'vacancy_count' => 3,
        ));

        $this->insert('vacancies',array(
            'title' => "Административный отдел",
            'vacancy_count' => 2,
        ));

        $this->insert('vacancies',array(
            'title' => "Отдел информационных технологий",
            'vacancy_count' => 2,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vacancies}}');
    }
}
