<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_history}}`.
 */
class m210211_092021_add_from_device_column_to_user_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_history}}', 'from_device', $this->integer()->comment("Устройства"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_history}}', 'from_device');
    }
}
