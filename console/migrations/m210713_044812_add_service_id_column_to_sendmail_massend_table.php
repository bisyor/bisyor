<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sendmail_massend}}`.
 */
class m210713_044812_add_service_id_column_to_sendmail_massend_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sendmail_massend}}', 'service_id', $this->integer());
        $this->addColumn('{{%sendmail_massend_user}}', 'service_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sendmail_massend}}', 'service_id');
    }
}
