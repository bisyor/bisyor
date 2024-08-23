<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings}}`.
 */
class m200409_162410_create_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование настройки"),
            'value' => $this->text()->comment("Значение"),
            'key' => $this->string(255)->comment("Ключ"),
            'group' => $this->string(255)->comment("Группа"),
            'type' => $this->string(255)->comment("Тип полей"),            
        ]);


        ////----------------------------Общие настройки-----------------------
        $site_settings = [
            [
                'name' => 'Логотип',
                'value' => 'bisyor-logo.svg',
                'key' => 'logo',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Название компании',
                'value' => 'Bisyor',
                'key' => 'name',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'E-mail',
                'value' => 'support@bisyor.uz',
                'key' => 'email',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Телефон номер',
                'value' => '+998 97 7071218',
                'key' => 'phone',
                'group' => 'site-settings',
                'type' => 'array'
            ],
            [
                'name' => 'Адрес',
                'value' => 'Узбекистан, Ташекент, Чиланзар',
                'key' => 'address',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'App Store link',
                'value' => 'https://play.google.com/store/apps/details?id=uz.bisyor',
                'key' => 'app_store',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Google Play',
                'value' => 'https://play.google.com/store/apps/details?id=uz.bisyor',
                'key' => 'google_play',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            //sot seti
            [
                'name' => 'Facebook',
                'value' => 'https://facebook.com/bisyor',
                'key' => 'facebook',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Twitter',
                'value' => 'https://twitter.com/bisyor_uz',
                'key' => 'twitter',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Instagram',
                'value' => 'https://instagram.com/bisyoruz',
                'key' => 'instagram',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Youtube',
                'value' => 'https://youtube.com/bisyor',
                'key' => 'youtube',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Telegram',
                'value' => 'https://t.me/bisyor',
                'key' => 'telegram',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Odnoklassniki',
                'value' => 'https://ok.ru/bisyor',
                'key' => 'odnoklassniki',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Название сайта',
                'value' => 'www.bisyor.uz',
                'key' => 'site_name',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Название сайта (Панель администратора)',
                'value' => 'www.bisyor.uz',
                'key' => 'adminka',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Название сайта (SEO)',
                'value' => 'www.bisyor.uz',
                'key' => 'seo_site_name',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Название сайта (Уведомления)',
                'value' => 'Bisyor.uz',
                'key' => 'alert_site_name',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Копирайт',
                'value' => 'Bisyor — Digital Store',
                'key' => 'copyright',
                'group' => 'site-settings',
                'type' => 'text'
            ],
            [
                'name' => 'Дополнительный текст в футере',
                'value' => '224 314 178 предложений от 24 829 магазинов.<br>Обновлено 23.08.2019 в 14:07',
                'key' => 'footer_text',
                'group' => 'site-settings',
                'type' => 'text'
            ],
            [
                'name' => 'Заголовок страницы',
                'value' => 'Заголовок страницы',
                'key' => 'contacts_form_title',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Текст страницы',
                'value' => 'Текст страницы',
                'key' => 'contacts_form_text',
                'group' => 'site-settings',
                'type' => 'text'
            ],
            [
                'name' => 'Причина выключения',
                'value' => '',
                'key' => 'reason_block',
                'group' => 'site-settings',
                'type' => 'text'
            ],
            [
                'name' => 'Заголовок формы контактов',
                'value' => '',
                'key' => 'contacts_form_header',
                'group' => 'site-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Режим',
                'value' => 1,
                'key' => 'enabled',
                'group' => 'site-settings',
                'type' => 'boolean'
            ],
        ];
        ////------------------------------------------------------------------

        ////----------------------------Системные настройки----------------------------
        $system_settings = [
            ////--------------------------Общие------------------------------------------------
            [
                'name' => 'Автор публикации объявлений',
                'value' => '3',
                'key' => 'item_author',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Публикация только авторизованным',
                'value' => 0,
                'key' => 'general_publication_authorized',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Премодерация публикации объявлений',
                'value' => 1,
                'key' => 'general_publication_pre_moderation',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Премодерация объявления после редактирования пользователем',
                'value' => 1,
                'key' => 'general_publication_pre_moderation_update',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Период публикации объявлений',
                'value' => 0,
                'key' => 'general_announcement_period',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Редактирование категории объявления',
                'value' => 0,
                'key' => 'general_editing_item_category',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Пользовательское соглашение при подаче объявления',
                'value' => 0,
                'key' => 'general_agreement_submitting_item',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Срок действия ссылки активации объявления',
                'value' => 3,
                'key' => 'general_activation_link_expiration_day',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Поднятие при повторной публикации',
                'value' => 0,
                'key' => 'general_re_publishing_raise',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Автоматическое удаление объявлений',
                'value' => 0,
                'key' => 'general_auto_deletion_item',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Удаление объявлений неактивных пользователей',
                'value' => 0,
                'key' => 'general_deleting_inactive_user_items',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'SMS уведомления',
                'value' => 0,
                'key' => 'general_sms_alert',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Кол-во объявлений в профиле пользователя',
                'value' => 20,
                'key' => 'general_user_items_pagesize',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Услуга платной публикации объявлений',
                'value' => 1,
                'key' => 'general_limits_payed',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Автоматический перевод объявлений',
                'value' => 0,
                'key' => 'general_automatic_translation',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            ////--------------------------Поиск------------------------------------------------
            [
                'name' => 'Поиск Sphinx',
                'value' => 0,
                'key' => 'search_sphinx',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Тип списка по умолчанию',
                'value' => 1,
                'key' => 'search_list_type',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Конвертация цен в списках',
                'value' => 0,
                'key' => 'search_category_currency',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Результаты поиска',
                'value' => 18,
                'key' => 'search_pagesize',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Быстрый поиск',
                'value' => 5,
                'key' => 'search_quick_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Учитывать фильтр категории',
                'value' => 0,
                'key' => 'search_quick_category',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Уровень подкатегории в фильтре поиска',
                'value' => 8,
                'key' => 'search_filter_catslevel',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Блок премиум-объявлений',
                'value' => 4,
                'key' => 'search_premium_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Учитывать категорию поиска',
                'value' => 0,
                'key' => 'search_premium_category',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Учитывать фильтр региона',
                'value' => 0,
                'key' => 'search_premium_region',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Произвольный порядок вывода',
                'value' => 1,
                'key' => 'search_premium_rand',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'RSS лента',
                'value' => 0,
                'key' => 'search_rss_enabled',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Кол-во объявлений',
                'value' => 18,
                'key' => 'search_rss_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            ////--------------------------Просмотр объявления------------------------------------------------
            [
                'name' => 'Кол-во похожих объявлений',
                'value' => 6,
                'key' => 'view_similar_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Комментирование объявлений',
                'value' => 0,
                'key' => 'view_comments',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Продвинуть объявление',
                'value' => 0,
                'key' => 'view_promote',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Статистика объявления',
                'value' => 3,
                'key' => 'view_statistic_available',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            //  //------------------------Главная-----------------------------------------------------------
            [
                'name' => 'Список объявлений региона на главной',
                'value' => 1,
                'key' => 'index_region_search',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Помечать такие страницы как канонические',
                'value' => 1,
                'key' => 'index_region_search_canonical',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            //  //------------------------Импорт-----------------------------------------------------------
            [
                'name' => 'Возможность импорта объявлений',
                'value' => 2,
                'key' => 'import_access',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Доступность загрузки CSV файлов пользователям',
                'value' => 1,
                'key' => 'import_csv_frontend',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Обновлять срок публикации объявления',
                'value' => 1,
                'key' => 'import_update_republicate',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Срок хранения файлов импорта',
                'value' => 30,
                'key' => 'import_cleanup',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Шаблоны категорий',
                'value' => 1,
                'key' => 'import_title_auto',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            //  //-----------------------SEO--------------------------------------------------------------
            [
                'name' => 'Ссылки на пустые категорий в фильтре',
                'value' => 1,
                'key' => 'seo_filter_cats_empty',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Индексировать пустые категории',
                'value' => 1,
                'key' => 'seo_cats_empty_index',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Ограничение длины описания объявления',
                'value' => 150,
                'key' => 'seo_view_meta_description_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            ////----------------------------------Магазины---------------------------------------------------
            //  //--------------------------------Общие------------------------------------------------------
            [
                'name' => 'Поиск Sphinx',
                'value' => 1,
                'key' => 'shops_search_sphinx',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Премодерация магазинов',
                'value' => 1,
                'key' => 'shops_premoderation',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Категории магазинов',
                'value' => 1,
                'key' => 'shops_categories',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Кол-во категорий магазинов',
                'value' => 20,
                'key' => 'shops_category_count',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Кол-во магазинов в списке',
                'value' => 20,
                'key' => 'shops_categories_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Услуга абонемент',
                'value' => 1,
                'key' => 'shops_abonement',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Лимит объявлений магазина без тарифного плана',
                'value' => 10,
                'key' => 'shops_abonement_default_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            //  //--------------------------------Профиль магазина--------------------------------------------
            [
                'name' => 'Название',
                'value' => 50,
                'key' => 'shops_form_title_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Описание',
                'value' => 1000,
                'key' => 'shops_form_descr_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Кол-во доступных номеров телефонов',
                'value' => 4,
                'key' => 'shops_phones_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Кол-во ссылок соц. сетей',
                'value' => 5,
                'key' => 'shops_social_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Кол-во объявлений в профиле магазина',
                'value' => 18,
                'key' => 'shop_items_pagesize',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            ////---------------------------------------Пользователи---------------------------------------------
            //  //-------------------------------------Общие------------------------------------------------------
            [
                'name' => 'Способ регистрации',
                'value' => 2,
                'key' => 'users_register_type',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Номер телефона в профиле',
                'value' => 0,
                'key' => 'users_register_phone_contacts',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Капча при регистрации',
                'value' => 0,
                'key' => 'users_register_captcha',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Подтверждение пароля',
                'value' => 1,
                'key' => 'users_register_passconfirm',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Подтверждение email или тел. при регистрации через соц. сеть',
                'value' => 1,
                'key' => 'users_register_social_email_activation',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Кол-во доступных номеров телефонов',
                'value' => 2,
                'key' => 'users_profile_phones',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Редактирование контактных данных',
                'value' => 1,
                'key' => 'users_settings_contacts',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Редактирование email адреса',
                'value' => 1,
                'key' => 'users_settings_email_change',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Временные email адреса',
                'value' => 0,
                'key' => 'users_email_temporary_check',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Сгенерированные email адреса',
                'value' => '{name}-fake@{host}',
                'key' => 'users_fake_email_template',
                'group' => 'system-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Удаление учетной записи',
                'value' => 2,
                'key' => 'users_settings_destroy',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            //  //-------------------------------------Телефон------------------------------------------------------
            [
                'name' => 'Кол-во повторных отправок SMS',
                'value' => 3,
                'key' => 'users_sms_retry_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Таймаут повторной отправки SMS',
                'value' => 3,
                'key' => 'users_sms_retry_timeout',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Код для проверки',
                'value' => 2,
                'key' => 'users_sms_code_type',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Длина кода для проверки',
                'value' => 4,
                'key' => 'users_sms_code_length',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Сокращение ссылок в SMS',
                'value' => 0,
                'key' => 'users_sms_links_short',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            ////--------------------------------------Сообщения-------------------------------------------------
            [
                'name' => 'Вложения',
                'value' => 1,
                'key' => 'internalmail_attachments',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Папки',
                'value' => 1,
                'key' => 'internalmail_folders',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Капча в форме "связаться с автором"',
                'value' => 0,
                'key' => 'internalmail_users_write_form_captcha',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Авторизация для формы "связаться с автором"',
                'value' => 0,
                'key' => 'internalmail_users_write_form_logined',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Ограничение контактов',
                'value' => 0,
                'key' => 'internalmail_contacts_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            ////--------------------------------------Блог--------------------------------------------------------
            [
                'name' => 'Кол-во в списке',
                'value' => 8,
                'key' => 'blog_list_pagesize',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Кол-во в списке категории',
                'value' => 8,
                'key' => 'blog_list_category_pagesize',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Категории постов',
                'value' => 1,
                'key' => 'blog_categories',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Теги',
                'value' => 1,
                'key' => 'blog_tags',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Кол-во тегов в облаке тегов',
                'value' => 3,
                'key' => 'blog_tags_cloud_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Кол-во в списке по тегу',
                'value' => 8,
                'key' => 'blog_list_tag_pagesize',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Блок постов на главной',
                'value' => 3,
                'key' => 'blog_last_block_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Изображения в блоке последних',
                'value' => 1,
                'key' => 'blog_last_block_preview',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Блок поделиться',
                'value' => '<script type="text/javascript">(function() {
                              if (window.pluso)if (typeof window.pluso.start == "function") return;
                              if (window.ifpluso==undefined) { window.ifpluso = 1;
                                var d = document, s = d.createElement("script"), g = "getElementsByTagName";
                                s.type = "text/javascript"; s.charset="UTF-8"; s.async = true;
                                s.src = ("https:" == window.location.protocol ? "https" : "http")  + "://share.pluso.ru/pluso-like.js";
                                var h=d[g]("body")[0];
                                h.appendChild(s);
                              }})();</script>
                            <div class="pluso" data-background="transparent" data-options="small,round,line,horizontal,nocounter,theme=06" data-services="facebook,vkontakte,google,twitter,odnoklassniki,moimir,yandex"></div>',
                'key' => 'blog_view_sharecode',
                'group' => 'system-settings',
                'type' => 'text'
            ],
            ////-------------------------------------------Помощь--------------------------------------------------
            [
                'name' => 'Кол-во в списке',
                'value' => 10,
                'key' => 'help_search_pagesize',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Альтернативный редактор',
                'value' => 1,
                'key' => 'help_questions_form_wysiwyg',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            ////-------------------------------------------Контакты------------------------------------------------
            [
                'name' => 'Капча в форме',
                'value' => 1,
                'key' => 'contacts_captcha',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Уведомление от имени отправителя',
                'value' => 1,
                'key' => 'contacts_from_sender',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            ////--------------------------------------------Гео---------------------------------------------------
            [
                'name' => 'Автоопределение региона',
                'value' => 1,
                'key' => 'geo_ip_location',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Тип карт',
                'value' => 2,
                'key' => 'geo_maps_type',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'API ключ карт Yandex',
                'value' => 2,
                'key' => 'geo_maps_yandexKey',
                'group' => 'system-settings',
                'type' => 'text'
            ],
            [
                'name' => 'API ключ карт Google',
                'value' => 'AIzaSyBvRtwcs1xCgBgOjglSQKLCLQ3DUpHgiYk',
                'key' => 'geo_maps_googleKey',
                'group' => 'system-settings',
                'type' => 'text'
            ],
            [
                'name' => 'Координаты X',
                'value' => '55.7481',
                'key' => 'geo_maps_default_coords_x',
                'group' => 'system-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Координаты Y',
                'value' => '37.6206',
                'key' => 'geo_maps_default_coords_y',
                'group' => 'system-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Районы города',
                'value' => 1,
                'key' => 'geo_districts',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Фильтр по региону',
                'value' => 2,
                'key' => 'geo_filter_url',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Список предвыбранных городов',
                'value' => 15,
                'key' => 'geo_city_select_presuggest_limit',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            ////--------------------------------------------SEO---------------------------------------------------
            [
                'name' => 'Ограничение длины заголовка',
                'value' => 1000,
                'key' => 'seo_meta_limit_mtitle',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Ограничение длины ключевых слов',
                'value' => 250,
                'key' => 'seo_meta_limit_mkeywords',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Ограничение длины описания',
                'value' => 300,
                'key' => 'seo_meta_limit_mdescription',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Посадочные страницы',
                'value' => 1,
                'key' => 'seo_landing_pages_enabled',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Редиректы',
                'value' => 1,
                'key' => 'seo_redirects',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Индексация пустых списков',
                'value' => 1,
                'key' => 'seo_lists_empty_index',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Индексация страниц постраничной навигации',
                'value' => 1,
                'key' => 'seo_pages_index',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Канонические страницы постраничной навигации',
                'value' => 1,
                'key' => 'seo_pages_canonical',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Мультиязычность Sitemap.xml',
                'value' => 2,
                'key' => 'seo_site_sitemapXML_langs',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            ////-------------------------------------------Другие--------------------------------------------------
            //  //-----------------------------------------Общие---------------------------------------------------
            [
                'name' => 'Валюта сайта по умолчанию',
                'value' => 1,
                'key' => 'other_currency_default',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Обновление курса валют',
                'value' => 0,
                'key' => 'other_currency_rate_auto',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Автоопределение языка',
                'value' => 1,
                'key' => 'other_locale_accepted_languages',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Минимизация js/css',
                'value' => 1,
                'key' => 'other_site_static_minify',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Объединять файлы css',
                'value' => 1,
                'key' => 'other_site_static_minify_bundle',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Sphinx',
                'value' => 1,
                'key' => 'other_sphinx_enabled',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Host',
                'value' => '127.0.0.1',
                'key' => 'other_sphinx_host',
                'group' => 'system-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Port',
                'value' => '9306',
                'key' => 'other_sphinx_port',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Путь',
                'value' => '/var/lib/sphinx/',
                'key' => 'other_sphinx_path',
                'group' => 'system-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Version',
                'value' => '2.2.11',
                'key' => 'other_sphinx_version',
                'group' => 'system-settings',
                'type' => 'string'
            ],
            //  //------------------------------------------Почта-------------------------------------------------
            [
                'name' => 'Имя отправителя',
                'value' => 'Bisyor.uz',
                'key' => 'other_mail_fromname',
                'group' => 'system-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Email для уведомлений',
                'value' => 'noreply@bisyor.uz',
                'key' => 'other_mail_noreply',
                'group' => 'system-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Email администратора',
                'value' => 'admin@bisyor.uz',
                'key' => 'other_mail_admin',
                'group' => 'system-settings',
                'type' => 'string'
            ],
            [
                'name' => 'Метод отправки писем',
                'value' => 1,
                'key' => 'other_mail_method',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            //  //------------------------------------------Системные---------------------------------------------
            [
                'name' => 'Временная зона',
                'value' => 'Asia/Tashkent',
                'key' => 'other_date_timezone',
                'group' => 'system-settings',
                'type' => 'string'
            ],
            [
                'name' => 'HTTPS-режим',
                'value' => 1,
                'key' => 'other_https_only',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Редирект c HTTP',
                'value' => 1,
                'key' => 'other_https_redirect',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Проверка доставляемости почты',
                'value' => 1,
                'key' => 'other_hh_mailcheck_enabled',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Статистика работы системы',
                'value' => 1,
                'key' => 'other_hh_stat_allowed',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Срок публикации объявления',
                'value' => 30,
                'key' => 'the_term_of_publication_of_the_announcement',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Срок продления объявления',
                'value' => 365,
                'key' => 'the_term_of_ad_renewal_period_365',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'Уведомлять пользователей о завершении публикации объявлений',
                'value' => 1,
                'key' => 'notify_users_of_the_completion_of_publishing_ads_the_1_day',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Уведомлять пользователей о завершении публикации объявлений',
                'value' => 1,
                'key' => 'notify_users_of_the_completion_of_publishing_ads_the_2_day',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Уведомлять пользователей о завершении публикации объявлений',
                'value' => 1,
                'key' => 'notify_users_of_the_completion_of_publishing_ads_the_5_day',
                'group' => 'system-settings',
                'type' => 'boolean'
            ],
            [
                'name' => 'Код для страницы "Просмотр объявления"',
                'value' => '<script type="text/javascript">(function() {
                              if (window.pluso)if (typeof window.pluso.start == "function") return;
                              if (window.ifpluso==undefined) { window.ifpluso = 1;
                                var d = document, s = d.createElement("script"), g = "getElementsByTagName";
                                s.type = "text/javascript"; s.charset="UTF-8"; s.async = true;
                                s.src = ("https:" == window.location.protocol ? "https" : "http")  + "://share.pluso.ru/pluso-like.js";
                                var h=d[g]("body")[0];
                                h.appendChild(s);
                              }})();</script>
                            <div class="pluso" data-background="transparent" data-options="small,round,line,horizontal,nocounter,theme=06" data-services="facebook,vkontakte,google,twitter,odnoklassniki,moimir,yandex"></div>',
                'key' => 'code_for_the_page_view_ads',
                'group' => 'system-settings',
                'type' => 'text'
            ],
            [
                'name' => 'Общее количество предметов в новых товарах',
                'value' => 20,
                'key' => 'general_item_count_in_new_items',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
            [
                'name' => 'в днях, 0 - без органичений',
                'value' => 30,
                'key' => 'period_items_count',
                'group' => 'system-settings',
                'type' => 'integer'
            ],
        ];
        ////------------------------------------------------------------------

        foreach ($site_settings as $key => $value) {
            $this->insert('{{%settings}}',array(
                    'name' => $value['name'],
                    'value' => $value['value'],
                    'key' => $value['key'],
                    'group' => $value['group'],
                    'type' => $value['type']
                ));
        }

        foreach ($system_settings as $key => $value) {
            $this->insert('{{%settings}}',array(
                    'name' => $value['name'],
                    'value' => $value['value'],
                    'key' => $value['key'],
                    'group' => $value['group'],
                    'type' => $value['type']
                ));
        }


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }
}
