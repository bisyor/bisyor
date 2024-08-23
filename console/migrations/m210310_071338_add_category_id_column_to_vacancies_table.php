<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%vacancies}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%vacancy_category}}`
 */
class m210310_071338_add_category_id_column_to_vacancies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%vacancies}}', 'category_id', $this->integer());

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-vacancies-category_id}}',
            '{{%vacancies}}',
            'category_id'
        );

        // add foreign key for table `{{%vacancy_category}}`
        $this->addForeignKey(
            '{{%fk-vacancies-category_id}}',
            '{{%vacancies}}',
            'category_id',
            '{{%vacancy_category}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%vacancy_category}}`
        $this->dropForeignKey(
            '{{%fk-vacancies-category_id}}',
            '{{%vacancies}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-vacancies-category_id}}',
            '{{%vacancies}}'
        );

        $this->dropColumn('{{%vacancies}}', 'category_id');
    }
}
