<?php

namespace backend\models\chats;


use backend\models\chats\Chats;
use backend\models\chats\ChatUsers;
use Yii;
use yii\base\Model;
use backend\models\chats\ChatMessage;
use backend\models\chats\ChatsStatic;
use backend\models\blogs\BlogPosts;
use backend\models\items\Items;
use backend\models\shops\Shops;
use backend\models\users\Users;
use yii\data\Pagination;



class ChatList extends Model
{       
   

    public static function getChatControl($type ,$id = 0)
    {   
        if($type == 1|| $type == 2){
            return ChatList::getUsersListAllChat($type);
        }
        elseif($type == 6){
            return ChatList::getUsersListAllItemsChat($type ,$id);
        }else {
            return ChatList::getUsersListAllComment($type);
        }
    }

    // ***************************** all chat *******************************
    public static  function getUsersListAllChat($type)
    {
        $user_id = Yii::$app->user->identity->id;
        $result = [];

        $chatUsersId = (new \yii\db\Query())
            ->select(['*'])
            ->from('chat_users')
            ->join('inner join', 'chats', 'chats.id = chat_users.chat_id')
            ->where(['user_id' => $user_id])
            ->andWhere(['chats.type' => $type])->all();

        $query = Chats::find()->where(['id'=>array_column($chatUsersId , 'chat_id')]);

        $pagination = new Pagination([
            'defaultPageSize' => Yii::$app->params['paginationSizeChats'],
            'totalCount' => $query->count(),
            'pageParam' => 'pagination',
        ]);

        $chats = $query->orderBy(['id'=>SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all();

        foreach ($chats as $chat) {
            $chat_user = null;
            $chat_user = self::getChatUsersAdmin($chat->id, $user_id);
            $last_message = self::getLastMessage($chat_user);
            $count = self::getNoReadMessageCount($chat->id, $user_id);
//            $chat_user = self::getChatUserOther($chat_user_current->chat_id, $user_id);

            if($chat_user != null) {
                $result [] = [
                    'login' => $chat_user->user->login,
                    'image' => Users::getAvatarApi($chat_user->user->avatar),
                    'lastMessage' => self::getLastWord($last_message),
                    'date_cr' => self::getLastDate($last_message),
                    'chatId' => $chat->id,
                    'countNewMessage' => (int)$count,
                ];
            }
        }
        return [
            'pagination' => $pagination,
            'results' => $result,
        ];
    }

    // ***************************** all chat type = 6 *******************************
    public static  function getUsersListAllItemsChat($type ,$id)
    {
        $user_id = Yii::$app->user->identity->id;
        $result = [];

        $query = Chats::find()->where(['type'=>$type ,'field_id' => $id])
            ->andWhere(['!=','user_id_item',self::checkItems($id)]);

        $pagination = new Pagination([
            'defaultPageSize' => Yii::$app->params['paginationSizeChats'],
            'totalCount' => $query->count(),
            'pageParam' => 'pagination',
        ]);

        $chats = $query->orderBy(['id'=>SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all();

        foreach ($chats as $chat) {
            $chat_user = null;
            $chat_user = self::getChatUsersAdmin($chat->id, $chat->user_id_item);
            $last_message = self::getLastMessage($chat_user);
            $count = self::getNoReadMessageCount($chat->id, $user_id);

//            $chat_user = self::getChatUserOther($chat_user_current->chat_id, $user_id);

            if($chat_user != null) {
                $result [] = [
                    'login' => $chat_user->user->login,
                    'image' => Users::getAvatarApi($chat_user->user->avatar),
                    'lastMessage' => self::getLastWord($last_message),
                    'date_cr' => self::getLastDate($last_message),
                    'chatId' => $chat->id,
                    'countNewMessage' => (int)$count,
                ];
            }
        }
        return [
            'pagination' => $pagination,
            'results' => $result,
        ];
    }

    public static function checkItems($id)
    {
        $items = Items::find()->where(['id' => $id])->one();
        return $items != null ? $items->user_id : null;
    }

    public static function getChatUser($chat_id, $user_id)
    {
        return ChatUsers::find()
            ->where(['user_id'=> $user_id])
            ->andWhere(['chat_id' => $chat_id])->one();
    }

    public static function getChatUserOther($chat_id, $user_id)
    {
        return ChatUsers::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['chat_id' => $chat_id])->one();
    }

    public static function getChatUsersAdmin($chat_id, $user_id)
    {
        return ChatUsers::find()
            ->where(['!=','user_id',$user_id])
            ->andWhere(['chat_id' => $chat_id])->one();
    }

    public static function getNoReadMessageCount($chat_id, $user_id)
    {
        return (new \yii\db\Query())
            ->select(['*'])
            ->from('chat_message')
            ->where(['chat_id' => $chat_id, 'is_read' => 0])
            ->andWhere(['!=', 'user_id', $user_id])->count();
    }

    // ***************************** all Chomment *******************************
    public static  function getUsersListAllComment($type)
    {
        $user_id = Yii::$app->user->identity->id;
        $result = [];
        
        $query = Chats::find()->andWhere(['chats.type' => $type ]);

        $pagination = new Pagination([
            'defaultPageSize' => Yii::$app->params['paginationSizeChats'],
            // 'page' => 0,
            'totalCount' => $query->count(),
            'pageParam' => 'pagination',
        ]);

        $chats = $query->orderBy(['id'=>SORT_DESC])->offset($pagination->offset)
                                  ->limit($pagination->limit)->all();

        foreach ($chats as $value) {
            $chat_user = self::getChatUsers($value , $user_id);
            $last_message = self::getLastMessage($chat_user);
            $count = self::getNoReadMessage($value , $user_id);
            $comment = self::getNameComments($type,$value);

            // if($chat_user != null) {
                $result [] = [
                    'login' => $comment != null ? self::getLastWordComment($comment) : "",
                    'image' =>  $comment != null ? ChatsStatic::getNameImage($type,$comment): "",
                    'lastMessage' => self::getLastWord($last_message),
                    'date_cr' => self::getLastDate($last_message),
                    'chatId' => $value->id,
                    'countNewMessage' => (int) $count,
                ];
            // }
        }
        return [
                'pagination' => $pagination,
                'results' => $result,
            ];
    }

    //  ***********************  oxirgi message mavjud bolsa topish *******************************
    public static function getLastMessage($chat_user)
    {   
        if($chat_user != null ) {
            $last_message = (new \yii\db\Query())
                        ->select(['*'])
                        ->from('chat_message')
                        ->where(['chat_id' => $chat_user->chat_id ])
                         ->orderBy(['id' => SORT_DESC])
                        ->one();
            return $last_message;
        }
        else return null;
    }

    //  ****************************** oxirgi so;zni kesib junatish **********************
    public static  function getLastWord($last_message)
    {   
        if($last_message != null){
            
            if (strpos($last_message['message'], 'href') || strpos($last_message['message'], '<')) {
                return "Сообщения";
            }
            else {
                return (strlen($last_message['message']) > 45) ? mb_substr($last_message['message'], 0, 45) . "..." : $last_message['message'];
            }
        }
    }

    //  ****************************** oxirgi so;zni kesib junatish **********************
    public static  function getLastWordComment($last_message)
    {
        return $last_message != null ? (strlen($last_message['title']) > 25) ? mb_substr($last_message['title'], 0, 25) . "..." : $last_message['title'] : "";
    }

    // *********************** oxirgi message vaqti *****************************
    public static  function getLastDate($last_message)
    {
        return $last_message != null ? date('H:i d.m.Y', strtotime($last_message['date_cr'])) : null;
    }

    // ***********************  o'qilmagan messagelar soni  commenlar uchun*****************************
    public static function getNoReadMessage($value , $user_id)
    {
        return (new \yii\db\Query())
            ->select(['*'])
            ->from('chat_message')
            ->where(['chat_id' => $value->id, 'is_read' => 0])
                ->andWhere(['!=', 'user_id', $user_id])->count();
    }

     // ***********************  o'qilmagan messagelar soni oddiiy chatlar uchun*****************************
    public static function getNoReadMessageChats($value , $user_id)
    {
        return (new \yii\db\Query())
            ->select(['*'])
            ->from('chat_message')
            ->where(['chat_id' => $value->chat_id, 'is_read' => 0])
                ->andWhere(['!=', 'user_id', $user_id])->count();
    }

    // **************************** filtr for chat users chat id boyicha **********************
    public static function getChatUsers($value , $user_id)
    {
        return ChatUsers::find()
            // ->where(['!=', 'user_id', $user_id])
            ->andWhere(['chat_id' => $value->id])->one();
    }

      // **************************** filtr for chat users chat id boyicha **********************
    public static function getChatUsersChat($value , $user_id)
    {
        return ChatUsers::find()
            ->where(['!=', 'user_id', $user_id])
            ->andWhere(['chat_id' => $value->chat_id])->one();
    }

     // **************************** type  = 5 chat uchun user fio **********************
    public static function getChatUsersFio($value , $chat_user)
    {
        return $value->chat->type == 5 ? $chat_user->user->fio." (".self::getShopsName($value->chat->name).")" : $chat_user->user->fio;
    }

    // ****************** type = 5 bolgandagi shop name  ********************************
    public static function getShopsName($name)
    {   
        $chats = null; $shops = null;
        
        $chats = (new \yii\db\Query())
            ->select(['*'])
            ->from('chats')
            ->where(['name' =>$name])
            ->andWhere(['type' => 5])->one();

        if($chats != null){
            $shops = (new \yii\db\Query())
            ->select(['*'])
            ->from('shops')
            ->where(['id' => $chats['field_id']])
            ->one();

            return $shops != null ? $shops['name'] : "";
        }
    }

    public static function getNameComments($type ,$chats)
    {
        switch ($type) {
            case 3: $blogs = (new \yii\db\Query())
                        ->select(['*'])
                        ->from('blog_posts')
                        ->where(['id' => $chats->field_id])
                        ->one();
            return $blogs != null ? [
                'image' => $blogs['image'],
                'title' => $blogs['title'],
            ] : ""; 
            break;
            case 4:$items = (new \yii\db\Query())
                        ->select(['*'])
                        ->from('items')
                        ->where(['id' => $chats->field_id])
                        ->one(); 
            return $items != null ? [
                'title' => $items['title'],
                'image' => $items['img_s']
                ] : ""; 
                break;
            case 5:$shops = (new \yii\db\Query())
                        ->select(['*'])
                        ->from('shops')
                        ->where(['id' => $chats->field_id])
                        ->one(); 
            return $shops != null ? [
                'title' => $shops['name'],
                'image' => $shops['logo']
                ] : ""; 
                break;
        }
    }

    // ******************************** for header **************************** 
     public static  function getUsersListHeaderChat($type)
    {
        $user_id = Yii::$app->user->identity->id;
        $result = [];
        $chats = Chats::find()->where(['type' => 1])->asArray()->all();

        $chat_message = ChatMessage::find()
                                ->where(['is_read' => 0])
                                ->andWhere(['chat_id' => array_column($chats , 'id') ])
                                ->andWhere(['!=' , 'user_id' , $user_id ])
                                ->asArray()
                                ->all();

        $chatUsers = ChatUsers::find()
                    ->with('chat')
                    ->join('inner join' ,'chats','chats.id = chat_users.chat_id')
                    ->andWhere(['chat_users.user_id' => $user_id ])
                    ->andWhere(['chat_id' => array_column($chat_message , 'chat_id') ])
                    ->orderBy(['date_cr' => SORT_DESC])
                    ->limit(20)
                    ->all();



        foreach ($chatUsers as $value) {
            $chat_user = self::getChatUsersChat($value , $user_id);
            $last_message = self::getLastMessage($chat_user);
            $count = self::getNoReadMessageChats($value , $user_id);

            if($chat_user != null) {
                $result [] = [
                    'login' => $chat_user->user->login,
                    'image' => $chat_user->user->getAvatarForSite(),
                    'lastMessage' => self::getLastWord($last_message),
                    'date_cr' => self::getLastDate($last_message),
                    'chatId' => $value->chat->id,
                    'countNewMessage' => (int) $count,
                ];
            }
        }
        return $result;
    }

}
