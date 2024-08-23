<?php

namespace backend\models\shops;

use Yii;
use backend\models\references\Translates;
use backend\models\users\Users;
use backend\models\promocodes\Promocodes;
use backend\models\items\PaketsService;
use backend\models\items\Categories;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property int|null $type Тип
 * @property int|null $changed_id Кто изменил
 * @property string|null $keyword Уникальный Клю
 * @property string|null $module Модуль
 * @property string|null $module_title Заголовок Модула
 * @property string|null $title Заголовок
 * @property float|null $price Стоимость
 * @property string|null $short_description Короткое Описание
 * @property string|null $description Описание
 * @property int|null $day Количество дней
 * @property int|null $sorting Сортировка
 * @property string|null $icon_b Иконка (большая)
 * @property string|null $icon_s Иконка (малая)
 * @property bool|null $enabled Статус
 * @property string|null $color Цвет
 * @property string|null $date_cr Дата создания
 * @property string|null $date_up Дата изменение
 *
 * @property RegionalPrices[] $regionalPrices
 * @property Users $changed
 * @property TariffServiceDiscount[] $tariffServiceDiscounts
 */
class Services extends \yii\db\ActiveRecord
{

    public $translation_title;
    public $translation_short_description;
    public $translation_description;
    public $small_img;
    public $img;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const TYPE_SERVICE = 1;
    const TYPE_PACKET = 2;
    const MODULE_BBS = 'bbs';
    const MODULE_SHOPS = 'shops';

    const DIR_NAME = 'services';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    // public function behaviors()
    // {
    //     return [
    //         'slug' => [
    //             'class' => 'skeeks\yii2\slug\SlugBehavior',
    //             'slugAttribute' => 'keyword',                      //The attribute to be generated
    //             'attribute' => 'title',                          //The attribute from which will be generated
    //             // optional params
    //             'maxLength' => 64,                              //Maximum length of attribute slug
    //             'minLength' => 3,                               //Min length of attribute slug
    //             'ensureUnique' => true,
    //             'slugifyOptions' => [
    //                 'lowercase' => true,
    //                 'separator' => '-',
    //                 'trim' => true,
    //                 //'regexp' => '/([^A-Za-z0-9]|-)+/',
    //                 'rulesets' => ['russian'],
    //                 //@see all options https://github.com/cocur/slugify
    //             ]
    //         ]
    //     ];
    // }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price','description','short_description','title'],'required'],
            [['type', 'changed_id', 'sorting'], 'default', 'value' => null],
            [['type', 'changed_id', 'day', 'sorting', 'free_period', 'period_type'], 'integer'],
            [['price'], 'number'],
            [['short_description', 'description'], 'string'],
            [['enabled','auto_enabled','add_form'], 'boolean'],
            [['date_cr', 'date_up'], 'safe'],
            [['keyword', 'module', 'module_title', 'title', 'icon_b', 'icon_s', 'color'], 'string', 'max' => 255],
            [['changed_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['changed_id' => 'id']],
            [['translation_title','translation_short_description','translation_description','small_img' ,'img'],'safe'],
            [['enabled'],'default','value' => 0],
            [['day'],'required','when' => function($model){return $model->type == 1 && $model->keyword != 'up' && $model->keyword != 'press';}]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'changed_id' => 'Кто изменил',
            'keyword' => 'Уникальный Клю',
            'module' => 'Модуль',
            'module_title' => 'Заголовок Модула',
            'title' => 'Заголовок',//
            'translation_title' => 'Заголовок',//
            'price' => 'Стоимость',
            'short_description' => 'Короткое Описание',//
            'translation_short_description' => 'Короткое Описание',//
            'description' => 'Описание',//
            'translation_description' => 'Описание',//
            'day' => 'Количество дней',
            'sorting' => 'Сортировка',
            'icon_b' => 'Иконка (большая)',
            'icon_s' => 'Иконка (малая)',
            'img' => 'Иконка (большая)',
            'small_img' => 'Иконка (малая)',
            'enabled' => 'Статус',
            'color' => 'Цвет',
            'date_cr' => 'Дата создания',
            'date_up' => 'Дата изменение',
            'auto_enabled'  => 'Автоподнятие',
            'free_period'  => 'Бесплатное поднятие',
            'add_form'  => 'В форме добавления',
            'period_type'  => 'Стоимость услуги'
        ];
    }

    public static function NeedTranslation()
    {
        return [
            'title'=>'translation_title',
            'short_description'=>'translation_short_description',
            'description'=>'translation_description'
        ];
    }

