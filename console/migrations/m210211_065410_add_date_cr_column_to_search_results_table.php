<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%search_results}}`.
 */
class m210211_065410_add_date_cr_column_to_search_results_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%search_results}}', 'date_cr', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%search_results}}', 'date_cr');
    }
}
