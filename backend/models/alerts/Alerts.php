<?php

namespace backend\models\alerts;
use backend\models\mail\SendmailMassendUser;
use backend\models\users\Users;
use Yii;
use backend\models\references\Translates;

/**
 * This is the model class for table "alerts".
 *
 * @property int $id
 * @property bool|null $email
 * @property bool|null $sms
 * @property string|null $title Заголовок
 * @property string|null $text Текст
 * @property string|null $sms_text Текст
 * @property string|null $key Ключ
 * @property string|null $key_title Заголовок ключа
 * @property string|null $key_text Текст ключа
 * @property string|null $type Тип
 * @property string|null $subscription
 * @property bool|null $status
 */
class Alerts extends \yii\db\ActiveRecord
{

    public $translation_title;
    public $translation_text;
    public $translation_sms_text;

    const TYPE_ITEMS = 'item';
    const TYPE_SHOPS = 'shop';
    const TYPE_USERS = 'user';
    const TYPE_OTHERS = 'other';

    const TYPE_ALERTS = [
        self::TYPE_ITEMS => 'Объявления',
        self::TYPE_SHOPS => 'Магазины',
        self::TYPE_USERS => 'Пользователи',
        self::TYPE_OTHERS => 'Другие',
    ];

    const TO_PHONE = 1;
    const STATUS = 0;
    const SERVICE_ID = 2;
    const MASSEND_ID = 6;
    const USER_BALANCE_ADMIN_PLUS = 'user_balance_admin_plus';
    const SHOPS_OPEN_SUCCESS = 'shops_open_success';
    const BBS_ITEM_ACTIVATE = 'bbs_item_activate';

    const SITE_TITLE = '{site.title}';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alerts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'sms','status'], 'boolean'],
            [['text', 'key_text','sms_text'], 'string'],
            [['title', 'key', 'key_title', 'type', 'subscription'], 'string', 'max' => 255],
            [['translation_text','translation_title','translation_sms_text'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'sms' => 'Sms',
            'title' => 'Заголовок',
            'translation_title' => 'Заголовок',
            'text' => 'Текст',
            'sms_text' => 'Sms Текст',
            'translation_text' => 'Текст',
            'key' => 'Ключ',
            'key_title' => 'Заголовок ключа',
            'key_text' => 'Текст ключа',
            'type' => 'Тип',
            'subscription' => 'Subscription',
            'status' => 'Статус',
        ];
    }

    public static function NeedTranslation()
    {
        return [
            'title' => 'translation_title',
            'text' => 'translation_text',
            'sms_text' => 'translation_sms_text',
        ];
    }


    /**
     * tarjimalarni saqlash
     * @param $post
     * @param $langs
     */
    public function SaveTranslates($post,$langs)
    {
        $attr = self::NeedTranslation();
        foreach ($langs as $lang) {
            $l = $lang->url;
            if($l == 'ru'){continue;}
            foreach ($attr as $key=>$value) {
                if(!isset($post["Alerts"][$value][$l])) continue;
                $t = Translates::find()->where(['table_name' => $this->tableName(),'field_id' => $this->id,'language_code' => $l,'field_name'=>$key]);
                if($t->count() == 1){
                    $tt = $t->one();
                    $tt->field_value=$post["Alerts"][$value][$l];
                    $tt->save();
                }else{
                    $t = new Translates();
                    $t->table_name = $this->tableName();
                    $t->field_id = $this->id;
                    $t->field_name = $key;
                    $t->field_value = $post["Alerts"][$value][$l];
                    $t->language_code = $l;
                    $t->save(false);
                }
            }
        }
    }


    /**
     * tarjimalarni olish
     * @param $langs
     */
    public function getTranslations($langs)
    {
        $attr = self::NeedTranslation();
        foreach ($attr as $key => $value) {
            $translations = Translates::find()->where(['table_name' => $this->tableName(), 'field_id' => $this->id,'field_name' => $key])->all();
            foreach ($translations as $translation) {
                $$value[$translation->language_code] = $translation->field_value;
            }
            if(!isset($$value))
                $$value = null;        
            $this->{$value} = $$value;
        }
    }


    /*
     * administrator tomonidan hisobini toldirganga sms borishi
     */
    public static function sendUserBalanceAdminPlus($amount , $balance , $user_id): bool
    {
        $alert = Alerts::find()->andWhere(['key' => self::USER_BALANCE_ADMIN_PLUS])->one();
        if(!$alert) return false;
        $mailuser = new SendmailMassendUser();
        $mailuser->user_id = $user_id;
        $mailuser->to_phone = 1;
        $mailuser->massend_id = self::MASSEND_ID;
        $mailuser->title  = str_replace(self::SITE_TITLE,"https://bisyor.uz",$alert->title);
        $text = str_replace('{amount}',$amount,$alert->text);
        $mailuser->text = str_replace('{balance}',$balance,$text);
        $mailuser->status = self::STATUS;
        $mailuser->service_id = self::SERVICE_ID;
        $mailuser->save(false);
        return true;
    }

    /*
     * magazin aktiv bolganda yasaladigan rassilka
     */
    public static function shopsOpenSuccess($user_id ,$keywords): bool
    {
        $alert = Alerts::find()->andWhere(['key' => self::SHOPS_OPEN_SUCCESS])->one();
        if(!$alert) return false;
        $mailuser = new SendmailMassendUser();
        $mailuser->user_id = $user_id;
        $mailuser->to_phone = 1;
        $mailuser->massend_id = self::MASSEND_ID;
        $mailuser->title  = str_replace(self::SITE_TITLE,"https://bisyor.uz",$alert->title);
        $text = str_replace('{shop_link}',"https://bisyor.uz/shops/{$keywords}",$alert->sms_text);
        $mailuser->text = $text;
        $mailuser->status = self::STATUS;
        $mailuser->service_id = self::SERVICE_ID;
        $mailuser->save(false);
        return true;
    }

    public static function bbsItemActivate($user_id): bool
    {
        $alert = Alerts::find()->andWhere(['key' => self::BBS_ITEM_ACTIVATE])->one();
        if(!$alert) return false;
        $mailuser = new SendmailMassendUser();
        $mailuser->user_id = $user_id;
        $mailuser->to_phone = 1;
        $mailuser->massend_id = self::MASSEND_ID;
        $mailuser->title  = $alert->title;
        $mailuser->text  = str_replace("{site.host}","https://bisyor.uz",$alert->sms_text);
        $mailuser->status = self::STATUS;
        $mailuser->service_id = self::SERVICE_ID;
        $mailuser->save(false);
        return true;
    }
}
