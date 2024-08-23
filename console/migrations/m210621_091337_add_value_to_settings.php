<?php

use yii\db\Migration;

/**
 * Class m210621_091337_add_value_to_settings
 */
class m210621_091337_add_value_to_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%settings}}',array(
            'name' => 'Telegram бот',
            'value' => 'https://t.me/bisyorbot',
            'key' => 'telegram_bot',
            'group' => 'system-settings',
            'type' => 'string'
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
        echo "m210621_091337_add_value_to_settings cannot be reverted.\n";

        return false;
    }
    */
}
