<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%search_results}}`.
 */
class m210212_111250_add_user_id_column_to_search_results_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%search_results}}', 'user_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%search_results}}', 'user_id');
    }
}
