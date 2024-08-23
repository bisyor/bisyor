<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%search_results}}`.
 */
class m210417_104003_add_from_device_column_to_search_results_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%search_results}}', 'from_device', $this->integer()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%search_results}}', 'from_device');
    }
}
