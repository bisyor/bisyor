<?php

namespace backend\models\settings;

use Yii;
use backend\models\references\Translates;

//  logo varchar(255) // Логотип  ===bisyor-logo.png
//  name varchar(255) // Название компании  ===Bisyor
//  email varchar(255) // E-mail ===support@bisyor.uz
//  phone varchar(255) // Телефон номер ===+998 97 7071218
//  address text // Адрес ===Узбекистан, Ташекент, Чиланзар
//  app_store varchar(255) // App Store link ===https://play.google.com/store/apps/details?id=uz.bisyor
//  google_play varchar(255) // Google Play ===https://play.google.com/store/apps/details?id=uz.bisyor
//  coordinate_x varchar(255) // Coordinate X
//  coordinate_y varchar(255) // Coordinate Y
//  facebook varchar(255) // Facebook ===https://facebook.com/bisyor
//  twitter varchar(255) // Twitter ===https://twitter.com/bisyor_uz
//  instagram varchar(255) // Instagram ===https://instagram.com/bisyoruz
//  youtube varchar(255) // Youtube ===https://youtube.com/bisyor
//  telegram varchar(255) // Telegram ===https://t.me/bisyor
//  odnoklassniki varchar(255) // Одноклассники ===https://ok.ru/bisyor
//  site_name varchar(255) // Название сайта ===www.bisyor.uz
//  adminka varchar(255) // Название сайта (Панель администратора) ===www.bisyor.uz
//  seo_site_name varchar(255) // Название сайта (SEO) ===www.bisyor.uz
//  alert_site_name varchar(255) // Название сайта (Уведомления) ===Bisyor.uz
//  copyright text // Копирайт ===Bisyor — Digital Store
//  footer_text text // Дополнительный текст в футере
//  enabled boolean // Режим 0 = выключено, 1 - включено ===1
//  contacts_form_title varchar(255) // Заголовок страницы
//  contacts_form_text text // Текст страницы
//  reason_block text // Причина выключения
// contacts_form_header varchar(255) // Заголовок формы контактов

class SiteSettings extends Settings
{
    public $img;
    public $tab;

    //tab1
    public $site_name;
    public $translation_site_name;
    public $adminka;
    public $translation_adminka;
    public $seo_site_name;
    public $translation_seo_site_name;
    public $alert_site_name;
    public $translation_alert_site_name;
    public $copyright;
    public $translation_copyright;
    public $footer_text;
    public $translation_footer_text;
    public $translation_address;

    //tab2
    public $enabled;
    public $reason_block;
    public $translation_reason_block;

    //tab3
    public $contacts_form_title;
    public $translation_contacts_form_title;
    public $contacts_form_text;
    public $translation_contacts_form_text;
    public $contacts_form_header;
    public $translation_contacts_form_header;

    //tab4
    public $logo;
    public $name;
    public $email;
    public $phone;
    public $address;
    public $app_store;
    public $google_play;
    public $coordinate_x;
    public $coordinate_y;
    public $facebook;
    public $twitter;
    public $instagram;
    public $youtube;
    public $telegram;
    public $odnoklassniki;
    public $telegram_bot_token;

    const GROUP = 'site-settings';
    const DIR_NAME = 'settings';
     /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tab'],'string'],
            [['translation_site_name','translation_adminka','translation_seo_site_name','translation_alert_site_name','translation_copyright','translation_footer_text','translation_contacts_form_title','translation_contacts_form_text','translation_reason_block','translation_contacts_form_header','translation_address'],'safe'],
            [['address','copyright','reason_block','footer_text','contacts_form_text','telegram_bot_token'], 'string'],
            [['logo','email','name','address','app_store','google_play','coordinate_y','coordinate_x','facebook','twitter','instagram','youtube','telegram','odnoklassniki','site_name','adminka','seo_site_name','alert_site_name','contacts_form_title','contacts_form_header'], 'string', 'max' => 255],
            [['enabled'],'integer'],
            [['phone'],'ValidatePhones','when' => function($model){ return $model->tab == 'tab-4';}],

            [['site_name',/*'translation_site_name',*/'adminka',/*'translation_adminka',*/'seo_site_name',/*'translation_seo_site_name',*/'alert_site_name',/*'translation_alert_site_name',*/'copyright',/*'translation_copyright',*/'footer_text'/*,'translation_footer_text'*/],'required', 'when' => function($model){ return $model->tab == 'tab-1';}],
            [['reason_block'/*,'translation_reason_block'*/],'required', 'when' => function($model){ return $model->tab == 'tab-2' && $model->enabled != 1;}],