    /**
     * Gets query for [[Promocodes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromocodes()
    {
        return $this->hasMany(Promocodes::className(), ['service_id' => 'id']);
    }


    /**
     * Gets query for [[RegionalPrices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegionalPrices()
    {
        return $this->hasMany(RegionalPrices::className(), ['service_id' => 'id']);
    }

    /**
     * Gets query for [[Changed]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChanged()
    {
        return $this->hasOne(Users::className(), ['id' => 'changed_id']);
    }

    /**
     * Gets query for [[TariffServiceDiscounts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTariffServiceDiscounts()
    {
        return $this->hasMany(TariffServiceDiscount::className(), ['service_id' => 'id']);
    }


    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->date_cr = Yii::$app->formatter->asDate(time(),'php:Y-m-d H:i');
        }else{
            if($this->date_cr)
                $this->date_cr = Yii::$app->formatter->asDate($this->date_cr,'php:Y-m-d H:i');
        }
        $this->date_up = Yii::$app->formatter->asDate(time(),'php:Y-m-d H:i');
        
        $this->changed_id = Yii::$app->user->identity->id;

        return parent::beforeSave($insert);
    }


    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        Translates::deleteAll(['table_name'=>$this->tableName(),'field_id'=>$this->id]);
        $this->deleteImage();
        
        return true;
    }


    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function afterFind()
    {
        if($this->date_cr)
            $this->date_cr = Yii::$app->formatter->asDate($this->date_cr,'php: H:i d.m.Y');
        if($this->date_up)
            $this->date_up = Yii::$app->formatter->asDate($this->date_up,'php: H:i d.m.Y');

        return parent::afterFind();
    }


    /**
     * @return mixed
     */
    public static function getAdminSiteName()
    {
        $adminka = Yii::$app->params['adminka'];
        // $admin = ( $adminka != '') ? '/' . $adminka : $adminka; 
        return $adminka;
    }


    /**
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
     * @return mixed
     */
    public static function getImageSiteName()
    {
        $adminka = Yii::$app->params['image_site'];
        return $adminka;
    }


    /**
     * @param false $small
     * @param string $width
     * @param string $height
     * @return string
     */
    public function getImg($small = false, $width = "",$height = "")
    {
        $admin = self::getImageSiteName();

        $img = ($small) ? $this->icon_s : $this->icon_b;
        $dir = self::DIR_NAME;
        
        if($this->small_img && $small){
            $img = $this->small_img ;
            $dir = 'trash';
        }

        $path = $admin.'/web/uploads/'.$dir.'/'.$img;
        if ($this->icon_b == null || $this->icon_b == '') {
            $path = '/uploads/noimg.jpg';
        }

        if($width != "" && $height != "")
            return '<img style="width:'.$width.'px;height:'.$height.'" src="'.$path.'">';
        else
            return '<img style="width:80px;height:80px" src="'.$path.'">';
    }


    /**
     * fayllarini saqlash uchun
     * @throws \yii\base\Exception
     */
    public function UploadImage()
    {
        $dir = self::DIR_NAME;
        $source_path = '/web/uploads/trash/';
        $destination_path = '/web/uploads/'.$dir.'/';
        
        $conn_id = self::connectFtp();

        if($this->small_img != "")
        {
            $value = $this->small_img;
            $res = ftp_size($conn_id, $source_path.$value);
            if ($res != -1) {
                $ext = substr(strrchr($value, "."), 1); 
                $fileName = $this->id . '-' . Yii::$app->security->generateRandomString() . '.' . $ext;
                ftp_rename($conn_id, $source_path.$value, $destination_path.$fileName);
                $this->icon_s = $fileName;            
            } 
        }

        if($this->img != "")
        {
            $value = $this->img;
            $res = ftp_size($conn_id, $source_path.$value);
            if ($res != -1) {
                $ext = substr(strrchr($value, "."), 1); 
                $fileName = $this->id . '-' . Yii::$app->security->generateRandomString() . '.' . $ext;
                ftp_rename($conn_id, $source_path.$value, $destination_path.$fileName);
                $this->icon_b = $fileName;            
            }
        }
        $this->save(false);
    }


    /**
     *  rasmlarni uchirish
     */
    public function deleteImage()
    {
        $dir = self::DIR_NAME;
        $path = '/web/uploads/'.$dir.'/';

        $conn_id = self::connectFtp();

        $res = ftp_size($conn_id, $path . $this->icon_s);
        if ($res != -1 && $this->icon_s) {
            ftp_delete($conn_id, $path . $this->icon_s);
        }

        $res = ftp_size($conn_id, $path . $this->icon_b);
        if ($res != -1 && $this->icon_b) {
            ftp_delete($conn_id, $path . $this->icon_b); 
        }
    }


    /**
     * status nomlari
     * @param null $status
     * @return string
     */
    public static function getStatusName($status = null)
    {
        return ($status == 1) ? '<span class="label label-success"> Активно </span>' : '<span class="label label-danger">Не активно</span>';
    }


