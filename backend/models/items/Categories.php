<?php

namespace backend\models\items;

use backend\components\StaticFunction;
use backend\models\promocodes\PromocodesUsage;
use Yii;
use yii\helpers\ArrayHelper;
use backend\models\references\Translates;
use backend\models\references\Lang;
use backend\models\items\CategoriesDynprops;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property int|null $sorting Сортировка
 * @property int|null $numlevel Уровень
 * @property string|null $icon_b Иконка (большая)
 * @property string|null $icon_s Иконка (малая)
 * @property string|null $keyword Ключ
 * @property bool|null $enabled Статус
 * @property string|null $date_cr Дата создание
 * @property string|null $date_up Дата изменение
 * @property int|null $parent_id Подкатегория
 * @property string|null $title Заголовок
 * @property string|null $type_offer_form Предлагаю
 * @property string|null $type_offer_search Объявления
 * @property string|null $type_seek_form Ищу
 * @property string|null $type_seek_search Объявления
 * @property bool|null $seek Задействовать
 * @property bool|null $price Цена
 * @property bool|null $price_sett Элементы цены
 * @property int|null $photos Фотографии
 * @property bool|null $owner_business Представитель
 * @property string|null $owner_private_form Частное лицо
 * @property string|null $owner_private_search От частных лиц
 * @property string|null $owner_business_form Бизнес
 * @property string|null $owner_business_search Только бизнес объявления
 * @property bool|null $owner_search Галочка
 * @property bool|null $owner_search_business Галочка
 * @property bool|null $address Адрес
 * @property bool|null $metro Метро
 * @property bool|null $regions_delivery Доступна возможность указать доставку в регионы
 * @property int|null $list_type  Вид списка по умолчанию
 * @property string|null $keyword_edit URL Keyword
 * @property string|null $search_exrta_keywords Подсказки быстрого поиска
 * @property int|null $items
 * @property int|null $shops
 * @property int|null $subs_filter_level
 * @property string|null $subs_filter_title
 * @property string|null $tpl_title_enabled Автоматическая генерация заголовка
 * @property string|null $tpl_title_view Шаблон для просмотра объявления
 * @property string|null $tpl_title_list Шаблон для списка объявлений
 * @property string|null $tpl_descr_list Шаблон для описания объявления (список)
 * @property string|null $mtitle Заголовок
 * @property string|null $mkeywords Ключевые слова
 * @property string|null $mdescription Описание
 * @property string|null $breadcrumb Хлебная крошка
 * @property string|null $titleh1 Заголовок H1
 * @property string|null $seotext  SEO текст
 * @property int|null $landing_id
 * @property string|null $landing_url Посадочный URL
 * @property bool|null $mtemplate Использовать общий шаблон
 * @property string|null $view_mtitle Заголовок (title )
 * @property string|null $view_mkeywords  Ключевые слова (meta keywords)
 * @property string|null $view_mdescription Описание (meta description)
 * @property string|null $view_share_title Заголовок (поделиться в соц. сетях)
 * @property string|null $view_share_description Описание (поделиться в соц. сетях)
 * @property string|null $view_share_sitename Название сайта (поделиться в соц. сетях)
 * @property string|null $view_mtemplate использовать общий шаблон
 * @property string|null $telegram_chanel Telegram kanal nomi
 *
 * @property Categories $parent
 * @property Categories[] $categories
 * @property CategoriesDynprops[] $categoriesDynprops
 * @property Items[] $items0
 * @property PromocodesUsage[] $promocodesUsages
 */
class Categories extends \yii\db\ActiveRecord
{

    /**
     * translation uchun kerak bolgan polyalar
     * @var
     */
    public $translation_title;
    public $translation_mtitle;
    public $translation_tpl_title_view;
    public $translation_tpl_title_list;
    public $translation_mkeywords;
    public $translation_tpl_descr_list;
    public $translation_titleh1;
    public $translation_seotext;
    public $translation_view_mtitle;
    public $translation_view_mkeywords;
    public $translation_view_mdescription;
    public $translation_view_share_title;
    public $translation_view_share_description;
    public $translation_view_share_sitename;
    public $translation_mdescription;
    public $small_img;
    public $img;
    public $translation_breadcrumb;
    public $translation_type_offer_form;
    public $translation_type_offer_search;
    public $translation_type_seek_form;
    public $translation_type_seek_search;
    public $tarnslation_owner_private_form;
    public $translation_owner_private_search;
    public $translation_owner_business_form;
    public $translation_owner_business_search;

