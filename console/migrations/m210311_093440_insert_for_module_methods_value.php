<?php

use yii\db\Migration;

/**
 * Class m210311_093440_insert_for_module_methods_value
 */
class m210311_093440_insert_for_module_methods_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('module_methods',array(
            'module'=>'bbs',
            'id' => 98,
            'method' =>'search-results',
            'title' => 'Результат поиска',
        ));

        $this->insert('module_methods',array(
            'id' => 99,
            'module'=>'bbs',
            'method' =>'search-results-settings',
            'title' => 'Управление результат поиска',
        ));

        $this->insert('module_methods',array(
            'id' => 100,
            'module'=>'bbs',
            'method' =>'items-scale',
            'title' => 'Шкала',
        ));

        $this->insert('module_methods',array(
            'id' => 101,
            'module'=>'bbs',
            'method' =>'settings',
            'title' => 'Управление шкала',
        ));

        $this->insert('module_methods',array(
            'id' => 102,
            'module'=>'promocodes',
            'method' =>'promocodes',
            'title' => 'Промокоды',
        ));

        $this->insert('module_methods',array(
            'id' => 103,
            'module'=>'promocodes',
            'method' =>'promocodes-settings',
            'title' => 'Управление промокоды',
        ));

        $this->insert('module_methods',array(
            'id' => 104,
            'module'=>'promocodes',
            'method' =>'statistika',
            'title' => 'Статистика',
        ));

        $this->insert('module_methods',array(
            'id' => 105,
            'module'=>'brands',
            'method' =>'brands',
            'title' => 'Бренды',
        ));

        $this->insert('module_methods',array(
            'id' => 106,
            'module'=>'brands',
            'method' =>'brands-settings',
            'title' => 'Управление бренды',
        ));

        $this->insert('module_methods',array(
            'id' => 107,
            'module'=>'rss',
            'method' =>'rss',
            'title' => 'RSS',
        ));

        $this->insert('module_methods',array(
            'id' => 108,
            'module'=>'black-list',
            'method' =>'black-list',
            'title' => 'Черный список',
        ));

        $this->insert('module_methods',array(
            'id' => 109,
            'module'=>'vacancies',
            'method' =>'vacancies',
            'title' => 'Ваканции',
        ));

        $this->insert('module_methods',array(
            'id' => 110,
            'module'=>'vacancies',
            'method' =>'vacancies-settings',
            'title' => 'Управление ваканции',
        ));

        $this->insert('module_methods',array(
            'id' => 111,
            'module'=>'vacancy-category',
            'method' =>'vacancy-category',
            'title' => 'Ваканции категория',
        ));

        $this->insert('module_methods',array(
            'id' => 112,
            'module'=>'parser',
            'method' =>'parser',
            'title' => 'Парсинг',
        ));

        $this->insert('module_methods',array(
            'id' => 113,
            'module'=>'parser',
            'method' =>'parser-mexnat-uz',
            'title' => 'Парсинг Mehnat uz',
        ));

        $this->insert('module_methods',array(
            'id' => 114,
            'module'=>'parser',
            'method' =>'parser-olx',
            'title' => 'Парсинг OLX',
        ));

        $this->insert('module_methods',array(
            'id' => 115,
            'module'=>'parser',
            'method' =>'olx-business',
            'title' => 'OLX Бизнес-страница',
        ));

        /// access
        // general admin
        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 98,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 99,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 100,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 101,
            'value'   => 1,
        ));
        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 102,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 103,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 104,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 105,
            'value'   => 1,
        ));
        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 106,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 107,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 108,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 109,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 110,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 111,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 112,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 113,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 114,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 7,
            'method_id'  => 115,
            'value'   => 1,
        ));


        //adminstartor
        /// access
        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 98,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 99,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 100,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 101,
            'value'   => 1,
        ));
        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 102,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 103,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 104,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 105,
            'value'   => 1,
        ));
        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 106,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 107,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 108,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 109,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 110,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 111,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 112,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 113,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 114,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 23,
            'method_id'  => 115,
            'value'   => 1,
        ));


        //seo spetsialist

        /// access
        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 98,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 99,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 100,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 101,
            'value'   => 1,
        ));
        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 102,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 103,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 104,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 105,
            'value'   => 1,
        ));
        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 106,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 107,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 108,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 109,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 110,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 111,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 112,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 113,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 114,
            'value'   => 1,
        ));

        $this->insert('role_methods',array(
            'role_id' => 24,
            'method_id'  => 115,
            'value'   => 1,
        ));


        //moderatoor

        /// access
        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 98,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 99,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 100,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 101,
            'value'   => 0,
        ));
        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 102,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 103,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 104,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 105,
            'value'   => 0,
        ));
        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 106,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 107,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 108,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 109,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 110,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 111,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 112,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 113,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 114,
            'value'   => 0,
        ));

        $this->insert('role_methods',array(
            'role_id' => 17,
            'method_id'  => 115,
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
