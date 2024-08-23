<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%items}}`.
 */
class m210209_082134_add_verified_column_to_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%items}}', 'verified', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%items}}', 'verified');
    }
}
