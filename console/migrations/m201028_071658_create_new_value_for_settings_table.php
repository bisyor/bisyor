<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%new_value_for_settings}}`.
 */
class m201028_071658_create_new_value_for_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%settings}}',array(
            'name' => 'Токен бота телеграмм',
            'value' => '',
            'key' => 'telegram_bot_token',
            'group' => 'site-settings',
            'type' => 'string'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       
    }
}
