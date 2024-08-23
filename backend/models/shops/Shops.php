<?php

namespace backend\models\shops;

use Yii;
use backend\models\references\Districts;
use backend\models\users\Users;
use backend\models\references\Translates;
use backend\models\items\Categories;
use backend\models\items\Items;
use backend\models\references\SocialNetworks;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "shops".
 *
 * @property int $id
 * @property int|null $user_id Пользователь
 * @property string|null $name Название магазина
 * @property string|null $logo Логотип
 * @property string|null $keyword Слуг url
 * @property int|null $status 1 - Активно, 2 - Не активно, 3 - Блокиро
 * @property string|null $description Описание
 * @property int|null $district_id Регион, Район
 * @property string|null $address Адрес
 * @property string|null $coordinate_x oordinate X
 * @property string|null $coordinate_y Coordinate Y
 * @property string|null $phone Телефон номер
 * @property string|null $phones Телефон номеры
 * @property string|null $site Ссылка сайта
 * @property string|null $blocked_reason Причина блокировки
 * @property string|null $admin_comment Комментария админа
 * @property string|null $social_networks Социальные сети
 * @property string|null $date_cr Дата создание
 * @property string|null $date_up Дата изменение
 *
 * @property ShopSlider[] $shopSliders
 * @property Districts $district
 * @property Users $user
 * @property ShopsClaims[] $shopsClaims
 * @property ShopsSections[] $shopsSections
 * @property ShopsTariff[] $shopsTariffs
 */
class Shops extends \yii\db\ActiveRecord
{
    public $img;
    public $sections;
    public $count_items;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_CHECKING = 2;
    const STATUS_BLOCKED = 3;
    const DIR_NAME = 'shops';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shops';
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'skeeks\yii2\slug\SlugBehavior',
                'slugAttribute' => 'keyword',                      //The attribute to be generated
                'attribute' => 'name',                          //The attribute from which will be generated
                // optional params
                'maxLength' => 64,                              //Maximum length of attribute slug
                'minLength' => 3,                               //Min length of attribute slug
                'ensureUnique' => true,
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
            [['name','user_id','district_id','description'],'required'],
            [['user_id', 'status', 'district_id'], 'default', 'value' => null],
            [['user_id', 'status','view_count'], 'integer'],
            [['svc_fixed','is_verify'],'boolean'],
            [['description', 'address', 'blocked_reason', 'admin_comment', 'social_networks'], 'string'],
            [['date_cr', 'date_up','img','sections','phones','district_id', 'svc_fixed_to', 'svc_fixed_order', 'svc_marked_to'], 'safe'],
            [['name', 'logo', 'keyword', 'coordinate_x', 'coordinate_y', 'phone', 'site','telegram_channel'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            // [['phones'],'ValidatePhones'],
            [['blocked_reason'],'required', 'when' => function($model){return $model->status == self::STATUS_BLOCKED;}]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Владелец',
            'name' => 'Название магазина',
            'logo' => 'Логотип',
            'img' => 'Логотип',
            'keyword' => 'Url',
            'sections' => 'Категория',
            'status' => 'Статус',
            'description' => 'Чем занимается',
            'district_id' => 'Район',
            'address' => 'Адрес',
            'coordinate_x' => 'Coordinate X',
            'coordinate_y' => 'Coordinate Y',
            'phone' => 'Телефон номер',
            'phones' => 'Телефон номеры',
            'site' => 'Ссылка сайта',
            'blocked_reason' => 'Причина блокировки',
            'admin_comment' => 'Комментария админа',
            'social_networks' => 'Социальные сети',
            'date_cr' => 'Дата создание',
            'date_up' => 'Дата изменение',
            'view_count' => 'Кол-во просмотров',
            'svc_fixed' => 'Статус сервиса Закрепление',
            'svc_fixed_to' => 'Дата окончение сервиса Закрепление',
            'svc_fixed_order' => 'Дата активации сервиса Закрепление',
            'svc_marked_to' => 'Дата окончение сервиса Выделение',
            'telegram_channel' => 'Адрес телеграмм канала',
            'is_verify' => 'Надежный',
        ];
    }


