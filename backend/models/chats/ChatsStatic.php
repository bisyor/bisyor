<?php

namespace backend\models\chats;


use Yii;
use yii\base\Model;
use backend\models\chats\Chats;
use backend\models\chats\ChatUsers;
use backend\models\chats\ChatMessage;
use backend\models\blogs\BlogPosts;
use backend\models\items\Items;
use backend\models\shops\Shops;
use yii\data\Pagination;



class ChatsStatic extends Model
{       

    public static function getNameImage($type ,$value)
    {
        switch ($type) {
            case 3: return self::getImage($value['image'], 'blog_posts') ; break;
            case 4: return self::getImage($value['image'], 'items')  ; break;
            case 5: return  self::getImage($value['image'], 'shops') ; break;

        }
    }

    public static function getImage($image ,$folder)
    {   
        $admin = self::getImageSiteName();
        $imageLink = $admin."/web/uploads/".$folder."/".$image;
        // $handle = @fopen($imageLink,'r');

        //     if(!$handle) {
        //         return $admin. "/web/uploads/noimg.jpg";
        //     } else {
        //         return $imageLink;
        //     }

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $imageLink);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        // $res = curl_exec($ch);
        // $info = curl_getinfo($ch);
        if($image == '' || $image == null) {
            return $admin. "/web/uploads/noimg.jpg";
        }
        else {
            return $imageLink;
        }
        // if (@getimagesize($imageLink)) {
        //     return $imageLink;
        // }
        // else return $admin. "/web/uploads/noimg.jpg";
    }


     //image site
    public static function getImageSiteName()
    {
        $adminka = Yii::$app->params['image_site'];
        return $adminka;
    }

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



}
