<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%items}}`.
 */
class m210401_054001_add_moderation_date_column_to_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%items}}', 'moderation_date', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%items}}', 'moderation_date');
    }
}