            [['contacts_form_title',/*'translation_contacts_form_header',*/'contacts_form_header',/*'translation_contacts_form_title',*/'contacts_form_text'/*,'translation_contacts_form_text'*/],'required', 'when' => function($model){ return $model->tab == 'tab-3';}],

            [['img','name', 'email', 'address'],'required', 'when' => function($model){ return $model->tab == 'tab-4';}],
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
     * {@inheritdoc}
     */
    //ushbu modelga tegisli barcha maydonlar
    public function attributeLabels()
    {
        return [
            'logo' => 'Логотип',
            'img' => 'Логотип',
            'name' => 'Название компании',
            'email' => 'E-mail',
            'phone' => 'Телефон номер',
            'address' => 'Адрес',
            'translation_address' => 'Адрес',
            'app_store' => 'App Store link',
            'google_play' => 'Google Play',
            'coordinate_x' => 'Coordinate X',
            'coordinate_y' => 'Coordinate Y',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'instagram' => 'Instagram',
            'youtube' => 'Youtube',
            'telegram' => 'Telegram',
            'odnoklassniki' => 'Ok.Ru',
            'site_name' => 'Название сайта',
            'translation_site_name' => 'Название сайта',
            'adminka' => 'Название сайта',
            'translation_adminka' => 'Название сайта',
            'seo_site_name' => 'Название сайта',
            'translation_seo_site_name' => 'Название сайта',
            'alert_site_name' => 'Название сайта',
            'translation_alert_site_name' => 'Название сайта',
            'copyright' => 'Копирайт',
            'translation_copyright' => 'Копирайт',
            'footer_text' => 'Дополнительный текст в футере',
            'translation_footer_text' => 'Дополнительный текст в футере',
            'enabled' => 'Режим',
            'reason_block' => 'Причина выключения',
            'translation_reason_block' => 'Причина выключения',
            'contacts_form_title' => 'Заголовок страницы',
            'translation_contacts_form_title' => 'Заголовок страницы',
            'contacts_form_text' => 'Текст страницы',
            'translation_contacts_form_text' => 'Текст страницы',
            'contacts_form_header' => 'Заголовок формы контактов',
            'translation_contacts_form_header' => 'Заголовок формы контактов',
            'telegram_bot_token' => 'Токен телеграм бота',
        ];
    }

    //bazaga settingsga saqlanishi kerak bo'lgan maydonar
    public function getNames()
    {
        return [
            'logo' => 'string',
            'name' => 'string',
            'email' => 'string',
            'phone' => 'array',
            'address' => 'string',
            'app_store' => 'string',
            'google_play' => 'string',
            'coordinate_x' => 'string',
            'coordinate_y' => 'string',
            'facebook' => 'string',
            'twitter' => 'string',
            'instagram' => 'string',
            'youtube' => 'string',
            'telegram' => 'string',
            'odnoklassniki' => 'string',
            'site_name' => 'string',
            'adminka' => 'string',
            'seo_site_name' => 'string',
            'alert_site_name' => 'string',
            'copyright' => 'text',
            'footer_text' => 'text',
            'enabled' => 'boolean',
            'reason_block' => 'text',
            'contacts_form_title' => 'string',
            'contacts_form_text'=> 'text',
            'contacts_form_header' => 'string',
        ];
    }

    //tarjima ga ega maydonlar
    public static function NeedTranslation()
    {
        return [
            'site_name' => 'translation_site_name',
            'adminka' => 'translation_adminka',
            'seo_site_name' => 'translation_seo_site_name',
            'alert_site_name' => 'translation_alert_site_name',
            'copyright' => 'translation_copyright',
            'footer_text' => 'translation_footer_text',
            'reason_block' => 'translation_reason_block',
            'contacts_form_title' => 'translation_contacts_form_title',
            'contacts_form_text' => 'translation_contacts_form_text',
            'contacts_form_header' => 'translation_contacts_form_header',
            'address' => 'translation_address',
        ];
    }

    //konstruktor
    public function __construct($config = [])
    {
        $values = Settings::find()->where(['group' => self::GROUP])->all();
        foreach ($values as $key => $value) {
            $this->{$value->key} = ($value->type == 'array') ? explode(",",$value->value) : $value->value;
        }
        $this->tab =  isset($_COOKIE["tab-settings"]) ? $_COOKIE["tab-settings"] : 'tab-1';
        parent::__construct();
    }

