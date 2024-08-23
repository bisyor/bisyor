<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%banners_items}}`.
 */
class m210401_043014_add_sort_type_column_to_banners_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%banners_items}}', 'sort_type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%banners_items}}', 'sort_type');
    }
}
