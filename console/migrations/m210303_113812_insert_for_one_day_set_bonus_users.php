<?php

use yii\db\Migration;

/**
 * Class m210303_113812_insert_for_one_day_set_bonus_users
 */
class m210303_113812_insert_for_one_day_set_bonus_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('settings',array(
            'name' => "Бонус пользователю за вход на платформу один раз в день",
            'value' => 50,
            'key' => "bonus_to_the_user_for_entering_the_platform_once_a_day",
            'group' => 'system-settings',
            'type' => "float",
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210303_113812_insert_for_one_day_set_bonus_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210303_113812_insert_for_one_day_set_bonus_users cannot be reverted.\n";

        return false;
    }
    */
}