    //price_sett
    public $price_title;
    public $curr;
    public $ranges;
    public $ex;
    public $mod_title;
    public $mod_check;
    public $is_exchange;
    public $is_free;
    public $is_deal;

    public $type;
    const DIR_NAME = 'categories';
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const TYPE_BASE = 'base';
    const TYPE_TEMPLATE = 'template';
    const TYPE_SEO = 'seo';


    public $list;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sorting', 'numlevel', 'parent_id', 'photos', 'list_type', 'items', 'shops', 'subs_filter_level', 'landing_id'], 'default', 'value' => null],
            [['sorting', 'numlevel', 'parent_id', 'photos', 'list_type', 'items', 'shops', 'subs_filter_level', 'landing_id'], 'integer'],
            [['enabled', 'seek', 'price', 'owner_business', 'owner_search', 'owner_search_business', 'address', 'metro', 'regions_delivery', 'mtemplate','price_diapazone'], 'boolean'],
            [['date_cr', 'date_up'], 'safe'],
            [['search_exrta_keywords', 'subs_filter_title', 'tpl_title_enabled', 'tpl_title_view', 'tpl_title_list', 'tpl_descr_list', 'mkeywords', 'mdescription', 'seotext', 'landing_url', 'view_mdescription', 'view_share_description','price_sett'], 'string'],
            [['icon_b', 'icon_s', 'keyword', 'title', 'type_offer_form', 'type_offer_search', 'type_seek_form', 'type_seek_search', 'owner_private_form', 'owner_private_search', 'owner_business_form', 'owner_business_search', 'keyword_edit', 'mtitle', 'breadcrumb', 'titleh1', 'view_mtitle', 'view_mkeywords', 'view_share_title', 'view_share_sitename', 'view_mtemplate','telegram_chanel'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['small_img','img'],'safe'],
            [['price_title','ex','curr','mod_title','mod_check','ranges','is_free','is_exchange','is_deal'],'safe'],
            [['translation_owner_business_form', 'translation_owner_business_search','tarnslation_owner_private_form','translation_owner_private_search','translation_title','translation_tpl_title_view','translation_tpl_title_list','translation_tpl_descr_list','translation_type_offer_form' ,'translation_type_offer_search' ,'translation_type_seek_form' ,'translation_type_seek_search' ],'safe'],

            [['title'],'required','when'=>function($model){ return $model->type == self::TYPE_BASE;}]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sorting' => 'Сортировка',
            'numlevel' => 'Уровень',
            'icon_b' => 'Иконка (большая)',
            'icon_s' => 'Иконка (малая)',
            'keyword' => 'Ключ',
            'enabled' => 'Статус',
            'date_cr' => 'Дата создание',
            'date_up' => 'Дата изменение',
            'parent_id' => 'Подкатегория',
            'title' => 'Название',
            'type_offer_form' => 'Предлагаю',
            'type_offer_search' => 'Объявления',
            'type_seek_form' => 'Ищу',
            'type_seek_search' => 'Объявления',
            'seek' => 'Задействовать',
            'price' => 'Цена',
            'price_sett' => 'Элементы цены',
            'photos' => 'Фотографии',
            'owner_business' => 'Представитель',
            'owner_private_form' => 'Частное лицо',
            'owner_private_search' => 'От частных лиц',
            'owner_business_form' => 'Бизнес',
            'owner_business_search' => 'Только бизнес объявления',
            'owner_search' => 'Галочка',
            'owner_search_business' => 'Галочка',
            'address' => 'Адрес',
            'metro' => 'Метро',
            'regions_delivery' => 'Доставка в регионы',
            'list_type' => ' Вид списка по умолчанию',
            'keyword_edit' => 'URL Keyword',
            'search_exrta_keywords' => 'Подсказки быстрого поиска',
            'items' => 'Items',
            'shops' => 'Shops',
            'price_diapazone' => 'Добавить возможность диапазон цены',
            'subs_filter_level' => 'Subs Filter Level',
            'subs_filter_title' => 'Subs Filter Title',
            'tpl_title_enabled' => 'Автоматическая генерация заголовка',
            'tpl_title_view' => 'Шаблон для просмотра объявления',
            'tpl_title_list' => 'Шаблон для списка объявлений',
            'tpl_descr_list' => 'Шаблон для описания объявления (список)',
            'translation_tpl_title_view' => 'Шаблон для просмотра объявления',
            'translation_tpl_title_list' => 'Шаблон для списка объявлений',
            'translation_tpl_descr_list' => 'Шаблон для описания объявления (список)',
            'mtitle' => 'Заголовок',
            'mkeywords' => 'Ключевые слова',
            'mdescription' => 'Описание',
            'breadcrumb' => 'Хлебная крошка',
            'titleh1' => 'Заголовок H1',
            'seotext' => 'SEO текст',
            'landing_id' => 'Landing ID',
            'landing_url' => 'Посадочный URL',
            'translation_mtitle' => 'Заголовок',
            'mtemplate' => 'Использовать общий шаблон',
            'translation_mkeywords' => 'Ключевые слова',
            'view_mtitle' => 'Заголовок (title )',
            'translation_mdescription' => 'Описание',
            'view_mkeywords' => 'Ключевые слова (meta keywords)',
            'translation_breadcrumb' => 'Хлебная крошка',
            'view_mdescription' => 'Описание (meta description)',
            'translation_titleh1' => 'Заголовок H1',
            'view_share_title' => 'Заголовок (поделиться в соц. сетях)',
            'translation_seotext' => 'SEO текст',
            'view_share_description' => 'Описание (поделиться в соц. сетях)',
            'translation_view_mtitle' => 'Заголовок (title )',
            'view_share_sitename' => 'Название сайта (поделиться в соц. сетях)',
            'translation_view_mkeywords' => 'Ключевые слова (meta keywords)',
            'view_mtemplate' => 'использовать общий шаблон',
            'translation_view_mdescription' => 'Описание (meta description)',
            'translation_title' => 'Название',
            'translation_view_share_title' => 'Заголовок (поделиться в соц. сетях)',
            'img' => 'Иконка (большая)',
            'translation_view_share_description' => 'Описание (поделиться в соц. сетях)',
            'small_img' => 'Иконка (малая)',
            'translation_view_share_sitename' => 'Название сайта (поделиться в соц. сетях)',

            //price_sett
            'price_title' => 'Заголовок цены',
            'curr' => 'Валюта по умолчанию',
            'ranges' => 'Диапазоны цен',
            'ex' => '',
            'mod_title' => 'Модификатор',
            'is_free' => 'Бесплатно',
            'is_exchange' => 'Обмен',
            'is_deal' => 'Договорная',
            'telegram_chanel' =>'Название телеграмм канала'
        ];
    }


    public function setKeywordEvalution()
    {
        $this->numlevel = $this->parent->numlevel+1;
        $this->keyword =  $this->parent->keyword.'/'.StaticFunction::slugify($this->title,['limit'=>100]);
        $this->save();
        return true;
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Categories::className(), ['id' => 'parent_id']);
    }



    public function getChildren()
    {
        return $this->hasMany(Categories::className(), ['parent_id' => 'id'])->with('children');
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Categories::className(), ['parent_id' => 'id']);
    }


    /**
     * Categoriyaning childlarini topamiz
     */
    public static function getParentChildren($category_id)
    {
        static $increment = 0;
        $childs = Categories::find()->where(['parent_id' => $category_id])->asArray()->all();
        $result = [];
        if($childs){
            foreach ($childs as $child){
                $result += self::getChildren($child['id']);
            }
        }else{
            $result[$increment++] = $category_id;
        }
        return $result;
    }


    /**
     * @param $elements
     * @param $parentId
     * @param array|null $result
     * @return array|null
     */
    public static function buildTree($elements, $parentId, array &$result = null)
    {
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $result [] = $element['id'];
                $children = self::buildTree($element['children'], $element['id'], $result);
                if ($children) {
                    $element['children'] = $children;
                }
            }
        }
        return $result;
    }

    /**
     * Gets query for [[CategoriesDynprops]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoriesDynprops()
    {
        return $this->hasMany(CategoriesDynprops::className(), ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Items0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItems0()
    {
        return $this->hasMany(Items::className(), ['cat_id' => 'id']);
    }

    /**
     * Gets query for [[PromocodesUsages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromocodesUsages()
    {
        return $this->hasMany(PromocodesUsage::className(), ['category_id' => 'id']);
    }
    /**
     * Gets query for [[ItemsLimits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemsLimits()
    {
        return $this->hasMany(ItemsLimits::className(), ['cat_id' => 'id']);
    }

    public static function NeedTranslation()
    {
        return [
            'title' => 'translation_title',
            'tpl_title_view' => 'translation_tpl_title_view',
            'tpl_title_list' => 'translation_tpl_title_list',
            'tpl_descr_list' => 'translation_tpl_descr_list',
            'mtitle' => 'translation_mtitle',
            'mkeywords' => 'translation_mkeywords',
            'mdescription' => 'translation_mdescription',
            'breadcrumb' => 'translation_breadcrumb',
            'titleh1' => 'translation_titleh1',
            'seotext' => 'translation_seotext',
            'view_mtitle' => 'translation_view_mtitle',
            'view_mkeywords' => 'translation_view_mkeywords',
            'view_mdescription' => 'translation_view_mdescription',
            'view_share_title' => 'translation_view_share_title',
            'view_share_description' => 'translation_view_share_description',
            'view_share_sitename' => 'translation_view_share_sitename',
            'type_offer_form' => 'translation_type_offer_form',
            'type_offer_search' =>'translation_type_offer_search',
            'type_seek_form' => 'translation_type_seek_form',
            'type_seek_search' =>'translation_type_seek_search',
            'owner_private_form' => 'tarnslation_owner_private_form',
            'owner_private_search' => 'translation_owner_private_search',
            'owner_business_form' => 'translation_owner_business_form',
            'owner_business_search' => 'translation_owner_business_search',
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->date_cr = Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i');
        }

        if($this->id == 1){
            $this->parent_id = null;
        }
        return parent::beforeSave($insert);
    }

    public function savePriceSett($post)
    {
        $range = [];
        for($i=0, $iMax = count($post['from']); $i< $iMax; $i++){
            if($i == 0) continue;
            if($post['from'][$i] == '' || $post['to'][$i] == '') continue;
            $range[] = [
                'from' => $post['from'][$i],
                'to' => $post['to'][$i]
            ];
        }
        if($this->price == 1){
            $arr = [
                'title' => $this->price_title,
                'curr' => $this->curr,
                'ranges' => $range,
                'ex' => $this->ex,
                'mod_title' => $this->mod_title
            ];
        }else{
            $arr = [
                'title' => [],
                'curr' => '',
                'ranges' => [],
                'ex' => 0,
                'mod_title' => []
            ];
        }
        $this->price_sett = serialize($arr);
    }


    /**
     * udalit qilishdan song tarjimalarni ochirish
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
     * image siteni urlni olish
     * @return mixed
     */
    public static function getAdminSiteName()
    {
        return Yii::$app->params['image_site'];
    }

    public function afterFind()
    {
        return parent::afterFind();
    }


    /**
     * @param $langs
     */
    public function getPriceSett($langs)
    {
        //price_sett bilan ishlash
        if(!$this->price_sett) return;
        $price_sett = unserialize($this->price_sett);
        $arr = [];
        foreach ($langs as $key => $value) {
            $arr [$value->url] = '';
        }
        foreach ($arr as $key => $value) {
            if(isset($price_sett['title'][$key]))
                $arr[$key] = $price_sett['title'][$key];
        }

        $this->price_title = $arr;
        $this->curr = $price_sett['curr'];
        $this->ex= $price_sett['ex'];
        $this->ranges = $price_sett['ranges'];
        //mod_title ni yuklab olish
        $arr = [];
        foreach ($langs as $key => $value) {
            $arr [$value->url] = '';
        }
        foreach ($arr as $key => $value) {
            if(isset($price_sett['mod_title'][$key]))
                $arr[$key] = $price_sett['mod_title'][$key];
        }
        $this->mod_title = $arr;

        $ex = (int)$this->ex;
        if($ex - 8 >= 0){
            $ex -= 8;
            $this->is_deal = 1;
        }
        if($ex - 4 >= 0){
            $ex -= 4;
            $this->is_free= 1;
        }
        if($ex - 2 >= 0){
            $ex -= 2;
            $this->is_exchange = 1;
        }
        if($ex - 1 >= 0){
            $ex -= 1;
            $this->mod_check = 1;
        }
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
     * image ni urlni olish
     * @return mixed
     */
    public static function getImageSiteName()
    {
        $adminka = Yii::$app->params['image_site'];
        return $adminka;
    }


    /**
     * imageni adresini olish
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

        if($this->img && (!$small) ){
            $img = $this->img;
            $dir = 'trash';
        }

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
     * rasmni uchirish
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
     * imageni adresini olish
     * @param $image
     * @return string
     */
    public static function getImageAddress($image)
    {
        $admin = self::getImageSiteName();
        $dir = self::DIR_NAME;
        if ($image)
            return $admin."/web/uploads/".$dir."/$image";
        return $admin. "/web/uploads/noimg.jpg";
    }


    /**
     * @param null $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getColumnsList($id = null)
    {
        $active = [];
        if( $id == null ){
            $categories = self::find()->where(['parent_id' => NULL])->select(['id','title'])->asArray()->indexBy('id')->orderBy(['sorting' => SORT_ASC])->all();
        }else{
            $categories = self::find()->where(['parent_id' => $id])->select(['id','title'])->asArray()->indexBy('id')->orderBy(['sorting' => SORT_ASC])->all();
        }
        return $categories;
    }

    public static function getStatusName($status = null)
    {
        return ($status == self::STATUS_ACTIVE) ? '<span class="text-success text-muted">Активно</span>' : '<span class="text-danger text-muted">Не активно</span>';
    }

    public static function getStatusTemplate($status,$id)
    {
        $admin = self::getAdminSiteName();

        return ($status == self::STATUS_ACTIVE) ?
            '<span onclick=" $(this).css({cursor:\'progress\'}); $.post(\'' . $admin . '/shops/shop-categories/change-status?id='.$id.'\',function(success){$(this).css({cursor:\'default\'}); $.pjax.reload(\'#crud-datatable-pjax\', {timeout : false});})" class="switchery" style="background-color: rgb(0, 172, 172); border-color: rgb(0, 172, 172); box-shadow: rgb(0, 172, 172) 0px 0px 0px 16px inset; transition: border 0.5s ease 0s, box-shadow 0.5s ease 0s, background-color 1.5s ease 0s;"><small style="left: 20px; transition: left 0.25s ease 0s;"></small></span><br> '.self::getStatusName($status)
        :
            '<span onclick=" $(this).css({cursor:\'progress\'}); $.post(\'' . $admin . '/shops/shop-categories/change-status?id='.$id.'\',function(success){$(this).css({cursor:\'default\'}); $.pjax.reload(\'#crud-datatable-pjax\', {timeout : false});})" class="switchery" onclick="" style="background-color: rgb(255, 255, 255); border-color: rgb(223, 223, 223); box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; transition: border 0.5s ease 0s, box-shadow 0.5s ease 0s;"><small style="left: 0px; transition: left 0.25s ease 0s;"></small></span><br> '.self::getStatusName($status);
    }


    /**
     * cildini bormi yoki yoqmi tekshrirish
     * @return bool
     */
    public function ifHaveChild()
    {
        $count = Categories::find()->indexBy('id')->where(['parent_id' => $this->id])->count();
        return $count > 0;
    }


    /**
     * categoriyani listi olish
     * @return false|string
     */
    public function getCategoriesList()
    {
        $data = Categories::find()->
                        select(['id','parent_id','title'])->
                        indexBy('id')->
                        where(['enabled' => 1])->
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
        static $level = 0;
        if(!empty($tree))
            foreach ($tree as $key => $value) {
                $object = (object)['id' => $key, 'text' => $value['title'], 'level' => $level];
                $this->list[] = $object;
                if(!empty($value['childs'])){
                    $level++;
                    $this->getSelectData($value['childs']);
                    $level--;
                }
            }
        return $this->list;
    }


    /**
     * parentlarini idlarini olish
     * @param $category_id
     * @return array
     */
    public static function getCategoryForParentId($category_id)
    {
        static $k = 0;
        $categories[$k++] = $category_id;
        $result = Categories::find()->
                        where(['parent_id' => $category_id])->
                        orderBy(['sorting' => SORT_ASC])->
                        all();
        foreach ($result as $mainCategory) {
            if($mainCategory->ifHaveChild()){
                $categories = array_merge($categories,$mainCategory->getCategoryForParentId($mainCategory->id));
            }else{
                $categories[$k++] = $mainCategory->id;
            }
        }
        return $categories;
    }


    /**
     * sub categoriyani idlari lisiti
     * @param $parent_ids
     * @return array
     */
    public static function getAllSubCategories($parent_ids){
        $result = [];

        foreach ($parent_ids as $key => $value) {
            $result = array_merge($result,self::getCategoryForParentId($value));
        }


        return $result;
    }


    /**
     * elonlarni countioni olish
     * @param $category_id
     * @return bool|int|string|null
     */
    public static function getItemsCount($category_id)
    {
        $arr = self::getCategoryForParentId($category_id);
        return Items::find()->where(['cat_id' => $arr])->where(['is_publicated' => 1, 'status' => 3])->count();
    }


    /**
     * tarjimani saqlash
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
                if(!isset($post["Categories"][$value][$l])) continue;
                $t = Translates::find()->where(['table_name' => $this->tableName(),'field_id' => $this->id,'language_code' => $l,'field_name'=>$key]);
                if($t->count() == 1){
                    $tt = $t->one();
                    $tt->field_value=$post["Categories"][$value][$l];
                    $tt->save();
                }else{
                    $t = new Translates();
                    $t->table_name = $this->tableName();
                    $t->field_id = $this->id;
                    $t->field_name = $key;
                    $t->field_value = $post["Categories"][$value][$l];
                    $t->language_code = $l;
                    $t->save(false);
                }
            }
        }
    }


    /**
     * tarjimani olish
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


    /**
     * price listini chiqarish
     * @return string[]
     */
    public static function getPrice()
    {
       return [
            1 => 'Есть',
            0 => 'Нет'
        ];
    }


    /**
     * currency list
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


    /***
     * currency list
     * @return array
     * @throws \Throwable
     */
    public static function getCurrency()
    {
        $data = \backend\models\references\Currencies::getDb()->cache(function ($db) {
             return \backend\models\references\Currencies::find()->where(['enabled' => 1])->all();
        });
        return ArrayHelper::map($data,'id','name');
    }


    /**
     * @return string[]
     */
    public function getListType()
    {
        return [
            0 => 'Не указан',
            1 => 'Список',
            2 => 'Галерея',
            3 => 'Карта'
        ];
    }


    /**
     * categoriya parentlarini olish
     * @param $category_id
     * @return array
     */
    public static function getParents($category_id)
    {
        $cat = self::findOne($category_id);
        $result = [];

        if($cat){
            while($cat->parent_id){
                array_unshift($result, $cat->id);
                $cat = self::findOne($cat->parent_id);
            }
        }
        return $result;
    }


    /**
     * caregoriya paernlarini olish  ,  kanalgaa elon qoyishda ishlatilgan.
     * @param $category_id
     * @return array
     */
    public static function getParentsTelegram($category_id)
    {
        $cat = self::findOne($category_id);
        $result = [];
        while($cat->parent_id){
            array_unshift($result, $cat->telegram_chanel);
            $cat = self::findOne($cat->parent_id);
        }
        return array_filter($result);
    }


    /**
     * categoriyani additional fieldisi
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAdditionalFields()
    {
        $categories = \backend\models\items\Categories::getParents($this->id);
        $query = CategoriesDynprops::find();
        $query->with('category');
        // $query->joinWith('categoriesDynpropsMulti');
        $query->joinWith('category');
        $query->andFilterWhere(['categories_dynprops.category_id' => $categories]);
        $query->orderBy(['categories.numlevel' => SORT_ASC, 'categories_dynprops.num' => SORT_ASC]);
        $fields = $query->all();
        return $fields;
    }


    public function getAdditionalFieldsForTelegra()
    {
        $categories = \backend\models\items\Categories::getParents($this->id);
        $query = CategoriesDynprops::find();
        $query->with('category');
        // $query->joinWith('categoriesDynpropsMulti');
        $query->joinWith('category');
        $query->andFilterWhere(['categories_dynprops.category_id' => $categories]);
        $query->andFilterWhere(['categories_dynprops.published_telegram' => 1]);
        $query->orderBy(['categories.numlevel' => SORT_ASC, 'categories_dynprops.num' => SORT_ASC]);
        $fields = $query->all();
        return $fields;
    }


    /**
     * slugdan ortiqcha belgilarni olib tashlash
     * @param $text
     * @return string
     */
    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

}
