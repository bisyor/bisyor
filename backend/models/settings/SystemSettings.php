<?php

namespace backend\models\settings;

use Yii;
use backend\models\references\Translates;
use yii\helpers\ArrayHelper;

class SystemSettings extends Settings
{
    public $tab;

    //tab1 Обновление
        //tab1-1 Общие
    public $item_author;
    public $general_publication_authorized;
    public $general_publication_pre_moderation;
    public $general_announcement_period;
    public $general_publication_pre_moderation_update;
    public $general_editing_item_category;
    public $general_agreement_submitting_item;
    public $general_activation_link_expiration_day;
    public $general_re_publishing_raise;
    public $general_auto_deletion_item;
    public $general_deleting_inactive_user_items;
    public $general_sms_alert;
    public $general_user_items_pagesize;
    public $general_limits_payed;
    public $general_automatic_translation;
    public $period_items_count;
    public $general_premium_view_type;
    public $recommendation_count;
    public $recommendation_categories_count;
    public $last_item_count_in_new_items;
        //tab1-2 Поиск
    public $search_sphinx;
    public $search_list_type;
    public $search_category_currency;
    public $search_pagesize;
    public $search_quick_limit;
    public $search_quick_category;
    public $search_filter_catslevel;
    public $search_premium_limit;
    public $search_premium_category;
    public $search_premium_region;
    public $search_premium_rand;
    public $search_rss_enabled;
    public $search_rss_limit;
    public $sms_service_message;
        //tab1-3 Просмотр объявления
    public $view_similar_limit;
    public $view_comments;
    public $view_promote;
    public $view_statistic_available;
    public $sms_service;
    public $sms_service_token;

    //tab1-4 Главная
    public $index_region_search;
    public $index_region_search_canonical;
        //tab1-5 Импорт
    public $import_access;
    public $import_csv_frontend;
    public $import_update_republicate;
    public $import_cleanup;
    public $import_title_auto;
        //tab1-6 SEO
    public $seo_filter_cats_empty;
    public $seo_cats_empty_index;
    public $seo_view_meta_description_limit;


    //tab2 Магазины
        //tab2-1 Общие
    public $shops_search_sphinx;
    public $shops_premoderation;
    public $shops_categories;
    public $shops_category_count;
    public $shops_categories_limit;
    public $shops_abonement;
    public $shops_abonement_default_limit;
        //tab2-2 Профиль магазина
    public $shops_form_title_limit;
    public $shops_form_descr_limit;
    public $shops_phones_limit;
    public $shops_social_limit;
    public $shop_items_pagesize;
 
    //tab3 Пользователи
        //tab3-1 Общие
    public $users_register_type;
    public $users_register_phone_contacts;
    public $users_register_captcha;
    public $users_register_passconfirm;
    public $users_register_social_email_activation;
    public $users_profile_phones;
    public $users_settings_contacts;
    public $users_settings_email_change;
    public $users_email_temporary_check;
    public $users_fake_email_template;
    public $users_settings_destroy;
    public $bonus_for_user;
    public $bonus_to_the_user_for_entering_the_platform_once_a_day;
        //tab3-2 Телефон
    public $users_sms_retry_limit;
    public $users_sms_retry_timeout;
    public $users_sms_code_type;
    public $users_sms_code_length;
    public $users_sms_links_short;

    //tab4 Сообщения
    public $internalmail_attachments;
    public $internalmail_folders;
    public $internalmail_users_write_form_captcha;
    public $internalmail_users_write_form_logined;
    public $internalmail_contacts_limit;

    //tab5 Блог
    public $blog_list_pagesize;
    public $blog_list_category_pagesize;
    public $blog_categories;
    public $blog_tags;
    public $blog_tags_cloud_limit;
    public $blog_list_tag_pagesize;
    public $blog_last_block_limit;
    public $blog_last_block_preview;
    public $blog_view_sharecode;

