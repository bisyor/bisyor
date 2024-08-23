<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%bills}}`.
 */
class m210415_071520_add_system_transaction_id_column_to_bills_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%bills}}', 'system_transaction_id', $this->string(255)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%bills}}', 'system_transaction_id');
    }
}
