<?php

namespace backend\models\items;

use Yii;
use yii\imagine\Image;

/**
 * This is the model class for table "items_images".
 *
 * @property int $id
 * @property int|null $item_id
 * @property int|null $user_id
 * @property string|null $filename
 * @property string|null $created
 * @property int|null $width
 * @property int|null $height
 * @property string|null $extstor_img_s
 * @property string|null $extstor_img_m
 * @property string|null $extstor_img_v
 * @property string|null $extstor_img_z
 * @property string|null $extstor_img_o
 * @property string|null $img_prefix
 */
class ItemsImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'user_id', 'width', 'height', 'num'], 'integer'],
            [['created'], 'safe'],
            [['filename', 'extstor_img_s', 'extstor_img_m', 'extstor_img_v', 'extstor_img_z', 'extstor_img_o', 'img_prefix'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'created' => 'Created',
            'width' => 'Width',
            'height' => 'Height',
            'num' => 'Num',
            'extstor_img_s' => 'Extstor Img S',
            'extstor_img_m' => 'Extstor Img M',
            'extstor_img_v' => 'Extstor Img V',
            'extstor_img_z' => 'Extstor Img Z',
            'extstor_img_o' => 'Extstor Img O',
            'img_prefix' => 'Img Prefix',
        ];
    }


    /**
     * barcha rasmlarni ochirish
     */
    public function deleteAllImage()
    {
        $array = [];
        $array [] = $this->extstor_img_s;
        $array [] = $this->extstor_img_m;
        $array [] = $this->extstor_img_v;
        $array [] = $this->extstor_img_z;
        $array [] = $this->extstor_img_o;
        return $array;
    }

    public static  function deleteImagesWithApi($images)
    {
        $data = [
            'fileName' => implode(',',$images),
            'dirName' => 'items',
        ];
        // curl connection
        $ch = curl_init();
        // set curl url connection
        $curl_url = Yii::$app->params['image_site'].'/api/delete-image';
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
     * rasmni uchirish
     * @param $image
     * @param $conn_id
     */
    public function deleteImage($image ,$conn_id)
    {
        $path = '/web/uploads/items/';


        $res = ftp_size($conn_id, $path . $image);
        if ($res != -1 && $image) {
            ftp_delete($conn_id, $path . $image);
        }
    }

}
