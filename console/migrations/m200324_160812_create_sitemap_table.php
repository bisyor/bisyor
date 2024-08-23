<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sitemap}}`.
 */
class m200324_160812_create_sitemap_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sitemap}}', [
            'id' => $this->primaryKey(),
            'sitemap_id' => $this->integer()->comment('Меню'),
            'name' => $this->string(255)->comment('Наименвоание'),
            'type' => $this->integer()->comment('Тип'),
            'keyword' => $this->string(255)->comment('Ключ'),
            'link' => $this->string(255)->comment('Ссылка'),
            'target' => $this->string(255)->comment('Таргет'),
            'is_system' => $this->boolean()->comment('Системный или нет'),
            'allow_submenu' => $this->boolean(),
            'enabled' => $this->boolean()->comment('Статус'), 
            'date_cr' => $this->datetime()->comment('Дата создания'), 
        ]);

        $this->createIndex(
            'idx-sitemap-sitemap_id',
            'sitemap',
            'sitemap_id'
        );


        // add foreign key for table `sitemap`
        $this->addForeignKey(
            'fk-sitemap-sitemap_id',
            'sitemap',
            'sitemap_id',
            'sitemap',
            'id',
            'CASCADE'
        );
        $arr = array( array('sitemap_id' => '1', 'name' => 'Корневой раздел', 'type' => '0','keyword' => 'root', 'link' => '','target' => '_self', 'is_system' => '1','allow_submenu' => '1', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '1', 'name' => 'Главное меню', 'type' => '1','keyword' => 'main', 'link' => '','target' => '_self', 'is_system' => '2','allow_submenu' => '1', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '2', 'name' => 'Объявления', 'type' => '4','keyword' => 'index', 'link' => '/search/','target' => '_self', 'is_system' => '1','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '2', 'name' => 'Магазины', 'type' => '4','keyword' => 'shops', 'link' => '{route:shops-search}','target' => '_self', 'is_system' => '1','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '2', 'name' => 'Услуги', 'type' => '4','keyword' => 'services', 'link' => '//{sitehost}/services/','target' => '_self', 'is_system' => '1','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '2', 'name' => 'Помощь', 'type' => '3','keyword' => 'help', 'link' => '{route:help-index}','target' => '_self', 'is_system' => '1','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '1', 'name' => 'Меню в футере', 'type' => '1','keyword' => 'footer', 'link' => '','target' => '_self', 'is_system' => '1','allow_submenu' => '1', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '7', 'name' => 'Колонка 1', 'type' => '1','keyword' => 'col1', 'link' => '','target' => '_self', 'is_system' => '1','allow_submenu' => '1', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '8', 'name' => 'Объявления', 'type' => '3','keyword' => 'index', 'link' => '/search/','target' => '_self', 'is_system' => '0','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '8', 'name' => 'Магазины', 'type' => '3','keyword' => 'shops', 'link' => '{route:shops-search}','target' => '_self', 'is_system' => '0','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '8', 'name' => 'Услуги', 'type' => '3','keyword' => 'services', 'link' => '//{sitehost}/services/','target' => '_self', 'is_system' => '0','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '8', 'name' => 'Помощь', 'type' => '3','keyword' => 'help', 'link' => '{route:help-index}','target' => '_self', 'is_system' => '0','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '7', 'name' => 'Колонка 2', 'type' => '1','keyword' => 'col2', 'link' => '','target' => '_self', 'is_system' => '1','allow_submenu' => '1', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '7', 'name' => 'Колонка 3', 'type' => '1','keyword' => 'col3', 'link' => '','target' => '_self', 'is_system' => '1','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '13', 'name' => 'Реклама на сайте', 'type' => '3','keyword' => 'ad', 'link' => '//{sitehost}/adv.html','target' => '_self', 'is_system' => '0','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '13', 'name' => 'Блог проекта', 'type' => '3','keyword' => 'blog', 'link' => '{route:blog-index}','target' => '_self', 'is_system' => '0','allow_submenu' => '0', 'enabled' => '0', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '13', 'name' => 'Обратная связь', 'type' => '3','keyword' => 'contact', 'link' => '//{sitehost}/contact/','target' => '_self', 'is_system' => '0','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '13', 'name' => 'Карта сайта', 'type' => '3','keyword' => 'sitemap', 'link' => '//{sitehost}/sitemap/','target' => '_self', 'is_system' => '0','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '13', 'name' => 'Условия использования', 'type' => '2','keyword' => 'agreement', 'link' => '//{sitehost}/agreement.html','target' => '_self', 'is_system' => '0','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '13', 'name' => 'Блог', 'type' => '3','keyword' => 'blog', 'link' => '{route:blog-index}','target' => '_self', 'is_system' => '1','allow_submenu' => '0', 'enabled' => '0', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '13', 'name' => 'Блог проекта', 'type' => '3','keyword' => 'blog', 'link' => '{route:blog-index}','target' => '_self', 'is_system' => '0','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '13', 'name' => 'Вакансии', 'type' => '3','keyword' => 'jobs', 'link' => '/jobs.html','target' => '_self', 'is_system' => '0','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			array('sitemap_id' => '8', 'name' => 'Мобильные приложения', 'type' => '3','keyword' => '', 'link' => '/mobileapps.html','target' => '_self', 'is_system' => '0','allow_submenu' => '0', 'enabled' => '1', 'date_cr' => date("Y-m-d H:i:s")),
			);

		foreach ($arr as $value) $this->insert('sitemap', $value);

		$translate_uz = [
		    ['table_name' => 'sitemap', 'field_id' => '1', 'field_name' => 'name', 'field_value' => 'Bosh bo\'lim', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '2', 'field_name' => 'name', 'field_value' => 'Asosiy menyu', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '3', 'field_name' => 'name', 'field_value' => 'E\'lonlar', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '4', 'field_name' => 'name', 'field_value' => 'Magazinlar', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '5', 'field_name' => 'name', 'field_value' => '1 xizmatlar', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '6', 'field_name' => 'name', 'field_value' => 'Yordam', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '7', 'field_name' => 'name', 'field_value' => 'Footer menyusi', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '8', 'field_name' => 'name', 'field_value' => '1-Ustun', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '9', 'field_name' => 'name', 'field_value' => 'E\'lonlar', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '10', 'field_name' => 'name', 'field_value' => 'Magazinlar', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '11', 'field_name' => 'name', 'field_value' => 'Pullik xizmatlar', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '12', 'field_name' => 'name', 'field_value' => 'Yordam', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '13', 'field_name' => 'name', 'field_value' => '2-Ustun', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '14', 'field_name' => 'name', 'field_value' => '3-Ustun', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '15', 'field_name' => 'name', 'field_value' => 'Reklama joylash', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '16', 'field_name' => 'name', 'field_value' => 'Loyiha blogi', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '17', 'field_name' => 'name', 'field_value' => 'Ma\'muriyat bilan bog\'lanish', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '18', 'field_name' => 'name', 'field_value' => 'Sayt xaritasi', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '19', 'field_name' => 'name', 'field_value' => 'Foydalanish shartlari', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '20', 'field_name' => 'name', 'field_value' => 'Blog', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '21', 'field_name' => 'name', 'field_value' => 'Loyiha blogi', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '22', 'field_name' => 'name', 'field_value' => 'Ish', 'language_code' => 'uz'],
		    ['table_name' => 'sitemap', 'field_id' => '23', 'field_name' => 'name', 'field_value' => 'Mobil ilova', 'language_code' => 'uz'],
		];


		$translate_oz = [
		    ['table_name' => 'sitemap', 'field_id' => '1', 'field_name' => 'name', 'field_value' => 'Бош бўлим', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '2', 'field_name' => 'name', 'field_value' => 'Асосий меню', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '3', 'field_name' => 'name', 'field_value' => 'Эълонлар', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '4', 'field_name' => 'name', 'field_value' => 'Магазинлар', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '5', 'field_name' => 'name', 'field_value' => 'Пуллик хизматлар', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '6', 'field_name' => 'name', 'field_value' => 'Ёрдам', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '7', 'field_name' => 'name', 'field_value' => 'Фоотер менюси', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '8', 'field_name' => 'name', 'field_value' => '1-Устун', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '9', 'field_name' => 'name', 'field_value' => 'Эълонлар', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '10', 'field_name' => 'name', 'field_value' => 'Магазинлар', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '11', 'field_name' => 'name', 'field_value' => 'Пуллик хизматлар', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '12', 'field_name' => 'name', 'field_value' => 'Ёрдам', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '13', 'field_name' => 'name', 'field_value' => '2-Устун', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '14', 'field_name' => 'name', 'field_value' => '3-Устун', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '15', 'field_name' => 'name', 'field_value' => 'Реклама жойлаш', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '16', 'field_name' => 'name', 'field_value' => 'Лойиҳа блоги', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '17', 'field_name' => 'name', 'field_value' => 'Маъмурият билан боғланиш', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '18', 'field_name' => 'name', 'field_value' => 'Сайт харитаси', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '19', 'field_name' => 'name', 'field_value' => 'Фойдаланиш шартлари', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '20', 'field_name' => 'name', 'field_value' => 'Блог', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '21', 'field_name' => 'name', 'field_value' => 'Лойиҳа блоги', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '22', 'field_name' => 'name', 'field_value' => 'Иш', 'language_code' => 'oz'],
		    ['table_name' => 'sitemap', 'field_id' => '23', 'field_name' => 'name', 'field_value' => 'Мобил илова', 'language_code' => 'oz'],
		];


		$translate_en = [
		    ['table_name' => 'sitemap', 'field_id' => '1', 'field_name' => 'name', 'field_value' => 'Root section', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '2', 'field_name' => 'name', 'field_value' => 'Main menu', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '3', 'field_name' => 'name', 'field_value' => 'Ads', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '4', 'field_name' => 'name', 'field_value' => 'Shops', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '5', 'field_name' => 'name', 'field_value' => 'Services', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '6', 'field_name' => 'name', 'field_value' => 'Help', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '7', 'field_name' => 'name', 'field_value' => 'Footer menu', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '8', 'field_name' => 'name', 'field_value' => 'Column 1', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '9', 'field_name' => 'name', 'field_value' => 'Ads', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '10', 'field_name' => 'name', 'field_value' => 'Shops', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '11', 'field_name' => 'name', 'field_value' => 'Services', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '12', 'field_name' => 'name', 'field_value' => 'Help', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '13', 'field_name' => 'name', 'field_value' => 'Column 2', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '14', 'field_name' => 'name', 'field_value' => 'Column 3', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '15', 'field_name' => 'name', 'field_value' => 'Advertising', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '16', 'field_name' => 'name', 'field_value' => 'Project blog', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '17', 'field_name' => 'name', 'field_value' => 'Contact us', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '18', 'field_name' => 'name', 'field_value' => 'Sitemap', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '19', 'field_name' => 'name', 'field_value' => 'Agreement', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '20', 'field_name' => 'name', 'field_value' => 'Blog', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '21', 'field_name' => 'name', 'field_value' => 'Project blog', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '22', 'field_name' => 'name', 'field_value' => 'Vacancy', 'language_code' => 'en'],
		    ['table_name' => 'sitemap', 'field_id' => '23', 'field_name' => 'name', 'field_value' => 'Mobil app', 'language_code' => 'en'],
		];

		foreach ($translate_uz as $value) $this->insert('translates', $value);
		foreach ($translate_oz as $value) $this->insert('translates', $value);
		foreach ($translate_en as $value) $this->insert('translates', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-sitemap-sitemap_id', 'sitemap');
        $this->dropIndex(
            '{{%idx-sitemap-sitemap_id}}',
            '{{%sitemap}}'
        );
        $this->dropTable('{{%sitemap}}');
    }
}
