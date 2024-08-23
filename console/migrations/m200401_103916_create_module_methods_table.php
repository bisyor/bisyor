<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%module_methods}}`.
 */
class m200401_103916_create_module_methods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%module_methods}}', [
            'id' => $this->primaryKey(),
            'module' => $this->string(255)->comment("Модуль"),
            'method' => $this->string(255)->comment("Метод"),
            'title' => $this->string(255)->comment("Заголовок"),
            'number' => $this->integer()->comment("Сортировка"),
        ]);

        $module_methods = array(
          array('module' => 'banners','method' => 'banners','title' => 'Баннеры', 'number' => '70'),
          array('module' => 'banners','method' => 'listing','title' => 'Просмотр списка баннеров / позиций баннеров','number' => '1'),
          array('module' => 'banners','method' => 'edit','title' => 'Управление баннерами / позициями баннеров','number' => '2'),
          array('module' => 'bills','method' => 'bills','title' => 'Счета','number' => '65'),
          array('module' => 'bills','method' => 'listing','title' => 'Просмотр списка счетов','number' => '1'),
          array('module' => 'bills','method' => 'manage','title' => 'Управление счетами','number' => '2'),
          array('module' => 'bills','method' => 'payways','title' => 'Способы оплаты','number' => '3'),
          array('module' => 'blog','method' => 'blog','title' => 'Блог','number' => '90'),
          array('module' => 'blog','method' => 'posts','title' => 'Управление постами','number' => '1'),
          array('module' => 'blog','method' => 'categories','title' => 'Управление категориями','number' => '2'),
          array('module' => 'blog','method' => 'tags','title' => 'Управление тегами','number' => '3'),
          array('module' => 'blog','method' => 'seo','title' => 'SEO','number' => '4'),
          array('module' => 'blog','method' => 'settings','title' => 'Дополнительные настройки','number' => '5'),
          array('module' => 'contacts','method' => 'contacts','title' => 'Контакты','number' => '115'),
          array('module' => 'contacts','method' => 'manage','title' => 'Управление контактами','number' => '1'),
          array('module' => 'help','method' => 'help','title' => 'Помощь','number' => '100'),
          array('module' => 'help','method' => 'questions','title' => 'Управление вопросами','number' => '1'),
          array('module' => 'help','method' => 'categories','title' => 'Управление категориями','number' => '2'),
          array('module' => 'help','method' => 'seo','title' => 'SEO','number' => '3'),
          array('module' => 'internalmail','method' => 'internalmail','title' => 'Сообщения','number' => '80'),
          array('module' => 'internalmail','method' => 'my','title' => 'Личная переписка','number' => '1'),
          array('module' => 'internalmail','method' => 'spy','title' => 'Просмотр переписки пользователей','number' => '2'),
          array('module' => 'sendmail','method' => 'sendmail','title' => 'Работа с почтой','number' => '120'),
          array('module' => 'sendmail','method' => 'templates-listing','title' => 'Список шаблонов писем','number' => '1'),
          array('module' => 'sendmail','method' => 'templates-edit','title' => 'Редактирование шаблонов писем','number' => '2'),
          array('module' => 'sendmail','method' => 'massend','title' => 'Массовая рассылка','number' => '3'),
          array('module' => 'shops','method' => 'shops','title' => 'Магазины','number' => '50'),
          array('module' => 'shops','method' => 'shops-listing','title' => 'Просмотр списка магазинов','number' => '1'),
          array('module' => 'shops','method' => 'shops-requests','title' => 'Управление списком запросов на открытие и закрепление','number' => '2'),
          array('module' => 'shops','method' => 'shops-edit','title' => 'Управление магазинами (добавление/редактирование/удаление)','number' => '3'),
          array('module' => 'shops','method' => 'shops-moderate','title' => 'Модерация объявлений (блокирование/одобрение)','number' => '4'),
          array('module' => 'shops','method' => 'claims-listing','title' => 'Просмотр списка жалоб','number' => '5'),
          array('module' => 'shops','method' => 'claims-edit','title' => 'Управление жалобами','number' => '6'),
          array('module' => 'shops','method' => 'categories','title' => 'Управление категориями','number' => '7'),
          array('module' => 'shops','method' => 'svc','title' => 'Управление услугами','number' => '8'),
          array('module' => 'shops','method' => 'abonement','title' => 'Абонемент','number' => '9'),
          array('module' => 'shops','method' => 'seo','title' => 'SEO','number' => '10'),
          array('module' => 'shops','method' => 'settings','title' => 'Дополнительные настройки','number' => '11'),
          array('module' => 'site-pages','method' => 'site-pages','title' => 'Страницы','number' => '110'),
          array('module' => 'site-pages','method' => 'listing','title' => 'Просмотр списка','number' => '1'),
          array('module' => 'site-pages','method' => 'manage','title' => 'Управление страницами','number' => '2'),
          array('module' => 'site','method' => 'site','title' => 'Настройки сайта','number' => '140'),
          array('module' => 'site','method' => 'settings','title' => 'Общие настройки','number' => '1'),
          array('module' => 'site','method' => 'settings-system','title' => 'Системные настройки','number' => '2'),
          array('module' => 'site','method' => 'extensions','title' => 'Дополнения','number' => '3'),
          array('module' => 'site','method' => 'updates','title' => 'Обновления','number' => '4'),
          array('module' => 'site','method' => 'seo','title' => 'SEO','number' => '5'),
          array('module' => 'site','method' => 'regions','title' => 'Регионы','number' => '6'),
          array('module' => 'site','method' => 'counters','title' => 'Счетчики и код','number' => '7'),
          array('module' => 'site','method' => 'currencies','title' => 'Валюты','number' => '8'),
          array('module' => 'site','method' => 'localization','title' => 'Локализация','number' => '9'),
          array('module' => 'sitemap','method' => 'sitemap','title' => 'Карта сайта и меню','number' => '130'),
          array('module' => 'sitemap','method' => 'listing','title' => 'Cписок разделов','number' => '1'),
          array('module' => 'sitemap','method' => 'edit','title' => 'Управление разделами','number' => '2'),
          array('module' => 'users','method' => 'users','title' => 'Пользователи','number' => '60'),
          array('module' => 'users','method' => 'profile','title' => 'Ваш профиль','number' => '1'),
          array('module' => 'users','method' => 'members-listing','title' => 'Список пользователей','number' => '2'),
          array('module' => 'users','method' => 'admins-listing','title' => 'Список администраторов','number' => '3'),
          array('module' => 'users','method' => 'users-edit','title' => 'Управление пользователями','number' => '4'),
          array('module' => 'users','method' => 'users-delete','title' => 'Удаление пользователей','number' => '5'),
          array('module' => 'users','method' => 'ban','title' => 'Блокировка пользователей','number' => '6'),
          array('module' => 'users','method' => 'seo','title' => 'SEO','number' => '7'),
          array('module' => 'users','method' => 'groups-listing','title' => 'Список групп пользователей','number' => '8'),
          array('module' => 'users','method' => 'groups-edit','title' => 'Управление группами пользователей','number' => '9'),
          array('module' => 'bbs','method' => 'bbs','title' => 'Объявления','number' => '40'),
          array('module' => 'bbs','method' => 'items-listing','title' => 'Просмотр списка объявлений','number' => '1'),
          array('module' => 'bbs','method' => 'items-edit','title' => 'Управление объявлениями (добавление/редактирование/удаление)','number' => '2'),
          array('module' => 'bbs','method' => 'items-moderate','title' => 'Модерация объявлений (блокирование/одобрение/продление/активация)','number' => '3'),
          array('module' => 'bbs','method' => 'items-comments','title' => 'Управление комментариями','number' => '4'),
          array('module' => 'bbs','method' => 'items-press','title' => 'Управление печатью в прессу','number' => '5'),
          array('module' => 'bbs','method' => 'items-limits-payed','title' => 'Лимиты','number' => '6'),
          array('module' => 'bbs','method' => 'items-import','title' => 'Импорт объявлений','number' => '7'),
          array('module' => 'bbs','method' => 'items-export','title' => 'Экспорт объявлений','number' => '8'),
          array('module' => 'bbs','method' => 'claims-listing','title' => 'Просмотр списка жалоб','number' => '9'),
          array('module' => 'bbs','method' => 'claims-edit','title' => 'Управление жалобами (модерация/удаление)','number' => '10'),
          array('module' => 'bbs','method' => 'categories','title' => 'Управление категориями','number' => '11'),
          array('module' => 'bbs','method' => 'types','title' => 'Управление типами категорий','number' => '12'),
          array('module' => 'bbs','method' => 'svc','title' => 'Управление услугами','number' => '13'),
          array('module' => 'bbs','method' => 'seo','title' => 'SEO','number' => '14'),
          array('module' => 'bbs','method' => 'settings','title' => 'Дополнительные настройки','number' => '15'),
          array('module' => 'seo','method' => 'seo','title' => 'SEO','number' => '150'),
          array('module' => 'seo','method' => 'landingpages','title' => 'Посадочные страницы','number' => '1'),
          array('module' => 'seo','method' => 'redirects','title' => 'Редиректы','number' => '2')
        );
    
        foreach ($module_methods as $value) $this->insert('module_methods', $value);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%module_methods}}');
    }
}
