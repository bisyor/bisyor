<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%banners_items}}`.
 */
class m210407_070340_add_keyword_column_to_banners_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%banners_items}}', 'keyword', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%banners_items}}', 'keyword');
    }
}
