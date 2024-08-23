<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%vacancy_resume}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%vacancies}}`
 */
class m210309_130003_add_vacancy_id_column_to_vacancy_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%vacancy_resume}}', 'vacancy_id', $this->integer());

        // creates index for column `vacancy_id`
        $this->createIndex(
            '{{%idx-vacancy_resume-vacancy_id}}',
            '{{%vacancy_resume}}',
            'vacancy_id'
        );

        // add foreign key for table `{{%vacancies}}`
        $this->addForeignKey(
            '{{%fk-vacancy_resume-vacancy_id}}',
            '{{%vacancy_resume}}',
            'vacancy_id',
            '{{%vacancies}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%vacancies}}`
        $this->dropForeignKey(
            '{{%fk-vacancy_resume-vacancy_id}}',
            '{{%vacancy_resume}}'
        );

        // drops index for column `vacancy_id`
        $this->dropIndex(
            '{{%idx-vacancy_resume-vacancy_id}}',
            '{{%vacancy_resume}}'
        );

        $this->dropColumn('{{%vacancy_resume}}', 'vacancy_id');
    }
}
