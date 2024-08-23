<?php
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 22.04.2020
 * Time: 19:09
 */

namespace console\models;

use backend\models\references\Districts;
use Yii;

/**
 * Class Base
 * @package console\models
 */
class Base
{
    const EXPIRE_TIME = 3600 * 24 * 7;

    /**
     * FTP bilan bog'lash funksiyasi
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
     * Aytilgan bazani ma'lumotlarini olish uchun
     * @param $base_name
     * @return mixed
     */
    public static function takeBase($base_name)
    {
        $query = "SELECT * FROM ".$base_name;
        return Yii::$app->dbmy->createCommand($query)->queryAll();
    }

    public static function takeImgBase($base_name, $field_name)
    {
        $query = "SELECT * FROM " . $base_name . ' WHERE ' . $field_name . ' = 0 ORDER BY id DESC';
        return Yii::$app->dbmy->createCommand($query)->queryAll();
    }

    public static function updateImgBase($id)
    {
        $query = "UPDATE bff_bbs_items_images SET s_type = 1 WHERE id=" . $id;
        Yii::$app->dbmy->createCommand($query)->execute();
    }

    /**
     * @param $string
     * @return array|string|string[]|null
     */
    public static function phones($string)
    {
        $phones = unserialize($string['phones']);
        $result = [];
        if(!empty($phones)){
            foreach ($phones  as $phone){
                if(!empty($phone['v'])) {
                    $result[] = "+998".substr(preg_replace('/(\D)/', '', $phone['v']), -9);
                }else{
                    $result[] = "+998".substr(preg_replace('/(\D)/', '', $phone), -9);
                }
            }
        }
        $result = !empty($result) ? json_encode($result) : NULL;
        return  $result;
    }

    /**
     * @param $valuehttps://mrvts.wordpress.com/
     * @return int
     */
    public static function status($value)
    {
        $status = 2;
        if($value['blocked'] == 1) $status = 3;
        if($value['deleted'] == 1) $status = 4;
        if($value['activated'] == 1) $status = 1;

        return $status;
    }

    /**
     * @param $value
     * @return int
     */
    public static function sex($value)
    {
        if($value['sex'] == 2) $sex =1; else $sex = 2;
        return $sex;
    }

    /**
     * Eski bazadan yangi bazaga  mos region idlarni topib beradi
     * @param $value
     * @return array|Districts|mixed|\yii\db\ActiveRecord|null
     */
    public static function regions($value)
    {
        $result = NULL;
        if($value['region_id'] != 0){
            $regions_name = Yii::$app->dbmy->createCommand("SELECT title_ru FROM     bff_regions WHERE id=".$value['region_id'])->queryAll();
            $like = mb_substr($regions_name[0]['title_ru'], 0, 7);
            $result = Districts::find()->where(['like', 'name', $like])->asArray()->one();
            if($result != null) $result = $result['id'];
        }
        return $result;
    }

    /**
     * @param $post
     * @param $id
     * @return string
     */
    public static function post($post, $id)
    {
        /*try {
            $post = base64_decode(base64_encode($post));
            $content = unserialize(html_entity_decode($post));
            if($content){   
                $content = $content['b'];
                foreach ($content as $value){
                    $text .= $value['text']['ru'];
                    if(array_key_exists('photo', $value)){
                        if($value['photo']) $text .= '<img src="'.Yii::$app->params['image_site'].'/web/uploads/blog_posts/'.$value['photo'].'" />';
                    }
                }
            }
        }
        catch (\Exception $e){
            return "";
        }*/

        $text = "";

        $post = base64_decode(base64_encode($post));
        $content = unserialize(($post));
        if($content){   
            $content = $content['b'];
            foreach ($content as $value){
                $text .= $value['text']['ru'];
                if(array_key_exists('photo', $value)){
                    if($value['photo']) $text .= '<img src="'.Yii::$app->params['image_site'].'/web/uploads/blog_posts/'.$value['photo'].'" />';
                }
            }
        }

        return $text;

    }
    public static function urlexists($url){
        $headers=get_headers($url);
        return stripos($headers[0],"200 OK")?true:false;
    }
}

?>