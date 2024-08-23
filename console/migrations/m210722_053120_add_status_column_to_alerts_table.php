<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%alerts}}`.
 */
class m210722_053120_add_status_column_to_alerts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%alerts}}', 'status', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%alerts}}', 'status');
    }
}
