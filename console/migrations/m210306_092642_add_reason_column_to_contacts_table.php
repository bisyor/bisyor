<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%contacts}}`.
 */
class m210306_092642_add_reason_column_to_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%contacts}}', 'reason', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%contacts}}', 'reason');
    }
}
