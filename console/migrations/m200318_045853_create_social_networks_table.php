<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%social_networks}}`.
 */
class m200318_045853_create_social_networks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%social_networks}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('Наименование'),
            'icon' => $this->string(255)->comment('Иконка'),
            'status' => $this->boolean()->comment('Статус'),
        ]);
        $this->insert('social_networks',array(
            'name' => 'Facebook', 
            'icon' => 'facebook.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'Instagram', 
            'icon' => 'instagram.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'Вконтакте', 
            'icon' => 'vkontakte.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'Одноклассники', 
            'icon' => 'ok.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'Telegram', 
            'icon' => 'telegram.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'Google', 
            'icon' => 'google.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'Мой мир', 
            'icon' => 'moymir.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'Яндекс', 
            'icon' => 'yandeks.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'OpenID', 
            'icon' => 'openid.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'Yahoo', 
            'icon' => 'yahoo.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'AOL', 
            'icon' => 'aol.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'Twitter', 
            'icon' => 'twitter.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'Linkedin', 
            'icon' => 'linkedin.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'Live', 
            'icon' => 'live.png', 
            'status' => 1
        ));
        $this->insert('social_networks',array(
            'name' => 'Foursquare', 
            'icon' => 'foursquare.png', 
            'status' => 1
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%social_networks}}');
    }
}
