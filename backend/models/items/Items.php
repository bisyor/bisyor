<?php

namespace backend\models\items;

use backend\components\StaticFunction;
use backend\models\alerts\Alerts;
use backend\models\references\Currencies;
use backend\models\references\Districts;
use backend\models\settings\Settings;
use backend\models\shops\Services;
use backend\models\shops\Shops;
use backend\models\users\Users;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "items".
 *
 * @property int $id
 * @property int|null $user_id Пользователь
 * @property string|null $user_ip Ip пользователя
 * @property int|null $shop_id Магазин
 * @property bool|null $is_publicated Опубликован или нет
 * @property bool|null $is_moderating Модерировань или нет
 * @property int|null $status Статус
 * @property int|null $status_prev  Предыдующие статус
 * @property int|null $status_changed Дата изменение статуса
 * @property bool|null $deleted Удалено или нет
 * @property bool|null $verified
 * @property int|null $cat_id Категория
 * @property int|null $owner_type Тип пользователья
 * @property int|null $district_id Район
 * @property string|null $coordinate_x Coordinate X
 * @property string|null $coordinate_y Coordinate Y
 * @property string|null $title Заголовок
 * @property string|null $keyword keyword
 * @property string|null $link Ссылка
 * @property string|null $description Описание
 * @property string|null $lang язык
 * @property string|null $img_s Б картинка
 * @property string|null $img_m M картинка
 * @property string|null $images Все картинки
 * @property string|null $date_cr Дата создание
 * @property string|null $date_up Дата изменение
 * @property float|null $price Цена
 * @property float|null $popular_degree
 * @property float|null $price_search Цена
 * @property int|null $currency_id Валюта
 * @property string|null $name Имя
 * @property string|null $phones Телефон номеры
 * @property string|null $publicated Дата публикации
 * @property string|null $publicated_to
 * @property string|null $publicated_order
 * @property int|null $publicated_period  Количество дней
 * @property int|null $moderated_id  Кто измениль
 * @property string|null $moderated_date  Кто измениль
 * @property string|null $blocked_reason  Кто измениль
 * @property string|null $f1  Допольнителные полей
 * @property string|null $f2  Допольнителные полей
 * @property string|null $f3  Допольнителные полей
 * @property string|null $f4  Допольнителные полей
 * @property string|null $f5  Допольнителные полей
 * @property string|null $f6  Допольнителные полей
 * @property string|null $f7  Допольнителные полей
 * @property string|null $f8  Допольнителные полей
 * @property string|null $f9  Допольнителные полей
 * @property string|null $f10  Допольнителные полей
 * @property string|null $f11  Допольнителные полей
 * @property string|null $f12  Допольнителные полей
 * @property string|null $f13  Допольнителные полей
 * @property string|null $f14  Допольнителные полей
 * @property string|null $f15  Допольнителные полей
 * @property string|null $f16  Допольнителные полей
 * @property string|null $f17  Допольнителные полей
 * @property string|null $f18  Допольнителные полей
 * @property string|null $f19  Допольнителные полей
 * @property string|null $f20  Допольнителные полей
 * @property string|null $f21  Допольнителные полей
 * @property string|null $f22  Допольнителные полей
 * @property string|null $f23  Допольнителные полей
 * @property string|null $f24  Допольнителные полей
 * @property string|null $f25  Допольнителные полей
 *
 * @property Categories $cat
 * @property Currencies $currency
 * @property Districts $district
 * @property Shops $shop
 * @property Users $user
 * @property Users $moderated
 * @property PromocodesUsage[] $promocodesUsages
 */
