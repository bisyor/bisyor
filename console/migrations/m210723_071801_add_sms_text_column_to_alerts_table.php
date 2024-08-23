<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%alerts}}`.
 */
class m210723_071801_add_sms_text_column_to_alerts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%alerts}}', 'sms_text', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%alerts}}', 'sms_text');
    }
}
