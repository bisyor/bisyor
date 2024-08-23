<?php

use yii\db\Migration;

/**
 * Class m210209_114312_create_bonus_for_new_registered_user_in_settings
 */
class m210209_114312_create_bonus_for_new_registered_user_in_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('settings',array(
            'name' => "Бонус для пользователя",
            'value' => "500",
            'key' => "bonus_for_user",
            'group' => 'system-settings',
            'type' => "float",
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
        echo "m210209_114312_create_bonus_for_new_registered_user_in_settings cannot be reverted.\n";

        return false;
    }
    */
}
