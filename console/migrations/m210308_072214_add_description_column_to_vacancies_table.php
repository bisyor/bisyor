<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%vacancies}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%currencies}}`
 */
class m210308_072214_add_description_column_to_vacancies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%vacancies}}', 'description', $this->text("Описания"));
        $this->addColumn('{{%vacancies}}', 'price', $this->float("Цена"));
        $this->addColumn('{{%vacancies}}', 'currency_id', $this->integer("Валюта"));

        // creates index for column `currency_id`
        $this->createIndex(
            '{{%idx-vacancies-currency_id}}',
            '{{%vacancies}}',
            'currency_id'
        );

        // add foreign key for table `{{%currencies}}`
        $this->addForeignKey(
            '{{%fk-vacancies-currency_id}}',
            '{{%vacancies}}',
            'currency_id',
            '{{%currencies}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%currencies}}`
        $this->dropForeignKey(
            '{{%fk-vacancies-currency_id}}',
            '{{%vacancies}}'
        );

        // drops index for column `currency_id`
        $this->dropIndex(
            '{{%idx-vacancies-currency_id}}',
            '{{%vacancies}}'
        );

        $this->dropColumn('{{%vacancies}}', 'description');
        $this->dropColumn('{{%vacancies}}', 'price');
        $this->dropColumn('{{%vacancies}}', 'currency_id');
    }
}