    /**
     * status turlari
     * @return string[]
     */
    public static function getStatusType()
    {
       return 
            [
                self::STATUS_INACTIVE => 'Не активно',
                self::STATUS_ACTIVE => 'Активно'
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
                $t = Translates::find()->where(['table_name' => $this->tableName(),'field_id' => $this->id,'language_code' => $l,'field_name'=>$key]);
                if($t->count() == 1){
                    $tt = $t->one();
                    $tt->field_value=$post["Services"][$value][$l];
                    $tt->save();
                }else{
                    $t = new Translates();
                    $t->table_name = $this->tableName();
                    $t->field_id = $this->id;
                    $t->field_name = $key;
                    $t->field_value = $post["Services"][$value][$l];
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
        $translations = Translates::find()->where(['table_name' => $this->tableName(), 'field_id' => $this->id])->all();
        foreach ($translations as $key => $value) {
            switch ($value->field_name) {
                case 'title':
                    $translation_title[$value->language_code] = $value->field_value;
                    break;
                case 'description':
                    $translation_description[$value->language_code] = $value->field_value;
                    break;
                default:
                    $translation_short_description[$value->language_code] = $value->field_value;
                    break;
            }
        }

        if(!isset($translation_title))
            $translation_title = null;
        if(!isset($translation_description))
            $translation_description = null;
        if(!isset($translation_short_description))
            $translation_short_description = null; 

        $this->translation_title = $translation_title;
        $this->translation_short_description = $translation_short_description;
        $this->translation_description = $translation_description;
    }


    /**
     * region list
     * @return array
     */
    public function getRegionsList()
    {
        $data = \backend\models\references\Regions::find()->all();
        return ArrayHelper::map($data,'id','name');
    }


    /**
     * @param $parent
     */
    public function generate_menu($parent)
    {
        $has_childs = false;
        //this prevents printing 'ul' if we don't have subcategories for this category
        global $menu_array;
        //use global array variable instead of a local variable to lower stack memory         requierment
        foreach($menu_array as $key => $value)
        {
            if ($value['parentid'] == $parent) 
            {       
                //if this is the first child print '<ul>'                       
                if ($has_childs === false)
                {
                //don't print '<ul>' multiple times                             
                $has_childs = true;
                //echo '<ul>';
                echo '<ul id="categories">';
                }
            echo '<li><a href="categories?catid=' . $value['catid'] . '&parentid=' .                 $value['parentid'] . '&catname=' . $value['catname'] .'">' .         $value['catname'] . '</a>';
            echo '<input type="hidden" value="' . $value['catname'] . '" />';
            generate_menu($key);
            //call function again to generate nested list for subcategories belonging to this         category
            echo '</li>';
            }
            if ($has_childs === true) echo '</ul>';
        }
    }


    /**
     * @return array
     */
    public function getCategoriesList()
    {
        $data = Categories::find()->where(['!=', 'keyword', 'root'])->andwhere(['enabled' => 1])->indexBy('id')->asArray()->all();
        return ArrayHelper::map($data,'id','title');

        /*ichma ich chiqadigan qiish kerak, oprgroupga moslab*/
        $data = Categories::find()->indexBy('id')->asArray()->all();
        // return ArrayHelper::map($data,'id','title');

        foreach ($data as $id => &$node) {
            if($node['parent_id'] == 0)
                $tree[$id] = &$node;
            else
                $data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        // print_r($tree);die;
        return $tree;
    }

    public function getPeriodType()
    {
        return [
             1 => 'За указанный период', 
             2 => 'За один день'
        ];
    }


    /**
     * @return array
     */
    public function getServices()
    {
        $existed_services = PaketsService::find()->indexBy('service_id')->where(['paket_id' => $this->id])->all();
        $existed_ids = ArrayHelper::getColumn($existed_services,'service_id');

        $all_services = Services::find()->where(['type' => self::TYPE_SERVICE, 'module' => self::MODULE_BBS])->all();
        $all_ids = ArrayHelper::getColumn($all_services,'id');

        $model_arrays = [];

        foreach ($all_ids as $value) {
            if(in_array($value, $existed_ids)){
                $model_arrays [] = $existed_services[$value];
                continue;
            }
            $new_model = new PaketsService();
            $new_model->paket_id = $this->id;
            $new_model->service_id = $value;
            $new_model->value = 0;
            $new_model->save(false);
            $model_arrays [] = $new_model;
        }

        return $model_arrays;        
    }

    public function saveServices($services)
    {
        foreach ($services as $key => $value) {
            $value->paket_id = $this->id;
            $value->save(false);
        }
    }
}
