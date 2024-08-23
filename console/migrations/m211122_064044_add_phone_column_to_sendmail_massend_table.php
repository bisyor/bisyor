<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sendmail_massend}}`.
 */
class m211122_064044_add_phone_column_to_sendmail_massend_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sendmail_massend_user}}', 'phone', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sendmail_massend_user}}', 'phone');
    }
}
