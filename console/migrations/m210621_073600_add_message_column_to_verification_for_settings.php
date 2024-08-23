<?php

use yii\db\Migration;

/**
 * Class m210621_073600_add_message_column_to_verification_for_settings
 */
class m210621_073600_add_message_column_to_verification_for_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('settings',array(
            'name' => "Смс сервисе Сообщения",
            'value' => "Ваш код на bisyor.uz",
            'key' => "sms_service_message",
            'group' => 'system-settings',
            'type' => "string",
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
        echo "m210621_073600_add_message_column_to_verification_for_settings cannot be reverted.\n";

        return false;
    }
    */
}
