<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%insert_module_method}}`.
 */
class m200912_064521_create_insert_module_method_table extends Migration
{

    public function safeUp()
    {
        $this->insert('module_methods',array(
            'id' => 84,
            'module'=>'polls',
            'method' =>'polls',
            'title' => 'Опросы',
        ));

        $this->insert('module_methods',array(
            'id' => 85,
            'module'=>'polls',
            'method' =>'polls-listing',
            'title' => 'Список опросы',
        ));

        $this->insert('module_methods',array(
            'id' => 86,
            'module'=>'polls',
            'method' =>'polls-edit',
            'title' => 'Управление Опросы',
        ));

        $this->insert('module_methods',array(
            'id' => 87,
            'module'=>'alerts',
            'method' =>'alerts',
            'title' => 'Уведомления',
        ));

        $this->insert('module_methods',array(
            'id' => 88,
            'module'=>'alerts',
            'method' =>'alerts-listing',
            'title' => 'Список уведомления',
        ));

        $this->insert('module_methods',array(
            'id' => 89,
            'module'=>'alerts',
            'method' =>'alerts-edit',
            'title' => 'Управление Уведомления',
        ));

        $this->insert('module_methods',array(
            'id' => 90,
            'module'=>'social-networks',
            'method' =>'social-networks',
            'title' => 'Cоциальные сети',
        ));

        $this->insert('module_methods',array(
            'id' => 91,
            'module'=>'social-networks',
            'method' =>'social-networks-listing',
            'title' => 'Список социальные сети',
        ));

        $this->insert('module_methods',array(
            'id' => 92,
            'module'=>'social-networks',
            'method' =>'social-networks-edit',
            'title' => 'Управление Cоциальные сети',
        ));

        $this->insert('module_methods',array(
            'id' => 93,
            'module'=>'subscribers',
            'method' =>'subscribers',
            'title' => 'Подписчики',
        ));

        $this->insert('module_methods',array(
            'id' => 94,
            'module'=>'subscribers',
            'method' =>'subscribers-listing',
            'title' => 'Список Подписчики',
        ));

        $this->insert('module_methods',array(
            'id' => 95,
            'module'=>'subscribers',
            'method' =>'subscribers-edit',
            'title' => 'Управление Подписчики',
        ));

        $this->insert('module_methods',array(
            'id' => 96,
            'module'=>'seo',
            'method' =>'settings',
            'title' => 'Настройки сайта',
        ));

        $this->insert('module_methods',array(
            'id' => 97,
            'module'=>'desktop',
            'method' =>'statistika',
            'title' => 'Статистика',
        ));

        // *************** role methods for insert **********
        // general admin
        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 84,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 85,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 86,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 87,
            'value'   => 1,
        ));
        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 88,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 89,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 90,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 91,
            'value'   => 1,
        ));
        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 92,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 93,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 94,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 95,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 96,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 97,
            'value'   => 1,
        ));

        //for moderator
        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 84,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 85,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 86,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 87,
            'value'   => 0,
        ));
        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 88,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 89,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 90,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 91,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 92,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 93,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 94,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 95,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 96,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 97,
            'value'   => 0,
        ));

        //for simple admin
        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 84,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 85,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 86,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 87,
            'value'   => 1,
        ));
        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 88,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 89,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 90,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 91,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 92,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 93,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 94,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 95,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 96,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 97,
            'value'   => 1,
        ));

        // for seo proff
        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 84,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 85,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 86,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 87,
            'value'   => 0,
        ));
        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 88,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 89,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 90,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 91,
            'value'   => 0,
        ));
        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 92,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 93,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 94,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 95,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 96,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 97,
            'value'   => 0,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
