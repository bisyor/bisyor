<?php
/* 
    Веб разработчик: Abdulloh Olimov 
*/

namespace backend\models\references;
use backend\models\chats\ChatUsers;
use backend\models\items\Items;
use Tzsk\Collage\MakeCollage;
use yii\base\Model;

class Api extends Model
{

    /**
     * publicatsiyadagi elonlar
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getItems()
    {
        $start_date = date("Y-m-d", strtotime(date('Y-m-d').' - 1 days'));
        $end_date = date("Y-m-d H:i:s");
        $items = Items::find()->with(['currency' ,'district'])
            ->andWhere(['is_publicated' => 1, 'is_moderating' => 0 ,'status' => 3])
            ->andWhere(['!=' ,'is_publicated_telegram', true])
            ->andWhere(['between' ,'date_cr',$start_date ,$end_date])
            ->orderBy('date_cr desc')
            ->all();
        return $items;
    }

    public static function getShopsItems()
    {
        $items = Items::find()
            ->with(['currency' ,'district'])
            ->joinWith(['shopApi'])
            ->andWhere(['items.is_publicated' => 1, 'items.is_moderating' => 0 ,'items.status' => 3])
            ->andWhere(['!=' ,'items.is_publicated_shops_telegram', true])
            ->orderBy(['items.date_cr' => SORT_DESC])
            ->all();
        return $items;
    }


    public static  function getChatUsersItemsList()
    {

        $query =  ChatUsers::find()
            ->leftJoin('chat_message', 'chat_message.chat_id = chat_users.chat_id')
            ->leftJoin('items','items.id=chat_users.item_id')
            ->select(['chat_message.user_id as message_user','items.id','items.title','items.user_id','(select users.telegram_api_key from users where users.id=items.user_id) as telegram_id'])
            ->andWhere(['not' ,['chat_users.item_id' => null]])
            ->andWhere(['not' ,['chat_message.message' => null]])
            ->andWhere(['not' ,['chat_message.is_read' => true]])
            ->orderBy(['chat_users.date_cr' => SORT_DESC])
            ->asArray()
            ->all();
        return $query;
    }


    /**
     * telegram kanalga message junatish curl zapros
     * @param $photo
     * @param $text
     * @param $url
     * @return mixed
     */
    public static function sendChanelMessage($photo , $text , $url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            "photo" => $photo,
            "caption" => "".$text."",
            "parse_mode" => "html",
            "disable_notification" => "True",
            "disable_web_page_preview" => "True"
        ));
        $output = curl_exec($ch);

        return json_decode($output);
    }


    public static function sendUserMessage($text , $url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            "text" => "".$text."",
            "parse_mode" => "html",
            "disable_notification" => "True",
            "disable_web_page_preview" => "True",
        ));
        $output = curl_exec($ch);

        return json_decode($output);
    }

    public static  function  getCollageImages($images ,$name)
    {
        $collage = new MakeCollage(); // Default: 'gd'
        if(count($images) == 2){
            $image = $collage->make(1024, 750)
                ->padding(10)
                ->background('#ffffff')->from($images, function($alignment) {
                 $alignment->horizontal();
            })->save('uploads/trash/'.$name);;
            return 'https://' . $_SERVER['SERVER_NAME'].'/backend/web/uploads/trash/'.$name;
        }
        elseif(count($images) == 3){
            $image = $collage->make(1024, 750)
                ->padding(10)
                ->background('#ffffff')->from($images, function($alignment) {
                    $alignment->oneTopTwoBottom();
                })->save('uploads/trash/'.$name);
            return 'https://' . $_SERVER['SERVER_NAME'].'/backend/web/uploads/tarsh/'.$name;
        }
        elseif(count($images) == 4){
            $image = $collage->make(1024, 750)
                ->padding(10)
                ->background('#ffffff')->from($images, function($alignment) {
                    $alignment->grid();
                })->save('uploads/trash/sender.jpg');;
            return 'https://' . $_SERVER['SERVER_NAME'].'/backend/web/uploads/trash/'.$name;
        }
    }
}