    //tab6 Помощь
    public $help_search_pagesize;
    public $help_questions_form_wysiwyg;

    //tab7 Контакты
    public $contacts_captcha;
    public $contacts_from_sender;

    //tab8 Гео
    public $geo_ip_location;
    public $geo_maps_type;
    public $geo_maps_yandexKey;
    public $geo_maps_googleKey;
    public $geo_maps_default_coords_x;
    public $geo_maps_default_coords_y;
    public $geo_districts;
    public $geo_filter_url;
    public $geo_city_select_presuggest_limit;

    //tab9 SEO
    public $seo_meta_limit_mtitle;
    public $seo_meta_limit_mkeywords;
    public $seo_meta_limit_mdescription;
    public $seo_landing_pages_enabled;
    public $seo_redirects;
    public $seo_lists_empty_index;
    public $seo_pages_index;
    public $seo_pages_canonical;
    public $seo_site_sitemapXML_langs;

    //tab 10 Другие
        //tab10-1 Общие
    public $other_currency_default;
    public $other_currency_rate_auto;
    public $other_locale_accepted_languages;
    public $other_site_static_minify;
    public $other_site_static_minify_bundle;
    public $other_sphinx_enabled;
    public $other_sphinx_host;
    public $other_sphinx_port;
    public $other_sphinx_path;
    public $other_sphinx_version;
        //tab10-2 Почта
    public $other_mail_fromname;
    public $other_mail_noreply;
    public $other_mail_admin;
    public $other_mail_method;
        //tab10-3 Системные
    public $other_date_timezone;
    public $other_https_only;
    public $other_https_redirect;
    public $other_hh_mailcheck_enabled;
    public $other_hh_stat_allowed;


    // items stettings
    public $code_for_the_page_view_ads;
    public $notify_users_of_the_completion_of_publishing_ads_the_5_day;
    public $notify_users_of_the_completion_of_publishing_ads_the_2_day;
    public $notify_users_of_the_completion_of_publishing_ads_the_1_day;
    public $the_term_of_ad_renewal_period_365;
    public $the_term_of_publication_of_the_announcement;
    public $general_item_count_in_new_items;

    public $telegram_bot;

