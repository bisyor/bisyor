<?php

use yii\db\Migration;

/**
 * Class m210609_105210_add_column_comment_to_applications_table
 */
class m210609_105210_add_column_comment_to_applications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%applications}}', 'comment', $this->text()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%applications}}', 'comment');
    }
}
