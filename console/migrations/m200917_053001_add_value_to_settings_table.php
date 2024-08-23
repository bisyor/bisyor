<?php

use yii\db\Migration;

/**
 * Class m200917_053001_add_value_to_settings_table
 */
class m200917_053001_add_value_to_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%settings}}',array(
            'name' => 'Вид премиум объявления',
            'value' => 1,
            'key' => 'general_premium_view_type',
            'group' => 'system-settings',
            'type' => 'integer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200917_053001_add_value_to_settings_table cannot be reverted.\n";

        return false;
    }
    */
}