class Items extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $item_owner_type;
    public $blocked_status;

    /**
     * {@inheritdoc}
     */

    const STATUS_PUBLICATIOM = 0;
    const STATUS_INPUBLICATION = 1;
    const STATUS_MODERATING = 2;
    const STATUS_INACTIVE = 3;
    const STATUS_BLOCKED = 4;
    const STATUS_DELETED = 5;
    const STATUS_DEL = 6;

    const STATUS_ITEMS = [
        self::STATUS_PUBLICATIOM => 'Публикуется',
        self::STATUS_INPUBLICATION => 'Период публикации завершился',
        self::STATUS_MODERATING => 'Ожидает проверки',
        self::STATUS_INACTIVE => 'Неактивировано',
        self::STATUS_BLOCKED => 'Заблокировано',
        self::STATUS_DELETED => 'Удалено пользователем'
    ];
    const BLOCKED_REASONS = [
        'Объявления не актуально' => 'Объявления не актуально',
        'Запрещенный товар/услуга' => 'Запрещенный товар/услуга',
        'Неверное описание, фото' => 'Неверное описание, фото',
        'Неверная рубрика' => 'Неверная рубрика',
        'Неверная цена' => 'Неверная цена',
        'Мошенничество' => 'Мошенничество',
        'Спам' => 'Спам',
        'Другая причина' => 'Другая причина',
        'Заблокировано навсегда' => 'Заблокировано навсегда',
    ];

    const OWNER_TYPE = [
        1 => 'Частное лицо',
        2 => 'Магазин',
    ];

    const DIR_NAME = 'items';
    public $tab;
    public $list;
    public $blocking;

    const STATUS_TYPE = [
        self::STATUS_PUBLICATIOM => [
            'name' => 'Опубликованные',
            'statuses' => [
                'status' => 3,
                'is_moderating' => 0,
                'is_publicated' => 1
            ]
        ],
        self::STATUS_INPUBLICATION => [
            'name' => 'Снятые с публикации',
            'statuses' => [
                'status' => 4,
                'is_moderating' => 0,
                'is_publicated' => 0
            ]
        ],
        self::STATUS_MODERATING =>[
            'name' => 'На модерации',
            'statuses' => [
                'status' => 3,
                'is_moderating' => 1,
                'is_publicated' => 0
            ]
        ],
        self::STATUS_INACTIVE =>[
            'name' => 'Неактивированные',
            'statuses' => [
                'status' => 1,
                'is_moderating' => 0,
                'is_publicated' => 0
            ]
        ],
        self::STATUS_BLOCKED =>[
            'name' => 'Заблокированные',
            'statuses' => [
                'status' => 5,
                'is_moderating' => 0,
                'is_publicated' => 0
            ]
        ],
        self::STATUS_DELETED =>[
            'name' => 'Удаленные',
            'statuses' => [
                'status' => 6,
                'is_moderating' => 0,
                'is_publicated' => 0
            ]
        ],
        -1 =>[
            'name' => 'Все',
        ],
    ];
    public static function tableName()
    {
        return 'items';
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'skeeks\yii2\slug\SlugBehavior',
                'slugAttribute' => 'keyword',                      //The attribute to be generated
                'attribute' => 'title',                          //The attribute from which will be generated
                // optional params
                'maxLength' => 64,                              //Maximum length of attribute slug
                'minLength' => 3,                               //Min length of attribute slug
                'ensureUnique' => false,
                'slugifyOptions' => [
                    'lowercase' => true,
                    'separator' => '-',
                    'trim' => true,
                    //'regexp' => '/([^A-Za-z0-9]|-)+/',
                    'rulesets' => ['russian'],
                    //@see all options https://github.com/cocur/slugify
                ]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 50],

            [['title','description','district_id','user_id'],'required'],
            [['user_id', 'shop_id', 'status', 'status_prev', 'status_changed', 'cat_id', 'owner_type', 'district_id', 'currency_id', 'publicated_period'], 'default', 'value' => null],

            [['user_id','cat_type', 'status_prev', 'cat_id', 'owner_type', 'district_id', 'currency_id', 'publicated_period', 'moderated_id'], 'integer'],
            [['status','is_moderating','is_publicated','video','item_owner_type' ,'blocked_status' ,'is_publicated_telegram','verified','is_publicated_shops_telegram'],'safe'],

            [['user_id','cat_type', 'status_prev', 'cat_id', 'owner_type', 'district_id', 'currency_id', 'publicated_period', 'from_device'], 'integer'],
            [['status','is_moderating','is_publicated','video','item_owner_type','is_buyed'],'safe'],

            [['deleted'], 'boolean'],
            [['description', 'images', 'moderated_date', 'blocked_reason', 'f1', 'f2', 'f3', 'f4', 'f5', 'f6', 'f7', 'f8', 'f9', 'f10', 'f11', 'f12', 'f13', 'f14', 'f15', 'f16', 'f17', 'f18', 'f19', 'f20', 'f21', 'f22', 'f23', 'f24', 'f25'], 'string'],
            [['phones','status_changed','blocking'],'safe'],
            [['date_cr', 'date_up', 'publicated', 'publicated_to', 'publicated_order','moderation_date'], 'safe'],
            [['price_end','price'] ,'befoPrice'],
            [['price', 'price_search','price_ex','price_end','popular_degree'], 'number'],
            [['user_ip', 'coordinate_x', 'coordinate_y', 'address', 'title', 'keyword', 'link', 'lang', 'img_s', 'img_m', 'name'], 'string', 'max' => 255],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['cat_id' => 'id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::className(), 'targetAttribute' => ['currency_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => Districts::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['moderated_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['moderated_id' => 'id']],
            [['blocked_reason'],'required','when'=>function($model){return $model->blocking;}],
            ['video' , 'videoValidate'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'user_ip' => 'Ip пользователя',
            'shop_id' => 'Магазин',
            'from_device' => 'С устройства',
            'is_publicated' => 'Опубликован или нет',
            'is_moderating' => 'Модерировань или нет',
            'status' => 'Статус',
            'status_prev' => ' Предыдующие статус',
            'status_changed' => 'Дата изменение статуса',
            'deleted' => 'Удалено или нет',
            'cat_id' => 'Категория',
            'owner_type' => 'Тип пользователья',
            'district_id' => 'Район',
            'cat_type' => 'Тип объявления',
            'coordinate_x' => 'Coordinate X',
            'coordinate_y' => 'Coordinate Y',
            'title' => 'Заголовок',
            'keyword' => 'keyword',
            'link' => 'Ссылка',
            'description' => 'Описание',
            'lang' => 'язык',
            'img_s' => 'Б картинка',
            'img_m' => 'M картинка',
            'images' => 'Все картинки',
            'date_cr' => 'Дата создание',
            'date_up' => 'Дата изменение',
            'price' => 'Цена',
            'price_search' => 'Цена',
            'currency_id' => 'Валюта',
            'name' => 'Имя',
            'phones' => 'Телефон номеры',
            'publicated' => 'Дата публикации',
            'publicated_to' => 'Publicated To',
            'publicated_order' => 'Publicated Order',
            'publicated_period' => 'Срок публикации',
            'moderated_id' => ' Кто измениль',
            'moderated_date' => ' Кто измениль',
            'blocked_reason' => 'Причина заблокирована',
            'price_ex' => '',
            'is_publicated_telegram' => 'Публикации телеграммы канала',
            'verified' => 'Надежный',
            'video' => 'Ссылка на видео',
            'is_buyed' => 'Продал',
            'f1' => ' Допольнителные полей',
            'f2' => ' Допольнителные полей',
            'f3' => ' Допольнителные полей',
            'f4' => ' Допольнителные полей',
            'f5' => ' Допольнителные полей',
            'f6' => ' Допольнителные полей',
            'f7' => ' Допольнителные полей',
            'f8' => ' Допольнителные полей',
            'f9' => ' Допольнителные полей',
            'f10' => ' Допольнителные полей',
            'f11' => ' Допольнителные полей',
            'f12' => ' Допольнителные полей',
            'f13' => ' Допольнителные полей',
            'f14' => ' Допольнителные полей',
            'f15' => ' Допольнителные полей',
            'f16' => ' Допольнителные полей',
            'f17' => ' Допольнителные полей',
            'f18' => ' Допольнителные полей',
            'f19' => ' Допольнителные полей',
            'f20' => ' Допольнителные полей',
            'f21' => ' Допольнителные полей',
            'f22' => ' Допольнителные полей',
            'f23' => ' Допольнителные полей',
            'f24' => ' Допольнителные полей',
            'f25' => ' Допольнителные полей',
        ];
    }


    /**
     * videoni linkini validatsiya qilish
     * @param $attribute
     * @param $params
     */
    public function videoValidate($attribute,$params)
    {
        $pattern = '#^(?:https?://)?';    # Optional URL scheme. Either http or https.
        $pattern .= '(?:www\.)?';         #  Optional www subdomain.
        $pattern .= '(?:';                #  Group host alternatives:
        $pattern .=   'youtu\.be/';       #    Either youtu.be,
        $pattern .=   '|youtube\.com';    #    or youtube.com
        $pattern .=   '(?:';              #    Group path alternatives:
        $pattern .=     '/embed/';        #      Either /embed/,
        $pattern .=     '|/v/';           #      or /v/,
        $pattern .=     '|/watch\?v=';    #      or /watch?v=,
        $pattern .=     '|/watch\?.+&v='; #      or /watch?other_param&v=
        $pattern .=   ')';                #    End path alternatives.
        $pattern .= ')';                  #  End host alternatives.
        $pattern .= '([\w-]{11})';        # 11 characters (Length of Youtube video ids).
        $pattern .= '(?:.+)?$#x';         # Optional other ending URL parameters.
        preg_match($pattern,$this->video, $matches_a_z, PREG_OFFSET_CAPTURE);
        if(!$matches_a_z){
            $this->addError($attribute, 'ссылка на видео неверна');
        }
    }


    /**
     * link yashash.
     */
    public function setLink()
    {
        $this->link = $this->keyword . "-" . $this->id . ".html";
        $this->save(false);
    }


    /**
     * save from mehnat uz
     * @throws \yii\base\InvalidConfigException
     */
    public function saveFromMehnatUz()
    {
        $this->link = $this->keyword . "-" . $this->id . ".html";
        $this->status_changed = Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i:s');
        $this->is_publicated = true;
        $this->is_moderating = false;
        $this->status = 3;
        $this->img_m ='def-m.png';
        $this->img_s ='def-s.png';
        $this->save(false);
    }

    public function saveFromOlxUz()
    {
        $this->link = $this->keyword . "-" . $this->id . ".html";
        $this->status_changed = Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i:s');
//        $this->is_publicated = true;
//        $this->is_moderating = false;
//        $this->status = 3;
//        $this->img_m ='def-m.png';
//        $this->img_s ='def-s.png';
        $this->save(false);
    }


    /**
     * Gets query for [[Cat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Categories::className(), ['id' => 'cat_id']);
    }


    public function befoPrice()
    {
        $this->price = (int)str_replace(' ','', $this->price);
        $this->price_end = (int)str_replace(' ','', $this->price_end);
    }


    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->date_cr = Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i:s');
            $this->date_up =  $this->date_cr;
            $this->status_changed = Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i:s');
            $this->publicated = Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i:s');
            $this->publicated_order = Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i:s');
            //status
            $statuses = self::STATUS_TYPE[self::STATUS_MODERATING]['statuses'];
            $this->status_changed = Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i:s');
            $this->status_prev = self::STATUS_INACTIVE;
            $this->status = $statuses['status'];
            $this->is_moderating = $statuses['is_moderating'];
            $this->is_publicated = $statuses['is_publicated'];

            $day = \backend\models\settings\Settings::find()->where(['key' => 'period_items_count'])->one()->value;
            if($this->publicated_period){
                $day = $this->publicated_period;
            }
            $this->publicated_period = $day;
            $this->publicated_to = Yii::$app->formatter->asDate((int)$day * 30 * 2400 + time(),'php:Y-m-d H:i:s');
            $this->is_publicated_telegram = false;
        }

        if($this->phones && is_array($this->phones)){
            $phones = $this->phones;
            $arr = [];
            foreach ($phones as $key => $value) {
                if($value != ''){
                    $arr[] = [
                        'v' => $value
                    ];
                }
            }
            $this->phones = serialize($arr);
        }
        if($this->item_owner_type == 1){
            $this->shop_id = null;
        }
        if($this->currency_id != null) $this->price_search = $this->currency->rate * (float)$this->price;
        $this->title = ucfirst($this->title);
        $this->moderated_id = 1;
        $this->title = StaticFunction::remove_emoji($this->title);
        $this->description = StaticFunction::remove_emoji($this->description);
        //$this->date_up = Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i');
        if(!$this->from_device) {
           $this->from_device = 1;
        }
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $phones = unserialize($this->phones);
        if (!empty($phones)) $this->phones = array_column($phones, 'v');
        else $this->phones = [];

        if($this->shop_id != null){
            $this->item_owner_type = 2;
        }else{
            $this->item_owner_type = 1;
        }

        return parent::afterFind();
    }

    public function setRassilkaActivateItems(){
        if(($this->date_cr == $this->date_up) && ($this->date_up != '')){
            $phone = [];
            if($this->phones){
                foreach ($this->phones as $value){
                    $phone  [] = str_replace('-' , '' , $value);
                }
            }
            if ($this->phones && $user = Users::find()->andWhere(['phone' => $phone])->one()) {
                if ($user) {
                    Alerts::bbsItemActivate($user->id);
                } else {
                    Alerts::bbsItemActivate($this->user_id);
                }
            }
        }
    }


    /**
     * get phones
     */
    public function getPhones()
    {
        $phones = unserialize($this->phones);
        if (!empty($phones)) $this->phones = array_column($phones, 'v');
        else $this->phones = [];
    }

    /**
     * rasm o'zgargandan keyingi xolatini ozgartish
     */
    public function setAfterChangeImage()
    {
        $image = ItemsImages::find()->where(['item_id' => $this->id])->orderBy(['num'=> SORT_ASC])->one();
        if($image != null)
        {
            $this->img_m = $image->extstor_img_m;
            $this->img_s = $image->extstor_img_s;
            $this->save(false);
        } else {
            $this->img_m ='def-m.png';
            $this->img_s ='def-s.png';
            $this->save(false);
        }
    }


    /**
     * elon udalit qilgandan keyin rasmlani va jalobalarni o'chirish
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */

    public function beforeDelete()
    {
        $images = [];
        $itemImages = ItemsImages::find()->where(['item_id' => $this->id])->all();
        if($itemImages){
            foreach ($itemImages as $key => $value) {
                $images [] = $value->extstor_img_s;
                $images [] = $value->extstor_img_m;
                $images [] = $value->extstor_img_v;
                $images [] = $value->extstor_img_z;
                $images [] = $value->extstor_img_o;
                $value->delete();
            }
            ItemsImages::deleteImagesWithApi($images);
        }

        $itemClaims = ItemsClaim::find()->where(['item_id' => $this->id])->all();
        if($itemImages){
            foreach ($itemClaims as $key => $value) {
                $value->delete();
            }
        }

        $itemViews = ItemsViews::find()->where(['item_id' => $this->id])->all();
        if($itemViews){
            foreach ($itemViews as $key => $value) {
                $value->delete();
            }
        }
        return parent::beforeDelete();
    }


    /**
     * Gets query for [[Currency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currencies::className(), ['id' => 'currency_id']);
    }


    /**
     * Gets query for [[District]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(Districts::className(), ['id' => 'district_id']);
    }


    /**
     * Gets query for [[Shop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shops::className(), ['id' => 'shop_id']);
    }


    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getModerator()
    {
        return $this->hasOne(Users::className(), ['id' => 'moderated_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopApi()
    {
        return $this->hasOne(Shops::className(), ['id' => 'shop_id'])
            ->andWhere(['not' ,['telegram_channel' => null]])
            ->select(['id','telegram_channel']);
    }


    /**
     * Gets query for [[Moderated]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModerated()
    {
        return $this->hasOne(Users::className(), ['id' => 'moderated_id']);
    }


    /**
     * Gets query for [[PromocodesUsages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromocodesUsages()
    {
        return $this->hasMany(PromocodesUsage::className(), ['item_id' => 'id']);
    }

    public function getItemViews()
    {
        return $this->hasMany(ItemsViews::className(), ['item_id' => 'id'])->select(['item_id','item_views'])->asArray();
    }

    public function getItemFavorites()
    {
        return $this->hasMany(Favorites::className(), ['item_id' => 'id'])
                ->select(['item_id'])
                ->andWhere(['type' => 1])
                ->asArray();
    }


    public function getItemsImages()
    {
        return $this->hasMany(ItemsImages::className(), ['item_id' => 'id']);
    }


    /**
     * statusni descriptionlari
     * @return string[]
     */
    public static function getStatusLabel()
    {
        return [
            self::STATUS_PUBLICATIOM => 'Опубликованные',
            self::STATUS_INPUBLICATION => 'Снятые с публикации',
            self::STATUS_MODERATING => 'На модерации',
            self::STATUS_INACTIVE => 'Неактивированные',
            self::STATUS_BLOCKED => 'Заблокированные',
            self::STATUS_DELETED => 'Удаленные',
        ];
    }

    public static function keyCountArray($array, $key, $value){
        $count = 0;
        foreach ($array as $val){
            if ($val[$key] == $value)
                $count++;
        }
        return $count;
    }


    /**
     * imageni urlni olish
     * @return string
     */
    public function getImageM()
    {
        $siteName = Yii::$app->params['image_site'];
        $itemsPath = Yii::$app->params['itemsPath'];
        if($this->img_m == null || $this->img_m == '') return $siteName.'/web/uploads/noimg.jpg';
        else {
            if($this->img_m == 'def-m.png') return $siteName.'/web/uploads/noimg.jpg';
            else {
                $image = ItemsImages::find()->where(['item_id' => $this->id])->one();
                if($image){
                    return $itemsPath .  $image->extstor_img_s;
                }
                return $siteName.'/web/uploads/noimg.jpg';
            }
        }
    }


    /**
     * rasmlardan collage yasash ,  telegram kanallarga rasm yuborish uchun
     * @return array|string
     */
    public function getImageForTelegram()
    {
        $siteName = Yii::$app->params['image_site'];
        $itemsPath = Yii::$app->params['itemsPath'];
        if($this->img_m == null || $this->img_m == '') return [$siteName.'/web/uploads/noimg.jpg'];
        else {
            if($this->img_m == 'def-m.png') return [$siteName.'/web/uploads/noimg.jpg'];
            else {
                $imgs = ItemsImages::find()->where(['item_id' => $this->id])->orderBy(['num' => SORT_ASC])->limit(4)->asArray()->all();
                $imgs = array_column($imgs , 'extstor_img_z');
                $result = [];
                foreach ($imgs as $value){
                    $result [] =  $itemsPath . $value;
                }
                return  $result;
            }
        }

    }


    /**
     * Items jadvalining status polyasini 6 ta qiymatdagi sonini topish uchun
     * @param $array
     * @return array
     */
    public static function circleChart(){
        return [
            self::STATUS_PUBLICATIOM => Items::find()->where(['status' => 3,'is_moderating'=>0, 'is_publicated' => 1])->count('*'),
            self::STATUS_INPUBLICATION => Items::find()->where(['status' => self::STATUS_BLOCKED, 'is_publicated' => 0])->count('*'),
            self::STATUS_MODERATING => Items::find()->where(['status' => 3,'is_moderating'=>1, 'is_publicated' => 0])->count('*'),
            self::STATUS_INACTIVE => Items::find()->where(['status' => self::STATUS_INPUBLICATION, 'is_publicated' => 0])->count('*'),
            self::STATUS_BLOCKED => Items::find()->where(['status' => self::STATUS_DELETED, 'is_publicated' => 0])->count('*'),
            self::STATUS_DELETED => Items::find()->where(['status' => self::STATUS_DEL, 'is_publicated' => 0])->count('*'),
        ];
    }

    /**
     * Items uchun label va ularning yoninga sonini chiqarish
     * @param $label
     * @param $array
     * @return mixed
     */
    public static function laelPie($label, $array)
    {
        foreach ($label as $key => $value){
            $label[$key] = $value . " (" . $array[$key] . ")";
        }
        return $label;
    }


    /**
     * ftp connect
     * @return false|resource
     */
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

    /**
     * image site
     * @return mixed
     */
    public static function getImageSiteName()
    {
        $adminka = Yii::$app->params['image_site'];
        return $adminka;
    }


    /**
     * rasm adresi ni olish
     * @param $img
     * @param string $prefix
     * @return string
     */
    public static function getImageAdress($img, $prefix = "")
    {
        $prefix = ""; // prefix endi kerak emas Sarvar! qayerda ishlatilgan bolsa owa yerdan olib tawla
        $dir = self::DIR_NAME;
        $img = $prefix . $img;
        $admin = self::getImageSiteName();
            $path = $admin.'/web/uploads/'.$dir.'/'.$img;
        return $path;
    }


    /**
     * rasmni olish(html)
     * @param $img
     * @param string $width
     * @param string $height
     * @return string
     */
    public function getImg($img, $width = "", $height = "")
    {
        $path = self::getImageAdress($img,$this->img_prefix);
        if($width != "" && $height != "")
            return '<img style="width:'.$width.'px;height:'.$height.'" src="'.$path.'">';
        else
            return '<img style="width:80px;height:80px" src="'.$path.'">';
    }

    /**
     * rasmlarni yuklash uchun , yangi method
     * @param $post
     * @param bool $user_id
     * @return mixed|null
     */
    public function newSaveImg($post, $user_id = false)
    {
        if($user_id === false){
            $user_id = Yii::$app->user->identity->id;
        }

        $j = ItemsImages::find()->where(['item_id' => $this->id])->count();
        $i = 0;
        if($j == 0 || $j == null) $j = 1; else $j++;
        $result = null;
        $photo_count = (int)$this->cat->photos;
        $uploaded_files = explode(',',$post['uploaded_files']);
        $yangi_massiv = array_slice($uploaded_files , 0 ,$photo_count+1-$j);
        $yangi_massiv  = implode(',' ,$yangi_massiv);

        $time = time();
        if($uploaded_files){
            $result =  self::sendStorageFile([
                'image_name' => $yangi_massiv,
                'title' => $this->keyword,
                'id' => $this->id,
                'key' => $j,
                'time' => $time,
            ]);
//            echo '<pre>';
//            print_r($result); die;
            if($result) {
                foreach ($result as $value) {
                    if ($value != null) {
                        $model = new ItemsImages();
                        $model->item_id = $this->id;
                        $model->user_id = $user_id;
                        $model->extstor_img_o = $this->keyword . '-' . $this->id . '-' . ($value) . 'o-'.$time.'.jpg';
                        $model->extstor_img_z = $this->keyword . '-' . $this->id . '-' . ($value) . 'z-'.$time.'.jpg';
                        $model->extstor_img_v = $this->keyword . '-' . $this->id . '-' . ($value) . 'v-'.$time.'.jpg';
                        $model->extstor_img_m = $this->keyword . '-' . $this->id . '-' . ($value) . 'm-'.$time.'.jpg';
                        $model->extstor_img_s = $this->keyword . '-' . $this->id . '-' . ($value) . 's-'.$time.'.jpg';
                        $model->num = $value;
                        $model->created = date('Y-m-d H:i');
                        $model->save();
                        $i++;
                        if ($i == 1) {
                            $this->img_s = $model->extstor_img_s;
                            $this->img_m = $model->extstor_img_m;
                            $this->save(false);
                        }
                    }
                }
            }
        }
        return $result;
    }


    /**
     * imgae bisyor ru rasmni yuborish
     * @param $data
     * @return mixed
     */
    public static function sendStorageFile($data)
    {
        // curl connection
        $ch = curl_init();
        // set curl url connection
        $curl_url = Yii::$app->params['image_site'].'/api/image-change';
        // pass curl url
        curl_setopt($ch, CURLOPT_URL,$curl_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        // image upload Post Fields
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        // set CURL ETURN TRANSFER type
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_result = curl_exec($ch);
        curl_close($ch);
        return  json_decode($server_result);
        exit;
    }


    /**
     * rasmlarni uchirish
     * @param $img
     * @param bool $trash
     */
    public static function deleteImage($img,$trash = true)
    {
        if(!$trash){
            $dir = self::DIR_NAME;
            $path = '/web/uploads/'.$dir.'/';
        }else{
            $path = '/web/uploads/trash/';
        }

        $conn_id = self::connectFtp();
        $res = ftp_size($conn_id, $path . $img);
        if ($res != -1 && $img) {
            ftp_delete($conn_id, $path . $img);
        }
    }


    /**
     * barcha rasmlar ruyhati
     * @return array
     */
    public function getImages()
    {
        $imgs = ItemsImages::find()->where(['item_id' => $this->id])->orderBy(['num' => SORT_ASC])->all();
        return ArrayHelper::map($imgs,'id','extstor_img_m');
    }


    /**
     * items image count
     * @return array|bool|int|string
     */
    public function getImagesCount()
    {
        return ItemsImages::find()->where(['item_id' => $this->id])->count();
    }


    /**
     * @return array
     */
    public function getCategoryName()
    {
        $cat = $this->cat;
        $template = [];
        while($cat->parent_id){
            array_unshift($template, $cat->title);
            $cat = Categories::findOne($cat->parent_id);
        }
        return $template;
    }


    /**
     * categoriyani listini olish
     * @return false|string
     */
    public function getCategoriesList()
    {
        $data = Categories::find()->
                        select(['id','parent_id','title'])->
                        indexBy('id')->
                        asArray()->
                        orderBy([
                            'sorting' => SORT_ASC,
                        ])->
                        all();
        $tree = [];
        foreach ($data as $id => &$node) {
            if($node['parent_id'] == 0)
                $tree[$id] = &$node;
            else
                $data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return json_encode($this->getSelectData($tree), JSON_UNESCAPED_UNICODE);
    }


    /**
     * @param $tree
     * @return mixed
     */
    public function getSelectData($tree)
    {
        if(!empty($tree))
            foreach ($tree as $key => $value) {
                $object = (object)['id' => $key, 'text' => $value['title'], 'parent_id' => $value['parent_id']];
                $this->list[] = $object;
                if(!empty($value['childs'])){
                    $this->getSelectData($value['childs']);
                }
            }
        return $this->list;
    }


    /**
     * parentiga tegishli listi
     * @param $parent_id
     * @return array
     */
    public function getListCategory($parent_id)
    {
        $data = Categories::find()->where(['parent_id' => $parent_id])->all();
        return \yii\helpers\ArrayHelper::map($data,'id','title');
    }


    /**
     * statusni name
     * @return string
     */
    public function getStatusName()
    {
        return "<b>" . self::STATUS_ITEMS[$this->getStatus()] . "</b> (" . date('H:i d.m.Y',strtotime($this->status_changed)) . ")";
    }


    /**
     * owner type
     * @return string[]
     */
    public function getOwnerType()
    {
        return self::OWNER_TYPE;
    }


    /**
     * elonni qaysi ustroysvadan ko'rsatish
     * @return string
     */
    public function getFromDevice()
    {
        if($this->from_device == 1) return 'Сайт';
        elseif($this->from_device == 2) return 'Телеграм Бот';
        elseif($this->from_device == 3) return 'Андроид';
        elseif($this->from_device == 4) return 'IOS';
        return 'Не задано';
    }


    /**
     * districtni lisitini olish
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getDistrictsList()
    {
        $sql = "SELECT r.name as region, d.id as id, d.name as district FROM regions AS r, districts AS d WHERE d.region_id=r.id;";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        return ArrayHelper::map($data,'id','district','region');
    }


    public function getUsersList()
    {
        $data = Users::find()->asArray()->all();
        $arr = [];
        foreach ($data as $key => $value) {
            if($value['fio'] != null) $arr[$value['id']] = $value['fio'];
            else {
                if($value['email'] != null) $arr[$value['id']] = $value['email'];
                else $arr[$value['id']] = $value['phone'];
            }
        }
        return $arr;
    }

    public function getUsersWithPhone()
    {
        $data = Users::find()->asArray()->all();
        $arr = [];
        foreach ($data as $key => $value) {
            if($value['phone'] != null) $arr[$value['id']] = $value['phone'];
        }
        return $arr;
    }


    /**
     * elonlarni status boyicha filtrlashga kerak
     * @return int
     */
    public function getStatus()
    {
        if($this->status == 3 && $this->is_publicated == 1 && $this->is_moderating == 0) return self::STATUS_PUBLICATIOM;
        if($this->status == 4 && $this->is_publicated == 0 && $this->is_moderating == 0) return self::STATUS_INPUBLICATION;
        if($this->status == 3 && $this->is_publicated == 0 && $this->is_moderating == 1) return self::STATUS_MODERATING;
        if($this->status == 1 && $this->is_publicated == 0 && $this->is_moderating == 0) return self::STATUS_INACTIVE;
        if($this->status == 5 && $this->is_publicated == 0 && $this->is_moderating == 0) return self::STATUS_BLOCKED;
        if($this->status == 6 && $this->is_publicated == 0 && $this->is_moderating == 0) return self::STATUS_DELETED;
    }


    /**
     * statusni ozgartirish uchun kerakli funksiyasi
     * @param $status
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function changeStatusTo($status)
    {
        /*$statuses = self::STATUS_TYPE[$status]['statuses'];
        Yii::$app->db->createCommand()->update('items', [
            'status_changed' => Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i:s'),
            'status' => $statuses['status'],
            'is_moderating' => $statuses['is_moderating'],
            'is_publicated' => $statuses['is_publicated'],
        ], 'id = '.$this->id)->execute();*/

        $statuses = self::STATUS_TYPE[$status]['statuses'];
        if($this->is_publicated == 0 && $this->is_moderating == 1 && $this->status == 3 && strtotime($this->date_up) > 0 && strtotime($this->date_cr) == strtotime($this->date_up)) {
            Yii::$app->db->createCommand()->update('items', [
                'status_changed' => Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i:s'),
                'status' => $statuses['status'],
                'is_moderating' => $statuses['is_moderating'],
                'is_publicated' => $statuses['is_publicated'],
            ], 'id = '.$this->id)->execute();
        }
        else {
            Yii::$app->db->createCommand()->update('items', [
                //'status_changed' => Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i:s'),
                'status' => $statuses['status'],
                'is_moderating' => $statuses['is_moderating'],
                'is_publicated' => $statuses['is_publicated'],
            ], 'id = '.$this->id)->execute();

        }

        $itemClearCache = Yii::$app->params['itemClearCache'] . $this->link;
        $homepage = $this->file_get_contents_curl($itemClearCache);
    }

    public function file_get_contents_curl($url){
        $arrContextOptions = stream_context_create([
            "ssl"=>[
                "verify_peer"   =>  false,
                "verify_peer_name"  =>  false,
            ],
        ]);
        return file_get_contents($url , false , $arrContextOptions);
    }

    /**
     * itemsni viewi uchun rasmlar listi
     * @return string
     */
    public function getItemsImageView()
    {
//        $conn_id = self::connectFtp();
        $template = '<div class="superbox">';
        $imgs = $this->getImages();
        $dir = self::DIR_NAME;
        $admin = self::getImageSiteName();
        foreach ($imgs as $key => $value) {
            $path = $admin.'/web/uploads/'.$dir.'/'.$value;
            $img = '<div class="superbox-list" style="width:25%; margin:5px;">
                                    <img src="' . $path . '" data-img="' . $path . '" alt="" style="cursor:default !important;" class="superbox-img">
                              </div>';
            $template .= $img;
        }
        return $template.'</div>';
    }

    /**
     * get price function
     * @return string|string[]|null
     */
    public function getPriceForApi()
    {
        $price = null;
        $currencyName = null;
        if ($this->currency != null) $currencyName = $this->currency->name;

        if ($this->cat->price) {
            if ($this->price_ex === 0) {
                //$price = number_format($this->price, 2, '.', ' ') . ' ' . $currencyName;
                $price = number_format($this->price, 2, '.', ' ');
                if($this->cat->price_diapazone && $this->price_end > 0) $price .= ' - ' . number_format($this->price_end, 2, '.', ' ');
                $price .= ' ' . $currencyName;
                $price = str_replace('.00', '', $price);
            }
            elseif ($this->price_ex == 1) {
                //$price = number_format($this->price, 2, '.', ' ') . ' ' . $currencyName;
                $price = number_format($this->price, 2, '.', ' ');
                if($this->cat->price_diapazone && $this->price_end > 0) $price .= ' - ' . number_format($this->price_end, 2, '.', ' ');
                $price .= ' ' . $currencyName;
                $price = str_replace('.00', '', $price);
            }
            elseif ($this->price_ex == 2) $price = 'Обмен';
            elseif ($this->price_ex == 4) $price = 'Бесплатно';
            elseif ($this->price_ex == 8) $price = 'Договорная';
        }

        return $price;
    }


    /**
     * dyn drop qiymatlar
     * @return array
     */
    public function getAdditionalFieldValue()
    {
        if(!$this->cat) return [];
        $fields = $this->cat->getAdditionalFieldsForTelegra();
        $types = CategoriesDynprops::TYPE_LIST;
        $arr = [];
        foreach ($fields as $key => $value) {
            switch ($value->type) {
                case CategoriesDynprops::TYPE4:{
                    $val = $this->{'f'.$value->data_field};
                    if($val != null)
                        $arr[] = [
                            'type' => $value->type,
                            'title' => $value->title,
                            'value' => ($val == 2) ? Yii::t('app','Yes') : Yii::t('app','No'),
                            'typeName' => $types[$value->type]
                        ];
                    break;
                }
                case CategoriesDynprops::TYPE6:{
                    $boshqa_nom = CategoriesDynpropsMulti::find()->where(['value' => $this->{'f'.$value->data_field},'dynprop_id' => $value->id])->one();
                    if($boshqa_nom != null)
                        $arr[] = [
                            'type' => $value->type,
                            'title' => $value->title,
                            'value' => $boshqa_nom->name,
                            'typeName' => $types[$value->type]
                        ];
                    break;
                }
                case CategoriesDynprops::TYPE8:{
                    $val = CategoriesDynpropsMulti::find()->where(['value' => $this->{'f'.$value->data_field},'dynprop_id' => $value->id])->one();
                    if($val != null && $val->name != null)
                        $arr[] = [
                            'type' => $value->type,
                            'title' => $value->title,
                            'value' => $val->name,
                            'typeName' => $types[$value->type]
                        ];
                    break;
                }
                case CategoriesDynprops::TYPE9:{
                    $variants = CategoriesDynpropsMulti::find()->where(['dynprop_id' => $value->id])->orderBy(['id' => SORT_DESC])->all();
                    $temp_arr = [];
                    $val = (int)$this->{'f'.$value->data_field};
                    foreach ($variants as $key => $variant) {
                        if($val >= (int)$variant->value){
                            $val -= (int)$variant->value;
                            array_push($temp_arr, $variant->name);
                        }
                    }
                    if(count($temp_arr) > 0)
                        $arr[] = [
                            'type' => $value->type,
                            'title' => $value->title,
                            'value' => implode(",",$temp_arr),
                            'typeName' => $types[$value->type]
                        ];
                    break;
                }
                case CategoriesDynprops::TYPE1:
                case CategoriesDynprops::TYPE2:
                case CategoriesDynprops::TYPE5:
                case CategoriesDynprops::TYPE10:
                case CategoriesDynprops::TYPE11:{
                    $val = $this->{'f'.$value->data_field};
                    if($val != null)
                        $arr[] = [
                            'type' => $value->type,
                            'title' => $value->title,
                            'value' => $val,
                            'typeName' => $types[$value->type]
                        ];
                    break;
                }
            }
        }
        return $arr;
    }


    /**
     * period list
     * @return string[]
     */
    public function  getPeriodList()
    {
        return [
            30 => "1 месяц",
            90 => "3 месяц",
            180 => "6 месяц",
            360 => "12 месяц",
        ];
    }


    /**
     * pullik xizmat yoqilganmi yoki yoqmi , shuni tekshirish
     * @return bool
     */
    public function getCheckServices()
    {
        return $this->serviceUp() || $this->serviceFixed() || $this->servicePremimum() || $this->serviceMarked() || $this->serviceQuick() ? '<i class="fa fa-money" style="font-size: 20px; color: #ff704d"></i>' : '';
    }


    /**
     * @return bool
     */
    public function getCheckServicesForSearch()
    {
        return ($this->serviceUp() || $this->serviceFixed() || $this->servicePremimum() || $this->serviceMarked() || $this->serviceQuick());
    }

    /**
     * podnyad
     * @return bool
     */
    public function serviceUp(): bool
    {
        if($this->svc_up_activate && time() < strtotime($this->svc_up_date)) return true;
        else return false;
    }


    /**
     * zakrepit
     * @return bool
     */
    public function serviceFixed()
    {
        if($this->svc_fixed && time() < strtotime($this->svc_fixed_to)) return true;
        else return false;
    }


    /**
     * premium
     * @return bool
     */
    public function servicePremimum()
    {
        if($this->svc_premium && time() < strtotime($this->svc_premium_to)) return true;
        else return false;
    }


    /**
     * videleniye
     * @return bool
     */
    public function serviceMarked()
    {
        if( time() < strtotime($this->svc_marked_to)) return true;
        else return false;
    }


    /**
     * srochna
     * @return bool
     */
    public function serviceQuick()
    {
        if( time() < strtotime($this->svc_quick_to)) return true;
        else return false;
    }

    public function getServicesList(){
        $services = Services::find()
            ->select(['id' , 'title' , 'enabled' , 'module'])
            ->andWhere(['module' => 'bbs'])
            ->andWhere(['enabled' => 1 ])
            ->andWhere(['type' => 1 ])
            ->orderBy(['sorting' => SORT_ASC])
            ->all();
        return ArrayHelper::map($services, 'id', 'title');
    }
}