    //tarjimalarni ssaqlash
    public function SaveTranslates($post,$langs)
    {
        $attr = self::NeedTranslation();
        foreach ($attr as $key => $value) {
            foreach ($langs as $lang) {

                if($lang->url == 'ru') continue;
                $post_value = $post["SiteSettings"][$value][$lang->url];
                if(!isset($post_value)) continue;
                $model = $this->getModel($key);
                $old_translate = Translates::find()->where(['table_name' => $this->tableName(),'field_id' => $model->id,'language_code' => $lang->url,'field_name' => $key])->one();
                if(isset($old_translate)){
                    $old_translate->field_value = $post_value;
                    $old_translate->save(false);
                }else{
                    $t = new Translates();
                    $t->table_name = $this->tableName();
                    $t->field_id = $model->id;
                    $t->field_name = $key;
                    $t->field_value = $post_value;
                    $t->language_code = $lang->url;
                    $t->save(false);
                }
            }
        }
    }

    //tarjimalarni mdoelga yuklash
    public function getTranslations($langs)
    {
        $attr = self::NeedTranslation();
        foreach ($attr as $key => $value) {
            $model = $this->getModel($key);
            $translations = Translates::find()->where(['table_name' => $this->tableName(), 'field_id' => $model->id,'field_name' => $key])->all();
            foreach ($translations as $translation) {
                $$value[$translation->language_code] = $translation->field_value;
            }
            if(!isset($$value))
                $$value = null;
            $this->{$value} = $$value;
        }
    }

    public function ValidatePhones($attribute)
    {
        $items = $this->$attribute;
        if (!is_array($items)) {
            $items = [];
        }
        $arr = [];
        foreach ($items as $index => $item) {
            $x = preg_replace('/\d/', '#', $item);
            if ($x != '+#####-###-##-##') {
                $key = $attribute . '[' . $index . ']';
                $this->addError($key, "Введите полностью");
            }else{
                $arr [] = $item;
            }
        }
        $this->$attribute = $arr;
        return true;
    }

    public static function getAdminSiteName()
    {
        $adminka = Yii::$app->params['adminka'];
        return $adminka;
    }

    //------------- files ftp ----------------
    //ftp connect
    public static function connectFtp()
    {
        $host = Yii::$app->params['host'];
        //host
        $name = $host['name'];
        $usr = $host['username'];
        $pwd = $host['password'];

        // connect to FTP server (port 21)
        $conn_id = ftp_connect($name, 21) or die ("Cannot connect to host");

        // send access parameters
        if(ftp_login($conn_id, $usr, $pwd)){
            ftp_pasv($conn_id, true);
            return $conn_id;
        }
    }

    //image site
    public static function getImageSiteName()
    {
        $adminka = Yii::$app->params['image_site'];
        return $adminka;
    }

    //olish
    public function getImg($small = false, $width = "",$height = "")
    {
        $img = $this->logo;
        $dir = self::DIR_NAME;

        if($this->img){
            $img = $this->img ;
            $dir = 'trash';
        }

        $admin = self::getImageSiteName();
        $conn_id = self::connectFtp();

        $res = ftp_size($conn_id, '/web/uploads/' .$dir . '/'.$img);

        if ($res == -1 || $img == '') {
            $path = '/uploads/noimg.jpg';
        }
        else {
            $path = $admin.'/web/uploads/'.$dir.'/'.$img;
        }

        if($width != "" && $height != "")
            return '<img style="width:'.$width.'px;height:'.$height.'" src="'.$path.'">';
        else
            return '<img style="width:80px;height:80px" src="'.$path.'">';
    }

    //saqlash
    public function UploadImage()
    {
        $dir = self::DIR_NAME;
        $source_path = '/web/uploads/trash/';
        $destination_path = '/web/uploads/'.$dir.'/';

        $conn_id = self::connectFtp();

        if($this->img != "")
        {
            $value = $this->img;
            $res = ftp_size($conn_id, $source_path.$value);
            if ($res != -1) {
                $ext = substr(strrchr($value, "."), 1);
                $fileName = 'logo.' . $ext;
                ftp_rename($conn_id, $source_path.$value, $destination_path.$fileName);
                $this->saveSetting('logo',$fileName,'Логотип');
                $this->img = '';
                $this->save(false);
            }
        }
    }

    //soxranit qilish
    public function saveModel($post)
    {
        $rows = Settings::getDb()->cache(function ($db) {
            return Settings::find()->where(['group' => self::GROUP])->all();
        });
        $rows = Settings::find()->where(['group' => self::GROUP])->all();
        foreach ($rows as $value) {
            if(isset($post['SiteSettings'][$value->key]) && $post['SiteSettings'][$value->key] != ''){
                $value->value = ($value->type == 'array') ? implode(",",$post['SiteSettings'][$value->key]) : $post['SiteSettings'][$value->key];
                $value->save();
            }
        }
    }
}

