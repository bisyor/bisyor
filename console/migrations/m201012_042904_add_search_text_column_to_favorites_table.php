<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%favorites}}`.
 */
class m201012_042904_add_search_text_column_to_favorites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%favorites}}', 'search_text', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%favorites}}', 'search_text');
    }
}