    const GROUP = 'system-settings';
     /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }



    /**
     * /bazadagi settings jadvaliga ko'ra labellarni olish
     * @return array|string[]
     * @throws \Throwable
     */
    public function attributeLabels()
    {
        $rows = Settings::getDb()->cache(function ($db) {
            return Settings::find()->where(['group' => self::GROUP])->all();
        });
        return \yii\helpers\ArrayHelper::map($rows,'key','name');
    }


    /**
     * konstruktor bazadagi settings table asosida model maydonlariga boshlang'ich qiymatlar berish
     * SystemSettings constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $values = Settings::find()->where(['group' => self::GROUP])->all();
        foreach ($values as $key => $value) {
            $this->{$value->key} = ($value->type == 'array') ? explode(",",$value->value) : $value->value;
        }
        $this->tab =  isset($_COOKIE["tab-settings"]) ? $_COOKIE["tab-settings"] : 'tab-1';
        parent::__construct();
    }


    /**
     * saqlash
     * @param $post
     */
    public function saveModel($post)
    {
        $rows = Settings::find()->where(['group' => self::GROUP])->all();
        
        foreach ($rows as $value) {
            if(isset($post['SystemSettings'][$value->key]) && $post['SystemSettings'][$value->key] != ''){
                $value->value = $post['SystemSettings'][$value->key];
                $value->save(false);
            }
        }
    }


    /**
     * pasdagila dropDownlist uchun kerakli methodlar
     * @return string[]
     */
    public function getItemAuthor()
    {
        return [
            1 => 'Только пользователь',
            2 => 'Только магазин',
            3 => 'Пользователь или магазин',
            4 => 'Пользователь и магазин'
        ];
    }


    /**
     * pasdagila dropDownlist uchun kerakli methodlar
     * @return string[]
     */
    public function getItemsPrimumType()
    {
        return [
            1 => 'Слайд',
            2 => 'Лист'
        ];
    }


    /**
     * turn off turn on
     * @return string[]
     */
    public function getStatus()
    {
        return [
            0 => 'выключено',
            1 => 'включено'
        ];
    }

    public function getSmsService()
    {
        return [
            1 => 'Смс сервисе Эскиз',
            2 => 'Наш смс сервис'
        ];
    }


    /**
     * @return string[]
     */
    public function getState()
    {
        return [
            0 => 'недоступно',
            1 => 'доступно'
        ];
    }


    /**
     * @return string[]
     */
    public function getShowOrNot()
    {
        return [
            0 => 'скрыть',
            1 => 'отображать'
        ];
    }


    /**
     * @return string[]
     */
    public function getGeneralDeletingInactiveUserItems()
    {
        return [
            0 => 'выключено',
            30 => '1 месяц',
            61 => '2 месяца',
            92 => '3 месяца', 
            183 => '6 месяцев', 
            274 => '9 месяцев', 
            365 => '1 год', 
            730 => '2 года'
        ];
    }


    /**
     * @return string[]
     */
    public function getGeneralSmsAlert()
    {
        return [
            0 => 'Отключены', 
            1 => 'Для всех объявлений', 
            2 => 'Уведомления отправляются только для объявлений с активной услугой "Премиум"'
        ];
    }


    /**
     * @return string[]
     */
    public function getGeneralAutomaticTranslation()
    {
        return [
            0 => 'выключено', 
            1 => 'Google'
        ];
    }


    /**
     * @return string[]
     */
    public function getListType()
    {
        return [
            1 => 'Список', 
            2 => 'Галерея'    
        ];
    }


    /**
     * @return string[]
     */
    public function getViewPromote()
    {
        return [
            0 => 'всем', 
            1 => 'авторизованным', 
            2 => 'владельцу объявления'
        ];
    }


    /**
     * @return string[]
     */
    public function getImportAccess()
    {
        return [
            0 => 'только администратору', 
            1 => 'избранным магазинам', 
            2 => 'всем магазинам',
        ];
    }


    /**
     * @return string[]
     */
    public function getRegisterType()
    {
        return [
            1 => 'Только E-mail*',
            2 => 'Телефон* + Email*',
            3 => 'Телефон* + Email'
        ];
    }


    /**
     * @return string[]
     */
    public function getSettingsDestroy()
    {
        return [
            0 => 'недоступно',
            1 => 'полное удаление',
            2 => 'блокировка'
        ];
    }


    /**
     * @return string[]
     */
    public function getSmsCodeType()
    {
        return [
            1 => 'буквенно-цифровой',
            2 => 'цифровой'
        ];
    }


    /**
     * @return string[]
     */
    public function getMapType()
    {
        return [
            1 => 'Карты Yandex', 
            2 => 'Карты Google'
        ];
    }


    /**
     * @return string[]
     */
    public function getFilterUrl()
    {
        return [
            1 => 'определяется по URL', 
            2 => 'фиксируется пользователем'
        ];
    }


    /**
     * @return string[]
     */
    public function getSeoSiteLang()
    {
        return [
            0 => 'выключено', 
            1 => 'страницы с переводом', 
            2 => 'все'
        ];
    }


    /**
     * @return array
     * @throws \Throwable
     */
    public function getCurrencyList()
    {

        $data = \backend\models\references\Currencies::getDb()->cache(function ($db) {
             return \backend\models\references\Currencies::find()->where(['enabled' => 1])->all();
        });
        return ArrayHelper::map($data,'id','name');
    }


    /**
     * @return string[]
     */
    public function getMailMethod()
    {
        return [
            1 => 'Стандартный (php mail)',
            2 => 'SMTP',
            3 => 'Sendmail'
        ];
    }


    /**
    * Get timezones list
    * @return array
    */
    public function getTimeZones () {
        return [
            'Africa' => [
                'Africa/Algiers' => 'Algeria (+01:00)',
                'Africa/Gaborone' => 'Botswana (+02:00)',
                'Africa/Douala' => 'Cameroon (+01:00)',
                'Africa/Bangui' => 'Central African Republic (+01:00)',
                'Africa/Ndjamena' => 'Chad (+01:00)',
                'Africa/Kinshasa' => 'Democratic Republic of the Congo (+01:00)',
                'Africa/Djibouti' => 'Djibouti (+03:00)',
                'Africa/Cairo' => 'Egypt (+02:00)',
                'Africa/Malabo' => 'Equatorial Guinea (+01:00)',
                'Africa/Asmara' => 'Eritrea (+03:00)',
                'Africa/Addis_Ababa' => 'Ethiopia (+03:00)',
                'Africa/Libreville' => 'Gabon (+01:00)',
                'Africa/Banjul' => 'Gambia (+00:00)',
                'Africa/Accra' => 'Ghana (+00:00)',
                'Africa/Conakry' => 'Guinea (+00:00)',
                'Africa/Bissau' => 'Guinea-Bissau (+00:00)',
                'Africa/Abidjan' => 'Ivory Coast (+00:00)',
                'Africa/Nairobi' => 'Kenya (+03:00)',
                'Africa/Maseru' => 'Lesotho (+02:00)',
                'Africa/Monrovia' => 'Liberia (+00:00)',
                'Africa/Tripoli' => 'Libya (+02:00)',
                'Africa/Blantyre' => 'Malawi (+02:00)',
                'Africa/Bamako' => 'Mali (+00:00)',
                'Africa/Nouakchott' => 'Mauritania (+00:00)',
                'Africa/Casablanca' => 'Morocco (+01:00)',
                'Africa/Maputo' => 'Mozambique (+02:00)',
                'Africa/Windhoek' => 'Namibia (+01:00)',
                'Africa/Niamey' => 'Niger (+01:00)',
                'Africa/Lagos' => 'Nigeria (+01:00)',
                'Africa/Brazzaville' => 'Republic of the Congo (+01:00)',
                'Africa/Kigali' => 'Rwanda (+02:00)',
                'Africa/Sao_Tome' => 'Sao Tome and Principe (+00:00)',
                'Africa/Dakar' => 'Senegal (+00:00)',
                'Africa/Freetown' => 'Sierra Leone (+00:00)',
                'Africa/Mogadishu' => 'Somalia (+03:00)',
                'Africa/Johannesburg' => 'South Africa (+02:00)',
                'Africa/Juba' => 'South Sudan (+03:00)',
                'Africa/Khartoum' => 'Sudan (+03:00)',
                'Africa/Mbabane' => 'Swaziland (+02:00)',
                'Africa/Dar_es_Salaam' => 'Tanzania (+03:00)',
                'Africa/Lome' => 'Togo (+00:00)',
                'Africa/Tunis' => 'Tunisia (+01:00)',
                'Africa/Kampala' => 'Uganda (+03:00)',
                'Africa/El_Aaiun' => 'Western Sahara (+00:00)',
                'Africa/Lusaka' => 'Zambia (+02:00)',
                'Africa/Harare' => 'Zimbabwe (+02:00)',
            ],

            'America' => [
                'America/Nassau' => 'Bahamas (-04:00)',
                'America/Belize' => 'Belize (-06:00)',
                'America/Noronha' => 'Brazil (-02:00)',
                'America/Tortola' => 'British Virgin Islands (-04:00)',
                'America/St_Johns' => 'Canada (-02:30)',
                'America/Cayman' => 'Cayman Islands (-05:00)',
                'America/Santiago' => 'Chile (-04:00)',
                'America/Bogota' => 'Colombia (-05:00)',
                'America/Costa_Rica' => 'Costa Rica (-06:00)',
                'America/Havana' => 'Cuba (-04:00)',
                'America/Curacao' => 'Curaçao (-04:00)',
                'America/Dominica' => 'Dominica (-04:00)',
                'America/Santo_Domingo' => 'Dominican Republic (-04:00)',
                'America/Guayaquil' => 'Ecuador (-05:00)',
                'America/El_Salvador' => 'El Salvador (-06:00)',
                'America/Cayenne' => 'French Guiana (-03:00)',
                'America/Godthab' => 'Greenland (-02:00)',
                'America/Grenada' => 'Grenada (-04:00)',
                'America/Guadeloupe' => 'Guadeloupe (-04:00)',
                'America/Guatemala' => 'Guatemala (-06:00)',
                'America/Guyana' => 'Guyana (-04:00)',
                'America/Port-au-Prince' => 'Haiti (-05:00)',
                'America/Tegucigalpa' => 'Honduras (-06:00)',
                'America/Jamaica' => 'Jamaica (-05:00)',
                'America/Martinique' => 'Martinique (-04:00)',
                'America/Mexico_City' => 'Mexico (-05:00)',
                'America/Montserrat' => 'Montserrat (-04:00)',
                'America/Managua' => 'Nicaragua (-06:00)',
                'America/Panama' => 'Panama (-05:00)',
                'America/Asuncion' => 'Paraguay (-04:00)',
                'America/Lima' => 'Peru (-05:00)',
                'America/Puerto_Rico' => 'Puerto Rico (-04:00)',
                'America/St_Kitts' => 'Saint Kitts and Nevis (-04:00)',
                'America/St_Lucia' => 'Saint Lucia (-04:00)',
                'America/Marigot' => 'Saint Martin (-04:00)',
                'America/Miquelon' => 'Saint Pierre and Miquelon (-02:00)',
                'America/St_Vincent' => 'Saint Vincent and the Grenadines (-04:00)',
                'America/Lower_Princes' => 'Sint Maarten (-04:00)',
                'America/Paramaribo' => 'Suriname (-03:00)',
                'America/Port_of_Spain' => 'Trinidad and Tobago (-04:00)',
                'America/Grand_Turk' => 'Turks and Caicos Islands (-04:00)',
                'America/St_Thomas' => 'U.S. Virgin Islands (-04:00)',
                'America/New_York' => 'United States (-04:00)',
                'America/Montevideo' => 'Uruguay (-03:00)',
                'Europe/Vatican' => 'Vatican (+02:00)',
                'America/Caracas' => 'Venezuela (-04:30)',
            ],

            'Arctic' => [
                'Arctic/Longyearbyen' => 'Svalbard and Jan Mayen (+02:00)',
            ],

            'Asia' => [
                'Asia/Thimphu' => 'Bhutan (+06:00)',
                'Asia/Phnom_Penh' => 'Cambodia (+07:00)',
                'Asia/Shanghai' => 'China (+08:00)',
                'Asia/Nicosia' => 'Cyprus (+03:00)',
                'Asia/Dili' => 'East Timor (+09:00)',
                'Asia/Tbilisi' => 'Georgia (+04:00)',
                'Asia/Hong_Kong' => 'Hong Kong (+08:00)',
                'Asia/Kolkata' => 'India (+05:30)',
                'Asia/Jakarta' => 'Indonesia (+07:00)',
                'Asia/Tehran' => 'Iran (+04:30)',
                'Asia/Baghdad' => 'Iraq (+03:00)',
                'Asia/Jerusalem' => 'Israel (+03:00)',
                'Asia/Tokyo' => 'Japan (+09:00)',
                'Asia/Amman' => 'Jordan (+03:00)',
                'Asia/Almaty' => 'Kazakhstan (+06:00)',
                'Asia/Kuwait' => 'Kuwait (+03:00)',
                'Asia/Bishkek' => 'Kyrgyzstan (+06:00)',
                'Asia/Vientiane' => 'Laos (+07:00)',
                'Asia/Beirut' => 'Lebanon (+03:00)',
                'Asia/Macau' => 'Macao (+08:00)',
                'Asia/Kuala_Lumpur' => 'Malaysia (+08:00)',
                'Asia/Ulaanbaatar' => 'Mongolia (+08:00)',
                'Asia/Rangoon' => 'Myanmar (+06:30)',
                'Asia/Kathmandu' => 'Nepal (+05:45)',
                'Asia/Pyongyang' => 'North Korea (+09:00)',
                'Asia/Muscat' => 'Oman (+04:00)',
                'Asia/Karachi' => 'Pakistan (+05:00)',
                'Asia/Gaza' => 'Palestinian Territory (+02:00)',
                'Asia/Manila' => 'Philippines (+08:00)',
                'Asia/Qatar' => 'Qatar (+03:00)',
                'Asia/Riyadh' => 'Saudi Arabia (+03:00)',
                'Asia/Singapore' => 'Singapore (+08:00)',
                'Asia/Seoul' => 'South Korea (+09:00)',
                'Asia/Colombo' => 'Sri Lanka (+05:30)',
                'Asia/Damascus' => 'Syria (+03:00)',
                'Asia/Taipei' => 'Taiwan (+08:00)',
                'Asia/Dushanbe' => 'Tajikistan (+05:00)',
                'Asia/Bangkok' => 'Thailand (+07:00)',
                'Asia/Ashgabat' => 'Turkmenistan (+05:00)',
                'Asia/Samarkand' => 'Uzbekistan (+05:00)',
                'Asia/Ho_Chi_Minh' => 'Vietnam (+07:00)',
                'Asia/Aden' => 'Yemen (+03:00)',
            ],

            'Atlantic' => [
                'Atlantic/Cape_Verde' => 'Cape Verde (-01:00)',
                'Atlantic/Stanley' => 'Falkland Islands (-03:00)',
                'Atlantic/Faroe' => 'Faroe Islands (+01:00)',
                'Atlantic/Reykjavik' => 'Iceland (+00:00)',
                'Atlantic/St_Helena' => 'Saint Helena (+00:00)',
                'Atlantic/South_Georgia' => 'South Georgia and the South Sandwich Islands (-02:00)',
            ],

            'Europe' => [
                'Europe/Minsk' => 'Belarus (+03:00)',
                'Europe/Zagreb' => 'Croatia (+02:00)',
                'Europe/Prague' => 'Czech Republic (+02:00)',
                'Europe/Copenhagen' => 'Denmark (+02:00)',
                'Europe/Tallinn' => 'Estonia (+03:00)',
                'Europe/Helsinki' => 'Finland (+03:00)',
                'Europe/Paris' => 'France (+02:00)',
                'Europe/Berlin' => 'Germany (+02:00)',
                'Europe/Gibraltar' => 'Gibraltar (+02:00)',
                'Europe/Athens' => 'Greece (+03:00)',
                'Europe/Guernsey' => 'Guernsey (+01:00)',
                'Europe/Budapest' => 'Hungary (+02:00)',
                'Europe/Dublin' => 'Ireland (+01:00)',
                'Europe/Isle_of_Man' => 'Isle of Man (+01:00)',
                'Europe/Rome' => 'Italy (+02:00)',
                'Europe/Jersey' => 'Jersey (+01:00)',
                'Europe/Riga' => 'Latvia (+03:00)',
                'Europe/Vaduz' => 'Liechtenstein (+02:00)',
                'Europe/Vilnius' => 'Lithuania (+03:00)',
                'Europe/Luxembourg' => 'Luxembourg (+02:00)',
                'Europe/Skopje' => 'Macedonia (+02:00)',
                'Europe/Malta' => 'Malta (+02:00)',
                'Europe/Chisinau' => 'Moldova (+03:00)',
                'Europe/Monaco' => 'Monaco (+02:00)',
                'Europe/Podgorica' => 'Montenegro (+02:00)',
                'Europe/Amsterdam' => 'Netherlands (+02:00)',
                'Europe/Oslo' => 'Norway (+02:00)',
                'Europe/Warsaw' => 'Poland (+02:00)',
                'Europe/Lisbon' => 'Portugal (+01:00)',
                'Europe/Bucharest' => 'Romania (+03:00)',
                'Europe/Kaliningrad' => 'Russia (+03:00)',
                'Europe/San_Marino' => 'San Marino (+02:00)',
                'Europe/Belgrade' => 'Serbia (+02:00)',
                'Europe/Bratislava' => 'Slovakia (+02:00)',
                'Europe/Ljubljana' => 'Slovenia (+02:00)',
                'Europe/Madrid' => 'Spain (+02:00)',
                'Europe/Stockholm' => 'Sweden (+02:00)',
                'Europe/Zurich' => 'Switzerland (+02:00)',
                'Europe/Istanbul' => 'Turkey (+03:00)',
                'Europe/Kiev' => 'Ukraine (+03:00)',
                'Europe/London' => 'United Kingdom (+01:00)',
            ],

            'Indian' => [
                'Indian/Chagos' => 'British Indian Ocean Territory (+06:00)',
                'Indian/Christmas' => 'Christmas Island (+07:00)',
                'Indian/Cocos' => 'Cocos Islands (+06:30)',
                'Indian/Comoro' => 'Comoros (+03:00)',
                'Indian/Kerguelen' => 'French Southern Territories (+05:00)',
                'Indian/Antananarivo' => 'Madagascar (+03:00)',
                'Indian/Maldives' => 'Maldives (+05:00)',
                'Indian/Mauritius' => 'Mauritius (+04:00)',
                'Indian/Mayotte' => 'Mayotte (+03:00)',
                'Indian/Reunion' => 'Reunion (+04:00)',
                'Indian/Mahe' => 'Seychelles (+04:00)',
            ],

            'Pacific' => [
                'Pacific/Rarotonga' => 'Cook Islands (-10:00)',
                'Pacific/Fiji' => 'Fiji (+12:00)',
                'Pacific/Tahiti' => 'French Polynesia (-10:00)',
                'Pacific/Guam' => 'Guam (+10:00)',
                'Pacific/Tarawa' => 'Kiribati (+12:00)',
                'Pacific/Majuro' => 'Marshall Islands (+12:00)',
                'Pacific/Chuuk' => 'Micronesia (+10:00)',
                'Pacific/Nauru' => 'Nauru (+12:00)',
                'Pacific/Noumea' => 'New Caledonia (+11:00)',
                'Pacific/Auckland' => 'New Zealand (+12:00)',
                'Pacific/Niue' => 'Niue (-11:00)',
                'Pacific/Norfolk' => 'Norfolk Island (+11:30)',
                'Pacific/Saipan' => 'Northern Mariana Islands (+10:00)',
                'Pacific/Palau' => 'Palau (+09:00)',
                'Pacific/Port_Moresby' => 'Papua New Guinea (+10:00)',
                'Pacific/Pitcairn' => 'Pitcairn (-08:00)',
                'Pacific/Apia' => 'Samoa (+13:00)',
                'Pacific/Guadalcanal' => 'Solomon Islands (+11:00)',
                'Pacific/Fakaofo' => 'Tokelau (+14:00)',
                'Pacific/Tongatapu' => 'Tonga (+13:00)',
                'Pacific/Funafuti' => 'Tuvalu (+12:00)',
                'Pacific/Johnston' => 'United States Minor Outlying Islands (-10:00)',
                'Pacific/Efate' => 'Vanuatu (+11:00)',
                'Pacific/Wallis' => 'Wallis and Futuna (+12:00)',
            ],

            'Other' => [
                'UTC' => 'UTC',
            ],
        ];
    }
}