     /**
     * Gets query for [[PromocodesUsages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromocodesUsages()
    {
        return $this->hasMany(PromocodesUsage::className(), ['shop_id' => 'id']);
    }


    /**
     * telefon nomerni validatsiya qilish
     * @param $attribute
     * @return bool
     */
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
                $arr [] = $itme;
            }
        }

        $this->attribute = $arr;
        return true;
    }


    /**
     * Gets query for [[ShopSliders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShopSliders()
    {
        return $this->hasMany(ShopSlider::className(), ['shop_id' => 'id']);
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }


    /**
     * Gets query for [[ShopsClaims]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShopsClaims()
    {
        return $this->hasMany(ShopsClaims::className(), ['shop_id' => 'id']);
    }


    /**
     * Gets query for [[ShopsSections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShopsSections()
    {
        return $this->hasMany(ShopsSections::className(), ['shop_id' => 'id'])->with('section');
    }


    /**
     * Gets query for [[ShopsTariffs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShopsTariffs()
    {
        return $this->hasMany(ShopsTariff::className(), ['shop_id' => 'id']);
    }


    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->status = self::STATUS_CHECKING;
            $this->date_cr = Yii::$app->formatter->asDate(time(),'php:Y-m-d H:i');
            $this->status_changed = Yii::$app->formatter->asDate(time(),'php:Y-m-d H:i');
        }
        else{
            if($this->status_changed){
                $this->status_changed = date('Y-m-d H:i:s', strtotime($this->status_changed));
            }
            if($this->date_cr){
                $this->date_cr = date('Y-m-d H:i:s', strtotime($this->date_cr));
            }
        }

        if($this->status != self::STATUS_BLOCKED){
            $this->blocked_reason = '';
        }

        $this->date_up = date('Y-m-d H:i:s');

        $this->phones = json_encode($this->phones);
        
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
        $this->deleteImage();
        return true;
    }


    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function afterFind()
    {
        $sections = ShopsSections::find()
            ->with(['section'])
            ->where(['shop_id' => $this->id])
            ->all();

        $this->sections = ArrayHelper::getColumn($sections,'section_id');

        if($this->phones)
            $this->phones = json_decode($this->phones);

        $this->date_cr = date('H:i d.m.Y', strtotime($this->date_cr));
        $this->date_up = date('H:i d.m.Y', strtotime($this->date_up));
        $this->status_changed = date('H:i d.m.Y', strtotime($this->status_changed)); 

        $this->count_items = Items::find()->where(['shop_id' => $this->id])->count();

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
        $img = $this->logo;
        $dir = self::DIR_NAME;
        
        if($this->img){
            $img = $this->img ;
            $dir = 'trash';
        }

        $admin = self::getImageSiteName();

        if ($img == '') {
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
     * saqlash
     * @throws \yii\base\Exception
     */
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
                $fileName = $this->id . '-' . Yii::$app->security->generateRandomString() . '.' . $ext;
                ftp_rename($conn_id, $source_path.$value, $destination_path.$fileName);
                $this->logo = $fileName;            
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

        $res = ftp_size($conn_id, $path . $this->logo);
        if ($res != -1 && $this->logo) {
            ftp_delete($conn_id, $path . $this->logo);
        }
    }


    /**
     * status
     * @param null $status
     * @return string
     */
    public static function getStatusName($status = null)
    {
        switch ($status) {
            case self::STATUS_ACTIVE:
                return '<span class="label label-success"> Активно </span>';
                break;
            case self::STATUS_INACTIVE:
                return '<span class="label label-danger"> Не активно </span>';
                break;
            case self::STATUS_CHECKING:
                return '<span class="label label-warning"> На модерации </span>';
                break;
            default:
                return '<span class="label label-inverse"> Заблокировано </span>';
                break;
        }
    }


    /**
     * @param false $form
     * @return string[]
     */
    public static function getStatusType($form = false)
    {
        if($form){
            return 
            [
                self::STATUS_ACTIVE => 'Активно',
                self::STATUS_INACTIVE => 'Не активно',
                self::STATUS_CHECKING => 'На модерации',
                self::STATUS_BLOCKED => 'Заблокировано',
            ];
        }
        return 
            [
                self::STATUS_ACTIVE => 'Активно',
                self::STATUS_INACTIVE => 'Не активно',
                // self::STATUS_CHECKING => 'На модерации',
                self::STATUS_BLOCKED => 'Заблокировано',
            ];
    }


    /**
     * @return array
     */
    public function getSocialNetworksList()
    {
        $data = SocialNetworks::find()->where(['status' => 1])->all();
        return ArrayHelper::map($data, 'id', 'name');
    }


    /**
     * @return array
     * @throws \yii\db\Exception
     */
    public function getDistrictsList()
    {
        $sql = "SELECT r.name as region, d.id as id, d.name as district FROM regions AS r, districts AS d WHERE d.region_id=r.id;";
        $data = Yii::$app->db->createCommand($sql)->queryAll();

        return ArrayHelper::map($data,'id','district','region');
    }


    /**
     * @return array
     */
    public function getCategoriesList()
    {
        $data = ShopCategories::find()->indexBy('id')->asArray()->all();
        return ArrayHelper::map($data,'id','title');

        foreach ($data as $id => &$node) {
            if($node['parent_id'] == 0)
                $tree[$id] = &$node;
            else
                $data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }


    /**
     * userlarni listi
     */
    public function getUsersList()
    {
        $data = Users::find()
            ->select(['id','email','phone','fio'])
            ->limit(5)
            /*->where(['role_id' => 5])*/
            ->all();
        $arr = [];
        foreach ($data as $key => $value) {
            $arr[$value->id] = $value->getUserFio();
        }
        return $arr;
    }


    /**
     * telefonn nomerni saqlash
     */
    public function SavePhones()
    {
        $items = $this->phones;
        if (!is_array($items)) {
            $items = [];
        }
        $arr = [];
        foreach ($items as $index => $item) {
            $item = str_replace("(","",$item);
            $item = str_replace(")","",$item);
            $x = preg_replace('/\d/', '#', $item);
            if ($x != '+#####-###-##-##') {
            }else{
                $arr [] = $item;
            }
        }
        $this->phones = $arr;

        if($this->phones){
            $this->phone = $this->phones[0];
            $arr = $this->phones;
            if(count($arr) >= 1){
                $output = array_slice($arr, 1);
                $this->phones = $output;
            }
        }
    }


    /**
     * telefon nomerni olish
     * @return array
     */
    public function getPhones()
    {

        $arr = trim($this->phones,"[");
        $arr = trim($arr,"]");
        $arr = explode(",",$arr);
        array_unshift($arr , '"'.$this->phone.'"');
        $this->phones = $arr;

    }


    /**
     * telefon nomerlarni olish
     * @return array|mixed
     */
    public function getPhoneNumbers()
    {
        $arr = trim($this->phones,"[");
        $arr = trim($arr,"]");
        $arr = explode(",",$arr);
        array_unshift($arr , '"'.$this->phone.'"');
        return $arr;

    }


    /**
     * save sections
     */
    public function saveSections()
    {
//        ShopsSections::deleteAll(['shop_id' => $this->id]);
        if($this->sections) {
            foreach ($this->sections as $key => $value) {
                $new_model = new ShopsSections();
                $new_model->section_id = $value;
                $new_model->shop_id = $this->id;
                $new_model->save(false);
            }
        }

//        echo '<pre>';
//        print_r($this->sections);
//        die;
    }


    /**
     * save networks
     * @param $networkModels
     */
    public function saveNetworks($networkModels)
    {
        if(!$networkModels){
            $this->social_networks = '';
            return;
        }
        $arr = [];
        foreach ($networkModels as $value) {
            $arr [ $value['name']] = $value['address'];
        }
        $this->social_networks = json_encode($arr);
    }


    /**
     * networklarni olish
     * @return array
     */
    public function getNetworks()
    {
        if( !$this->social_networks ) return [];
        $arr = json_decode($this->social_networks);
        $arr_models = [];
        foreach ($arr as $key => $value) {
            $temp_model = new ShopSocialNetworks();
            $temp_model->name = $key;
            $temp_model->address = $value;
            $temp_model->id = $key;

            $arr_models [] = $temp_model;
        }
        return $arr_models;
    }


    /**
     * @return string
     */
    public function getCountAds()
    {
        return \yii\helpers\Html::a($this->count_items,['/shops/shops/view','id' => $this->id, 'items' => 1],['data-pjax' => 0]);
    }


    /**
     * @return string
     */
    public function getSections()
    {
        $str = "";
        foreach ($this->shopsSections as $key => $value) {
            if(isset($value->section)) {
                $category_name = $value->section->title;
            }else{
                continue;
            }
            $str .= "<label class='label label-inverse'>$category_name</label> ";
        }
        return $str;
    }


    /**
     * @return string
     */
    public function getSotSetiTemplate()
    {
        $sotset = $this->getNetworks();
        $template =  "<table class='table table-condensed'><tbody>";
        foreach ($sotset as $key => $value) {
            $obj = \backend\models\references\SocialNetworks::findOne($value->name);
            if($obj)
                $template .= "<tr><td><img src='/uploads/social_icons/{$obj->icon}' width='5%'>&nbsp;&nbsp;{$obj->name}</td>
                    <td><a href='{$value->address}' class='btn btn-link' target='_blank'>{$value->address}</a></td></tr>";        
        }
        $template .="</tbody></table>";
        return $template;
    }


    /**
     * @return string
     */
    public function getStatusTemplate()
    {
        $admin = Yii::$app->request->baseUrl;
        $id = $this->id;
        $status = $this->status;
        return ($status == self::STATUS_ACTIVE) ?
            '<span title="hey" onclick=" $(this).css({cursor:\'progress\'}); $.post(\'' . $admin . '/shops/requests/change-status?id='.$id.'\',function(success){$(this).css({cursor:\'default\'}); $.pjax.reload(\'#crud-datatable-requests-tab-1\', {timeout : false});})" class="switchery" style="background-color: rgb(0, 172, 172); border-color: rgb(0, 172, 172); box-shadow: rgb(0, 172, 172) 0px 0px 0px 16px inset; transition: border 0.5s ease 0s, box-shadow 0.5s ease 0s, background-color 1.5s ease 0s;"><small style="left: 20px; transition: left 0.25s ease 0s;"></small></span><br><br> '.self::getStatusName($status)
        :
            '<span title="Активировать" onclick=" $(this).css({cursor:\'progress\'}); $.post(\'' . $admin . '/shops/requests/change-status?id='.$id.'\',function(success){$(this).css({cursor:\'default\'}); $.pjax.reload(\'#crud-datatable-requests-tab-1\', {timeout : false});})" class="switchery" onclick="" style="background-color: rgb(255, 255, 255); border-color: rgb(223, 223, 223); box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; transition: border 0.5s ease 0s, box-shadow 0.5s ease 0s;"><small style="left: 0px; transition: left 0.25s ease 0s;"></small></span><br><br> '.self::getStatusName($status);
    }


    /**
     * @return string|null
     */
    public function getShopUser()
    {
        if($this->user){
            return $this->user->getUserFio();
        }else{
            return "";
        }
    }
}
