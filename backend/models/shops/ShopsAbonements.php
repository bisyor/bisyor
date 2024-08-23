<?php

namespace backend\models\shops;

use Yii;
use backend\models\references\Translates;
use backend\models\references\Lang;
use yii\helpers\Html;

/**
 * This is the model class for table "shops_abonements".
 *
 * @property int $id
 * @property int|null $enabled 1 - Активно, 0 - Неактив
 * @property string|null $title Заголовок
 * @property int|null $is_free 0 - Платно, 1 - Бесплат
 * @property int|null $price_free_period
 * @property int|null $ads_count Количество объявлении
 * @property int|null $import мпорт объявлении
 * @property int|null $mark Выделение
 * @property int|null $fix Закрепление
 * @property string|null $icon_b Иконка (большая)
 * @property string|null $icon_s Иконка (малая)
 * @property int|null $num Номер сортировки
 * @property int|null $one_time Единоразовый
 * @property int|null $is_default По умолчанию
 *
 * @property ShopsAbonementPeriod[] $shopsAbonementPeriods
 * @property ShopsTariff[] $shopsTariffs
 */
class ShopsAbonements extends \yii\db\ActiveRecord
{
    public $translation_title;
    public $small_img;
    public $img;
    public $num_month;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const DIR_NAME = 'shop-abonoments';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shops_abonements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'ads_count'],'required'],
            [['enabled', 'is_free', 'price_free_period','num_month', 'ads_count', 'import', 'mark', 'fix', 'num', 'one_time', 'is_default'], 'integer'],
            [['title', 'icon_b', 'icon_s'], 'string', 'max' => 255],
            [['small_img','img'],'safe'],
            [['translation_title'],'safe'],
            [['num_month'],'required','when'=>function($model){ return $model->is_free == 1 && $model->price_free_period == 0;}],
            [['enabled', 'is_free','import', 'mark', 'fix', 'num', 'one_time', 'is_default'],'default','value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            //str
            'title' => 'Заголовок',
            'translation_title' => 'Заголовок',
            'img' => 'Иконка (большая)',
            'icon_b' => 'Иконка (большая)',
            'small_img' => 'Иконка (малая)',
            'icon_s' => 'Иконка (малая)',
            //integer 0 1
            'enabled' => 'Статус',
            'one_time' => 'Единоразовый',
            'is_default' => 'По умолчанию',
            'is_free' => 'Бесплатно',
            'import' => 'Импорт объявлении',
            'mark' => 'Услуга Выделение',
            'fix' => 'Услуга Закрепление',
            'num_month' => 'Кол-во Месяцов',
            //integer
            'num' => 'Номер сортировки',
            'price_free_period' => 'Бессрочно',
            'ads_count' => 'Количество объявлении',
        ];
    }

    public static function NeedTranslation()
    {
        return [
            'title'=>'translation_title',
        ];
    }
    /**
     * Gets query for [[ShopsAbonementPeriods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShopsAbonementPeriods()
    {
        return $this->hasMany(ShopsAbonementPeriod::className(), ['abonement_id' => 'id']);
    }

    /**
     * Gets query for [[ShopsTariffs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShopsTariffs()
    {
        return $this->hasMany(ShopsTariff::className(), ['abonement_id' => 'id']);
    }


    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if($this->price_free_period == 1){
            $this->price_free_period = 0;
        }else{
            $this->price_free_period = $this->num_month;
        }

        if($this->is_free == 0){
            $this->price_free_period = NULL;
        }elseif($this->is_free == 1){
            ShopsAbonementPeriod::deleteAll(['abonement_id' => $this->id]);
        }

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
     * after find
     */
    public function afterFind()
    {
        if($this->price_free_period == 0){
            $this->price_free_period = 1;
            $this->num_month = 0;
        }else{
            $this->num_month = $this->price_free_period;
        }

        if($this->is_free == ''){
            $this->is_free = 0;
        }

        return parent::afterFind();
    }


    /**
     * @return mixed
     */
    public static function getAdminSiteName()
    {
        $adminka = Yii::$app->params['adminka'];
        return $adminka;
    }


    /**
     *  files ftp connect
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
     * olish
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
     * uchirish
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
     * status
     * @param null $status
     * @return string
     */
    public static function getStatusName($status = null)
    {
        return ($status == self::STATUS_ACTIVE) ? '<span class="label label-success"> Активно </span>' : '<span class="label label-danger">Не активно</span>';
    }


    /**
     * @return string[]
     */
    public static function getStatusType()
    {
       return [
            self::STATUS_INACTIVE => 'Не активно',
            self::STATUS_ACTIVE => 'Активно'
        ];
    }


    /**
     * @return string[]
     */
    public static function getAnswerType()
    {
       return [
            0 => 'Нет',
            1 => 'Да'
        ];
    }


    /**
     * @return string[]
     */
    public static function getPeriodType()
    {
       return [
            0 => 'Бессрочно',
            1 => 'Не бессрочно'
        ];
    }


    /**
     * @return string
     */
    public function getFreePeriod()
    {
        return ($this->is_free == 0 ) ? "<span class='label label-success'>Платно</span>" :
         ( ($this->price_free_period == 1 ) ? "<span class='label label-success'>Бессрочно</span>" : "<span class='label label-warning'>". $this->num_month ." месяцев</span> " );
    }


    /**
     * @param int $yes
     * @return string
     */
    public function getYesNo($yes = 1)
    {
        return ($yes == 1) ? "<span class='label label-success'>Да</span>" : "<span class='label label-danger'>Нет</span>";
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
                    $tt->field_value=$post["ShopsAbonements"][$value][$l];
                    $tt->save();
                }else{
                    $t = new Translates();
                    $t->table_name = $this->tableName();
                    $t->field_id = $this->id;
                    $t->field_name = $key;
                    $t->field_value = $post["ShopsAbonements"][$value][$l];
                    $t->language_code = $l;
                    $t->save(false);
                }
            }
        }
    }


    /**
     * @return array
     */
    public function getDiscountModels()
    {
        $array_models = [];

        if($this->isNewRecord){
            $services = Services::find()->all();
            foreach ($services as $key => $value) {
                $new_service_discount = new TariffServiceDiscount();
                $new_service_discount->service_id = $value->id;
                $new_service_discount->percent = 0;
                $array_models [] = $new_service_discount;
            }
        }else{
            $models = TariffServiceDiscount::find()->where(['abonoment_id' => $this->id])->all();
            foreach ($models as $key => $value) {
                $array_models [] = $value;
            }
        }
        

        return $array_models;
    }


    /**
     * @param $modelsDisconts
     */
    public function saveDiscountModels($modelsDisconts)
    {
        foreach ($modelsDisconts as $key => $value) {
            $value->abonoment_id = $this->id;
            $value->save(false);
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
            $translation_title[$value->language_code] = $value->field_value;
        }
        if(!isset($translation_title))
            $translation_title = null; 
        $this->translation_title = $translation_title;
    }
}
