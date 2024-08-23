<?php

use yii\db\Migration;

/**
 * Class m210619_114133_add_settingis_sms_notifications_systems
 */
class m210619_114133_add_settingis_sms_notifications_systems extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('settings',array(
            'name' => "Смс сервисе",
            'value' => "1",
            'key' => "sms_service",
            'group' => 'system-settings',
            'type' => "integer",
        ));

        $this->insert('settings',array(
            'name' => "Смс сервисе токен",
            'value' => "eRzP6gF9TR2iqBW17My6ok:APA91bFLXxikUD9XMr2lOq2CDbHW4VzpRTcvFmA-ovMpWmdyMY8ZvOu4vG0nhFsGYABeReMzhsk15WmgHtuSPGC4wBaou-o0omiTe7HNr98KNC-bl58IgubDjwFhSgmdT6p0tPkKQMDB",
            'key' => "sms_service_token",
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
        echo "m210619_114133_add_settingis_sms_notifications_systems cannot be reverted.\n";

        return false;
    }
    */
}
