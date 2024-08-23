<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%items}}`.
 */
class m200924_082846_add_from_device_column_to_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%items}}', 'from_device', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%items}}', 'from_device');
    }
}
