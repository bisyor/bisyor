<?php

namespace backend\models\shops;

use Yii;
use backend\models\references\Translates;
use yii\helpers\Html;

/**
 * This is the model class for table "shop_categories".
 *
 * @property int $id
 * @property int|null $sorting Сортировка
 * @property string|null $title Заголовок
 * @property string|null $keyword Ключ
 * @property string|null $icon_b Иконка (большая)
 * @property string|null $icon_s Иконка (малая)
 * @property int|null $enabled Статус 1 => Активно , 0 => Не активно
 * @property int|null $parent_id Подкатегория
 * @property string|null $date_cr Дата создание
 *
 * @property ShopCategories $parent
 * @property ShopCategories[] $shopCategories
 * @property ShopsSections[] $shopsSections
 */
class ShopCategories extends \yii\db\ActiveRecord
{
    public $translation_title;
    public $small_img;
    public $img;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const DIR_NAME = 'shop-categories';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'],'required'],
            [['sorting', 'enabled', 'parent_id'], 'integer'],
            [['date_cr'], 'safe'],
            [['title', 'keyword', 'icon_b', 'icon_s'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopCategories::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['translation_title'],'safe'],
            [['small_img','img'],'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'skeeks\yii2\slug\SlugBehavior',
                'slugAttribute' => 'keyword',
                'attribute' => 'title',
                'maxLength' => 64,
                'minLength' => 3,
                'ensureUnique' => true,
                'slugifyOptions' => [
                    'lowercase' => true,
                    'separator' => '-',
                    'trim' => true,
                    //'regexp' => '/([^A-Za-z0-9]|-)+/',
                    'rulesets' => ['russian'],
                ]
            ]
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
            'translation_title' => 'Заголовок',
            'title' => 'Заголовок',
            'keyword' => 'Ключ',
            'img' => 'Иконка (большая)',
            'icon_b' => 'Иконка (большая)',
            'small_img' => 'Иконка (малая)',
            'icon_s' => 'Иконка (малая)',
            'enabled' => 'Статус',
            'parent_id' => 'Подкатегория',
            'date_cr' => 'Дата создание',
        ];
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ShopCategories::className(), ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[ShopCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShopCategories()
    {
        return $this->hasMany(ShopCategories::className(), ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[ShopsSections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShopsSections()
    {
        return $this->hasMany(ShopsSections::className(), ['section_id' => 'id']);
    }

    public static function NeedTranslation()
    {
        return [
            'title'=>'translation_title',
        ];
    }

    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->date_cr = Yii::$app->formatter->asDate(time(), 'php:Y-m-d H:i');
        }
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        Translates::deleteAll(['table_name'=>$this->tableName(),'field_id'=>$this->id]);

        $this->deleteImage();

        return true;
    }

    public static function getAdminSiteName()
    {
        $adminka = Yii::$app->params['image_site'];
        return $adminka;
    }


    /**
     * files ftp
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
     * uchirish
     * @param $dirname
     * @param $img
     * @param $conn_id
     */
    public static function deleteIcon($dirname,$img,$conn_id)
    {
        $dir = $dirname;
        $path = '/web/uploads/'.$dir.'/';
        $res = ftp_size($conn_id, $path . $img);
        if ($res != -1 && $img) {
            ftp_delete($conn_id, $path . $img);
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
     * columnlar lisitini olish
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getColumnsList($id)
    {
        $active = [];
        if( $id == null ){
            $categories = self::find()->where(['parent_id' => NULL])->select(['id','title'])->asArray()->indexBy('id')->orderBy(['sorting' => SORT_ASC])->all();
        }else{
            $categories = self::find()->where(['parent_id' => $id])->select(['id','title'])->asArray()->indexBy('id')->orderBy(['sorting' => SORT_ASC])->all();

        }
        return $categories;
    }


    /**
     * @param null $status
     * @return string
     */
    public static function getStatusName($status = null)
    {
        return ($status == self::STATUS_ACTIVE) ? '<span class="text-success text-muted">Активно</span>' : '<span class="text-danger text-muted">Не активно</span>';
    }


    /**
     * @param $status
     * @param $id
     * @return string
     */
    public static function getStatusTemplate($status,$id)
    {
        $admin = Yii::$app->request->baseUrl;
        return ($status == self::STATUS_ACTIVE) ?
            '<span onclick="  $(this).css({cursor:\'progress\'}); $.post(\'' . $admin . '/shops/shop-categories/change-status?id='.$id.'\',function(success){$(this).css({cursor:\'default\'}); $.pjax.reload(\'#crud-datatable-pjax\', {timeout : false});})" class="switchery" style="background-color: rgb(0, 172, 172); border-color: rgb(0, 172, 172); box-shadow: rgb(0, 172, 172) 0px 0px 0px 16px inset; transition: border 0.5s ease 0s, box-shadow 0.5s ease 0s, background-color 1.5s ease 0s;"><small style="left: 20px; transition: left 0.25s ease 0s;"></small></span><br> '.self::getStatusName($status)
        :
            '<span onclick=" $(this).css({cursor:\'progress\'}); $.post(\'' . $admin . '/shops/shop-categories/change-status?id='.$id.'\',function(success){$(this).css({cursor:\'default\'}); $.pjax.reload(\'#crud-datatable-pjax\', {timeout : false});})" class="switchery" onclick="" style="background-color: rgb(255, 255, 255); border-color: rgb(223, 223, 223); box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; transition: border 0.5s ease 0s, box-shadow 0.5s ease 0s;"><small style="left: 0px; transition: left 0.25s ease 0s;"></small></span><br> '.self::getStatusName($status);
    }


    /**
     * @param null $date
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDate($date = null)
    {
        return ($date == null) ? "" : Yii::$app->formatter->asDate($date,'php: H:i d.m.Y');
    }


    /**
     * @param $category_id
     * @return bool|int|string|null
     */
    public static function getShopsCount($category_id)
    {
        $count = ShopsSections::find()->where(['section_id' => $category_id])->count();
        return $count;
    }


    /**
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
                    $tt->field_value=$post["ShopCategories"][$value][$l];
                    $tt->save();
                }
                else{
                    $t = new Translates();
                    $t->table_name = $this->tableName();
                    $t->field_id = $this->id;
                    $t->field_name = $key;
                    $t->field_value = $post["ShopCategories"][$value][$l];
                    $t->language_code = $l;
                    $t->save(false);
                }
            }
        }
    }


    /**
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


    /**
     * Gets query for [[ShopsCategorySeo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShopsCategorySeo()
    {
        return $this->hasOne(ShopsCategorySeo::className(), ['category_id' => 'id']);
    }

}
