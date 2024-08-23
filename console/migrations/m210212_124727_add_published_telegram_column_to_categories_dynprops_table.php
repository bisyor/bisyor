<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%categories_dynprops}}`.
 */
class m210212_124727_add_published_telegram_column_to_categories_dynprops_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%categories_dynprops}}', 'published_telegram', $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%categories_dynprops}}', 'published_telegram');
    }
}
