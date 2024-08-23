<?php

namespace backend\models\shops;

use Yii;

/**
 * This is the model class for table "shop_slider".
 *
 * @property int $id
 * @property int|null $shop_id Магазин
 * @property string|null $title Заголовок
 * @property string|null $text Текст
 * @property string|null $image Картинка
 * @property string|null $link Ссылка
 *
 * @property Shops $shop
 */
class ShopSlider extends \yii\db\ActiveRecord
{
    public $img;
    const DIR_NAME = 'shop-slider';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_slider';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','text','link'],'required'],
            [['img'],'required','message' => 'Загрузите картинок'],
            [['shop_id'], 'default', 'value' => null],
            [['shop_id'], 'integer'],
            [['text'], 'string'],
            [['title', 'image', 'link'], 'string', 'max' => 255],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shops::className(), 'targetAttribute' => ['shop_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => 'Магазин',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'image' => 'Картинка',
            'img' => 'Картинка',
            'link' => 'Ссылка',
        ];
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
     * ftpga ulanish
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
     * imageni adresini olish
     * @param false $small
     * @param string $width
     * @param string $height
     * @return string
     */
    public function getImg($small = false, $width = "",$height = "")
    {
        $img = $this->image;
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


    /**
     * rasmni saqlaash
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
                $this->image = $fileName;            
            }
        }
        $this->save(false);
    }


    /**
     * rasmni ochirish
     */
    public function deleteImage()
    {
        $dir = self::DIR_NAME;
        $path = '/web/uploads/'.$dir.'/';

        $conn_id = self::connectFtp();

        $res = ftp_size($conn_id, $path . $this->image);
        if ($res != -1 && $this->image) {
            ftp_delete($conn_id, $path . $this->image);
        }
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
}
