<?php
namespace backend\models\chats;

use backend\models\blogs\BlogPosts;
use backend\models\items\Items;
use Yii;
use backend\models\users\Users;
use yii\data\Pagination;

/**
 * This is the model class for table "chats".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $date_cr Дата создание
 * @property int|null $type Тип чата
 * @property int|null $field_id Id поля
 *
 * @property ChatMessage[] $chatMessages
 * @property ChatUsers[] $chatUsers
 */
class Chats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_cr'], 'safe'],
            [['type', 'field_id'], 'integer'], //(1=> admin, 2 => oddiy_chat) (Тип чата)
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' =>'Наименование',
            'date_cr' =>'Дата создание',
            'type' => 'Тип чата',
            'field_id' => 'Id поля',
        ];
    }


    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->date_cr = date('Y-m-d H:i:s');
        }
        
        return parent::beforeSave($insert);
    }


    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        $users = ChatUsers::find()->where(['chat_id' => $this->id])->all();
        foreach ($users as $user) {
            $user->delete();
        }
        return parent::beforeDelete();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        if(in_array(Yii::$app->session['type'] ,[4,6])) {
            return $this->hasOne(Items::className(), ['id' => 'field_id']);
        }
        else return $this->hasOne(BlogPosts::className(), ['id' => 'field_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastMessage()
    {
        return $this->hasOne(ChatMessage::className(), ['chat_id' => 'id'])->orderBy(['chat_message.date_cr' => SORT_DESC]);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastCount()
    {
        return $this->hasMany(ChatMessage::className(), ['chat_id' => 'id'])->where(['chat_message.is_read' => false])->select('chat_message.id');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatMessages()
    {
        return $this->hasMany(ChatMessage::className(), ['chat_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChatUsers()
    {
        return $this->hasMany(ChatUsers::className(), ['chat_id' => 'id']);
    }


    /**
     * smslardagi userlarni listi
     * @param $query
     * @return array
     */
    public static function getUsersList($query)
    {
        $array = [];
        $pagination = new Pagination([
            'defaultPageSize' => Yii::$app->params['paginationSizeChats'],
            'totalCount' => $query->count(),
            'pageParam' => 'page',
        ]);
        $dataProvider = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        foreach ($dataProvider as $value) {
            $array [] = [
                'chat_id' => $value->id,
                'message' => [
                    'last_message' =>$value->lastMessage != null ? mb_substr($value->lastMessage->message , 0, 45)  : null,
                    'date_cr' => $value->lastMessage != null ? date('H:i d.m.Y', strtotime($value->lastMessage->date_cr)) : null,
                    'count' => count($value->lastCount),
                ],
                'items' => [
                    'item_id' => $value->items != null  ? $value->items->id : null,
                    'item_title' => $value->items != null ? mb_substr( $value->items->title , 0, 45) : null,
                    'item_image' =>  $value->items != null ? self::getImage($value->items) : null,
                ],

            ];
        }
        return [
            'results' => $array,
            'pagination' =>$pagination,
        ];
    }


    /**
     * imagelarni adresini olish
     * @param $value
     * @return string
     */
    public static function getImage($value){
        $siteName = Yii::$app->params['image_site'];
        if(in_array(Yii::$app->session['type'] ,[4,6])) {
           return  self::getImageM($value->img_m);
        }
        else {
            $image = $value->image;
            $itemsPath = Yii::$app->params['blogsPath'];
            if($image == null || $image == '') return $siteName.'/web/uploads/noimg.jpg';
            else {
                return $itemsPath .  $image;
            }
        }
    }


    /**
     * @param $img_m
     * @return string
     */
    public static function getImageM($img_m)
    {
        $siteName = Yii::$app->params['image_site'];
        $itemsPath = Yii::$app->params['itemsPath'];
        if($img_m == null || $img_m == '') return $siteName.'/web/uploads/noimg.jpg';
        else {
            if($img_m == 'def-m.png')return $siteName.'/web/uploads/noimg.jpg';
            else return $itemsPath .  $img_m;
        }
    }


    /**
     * @param $chat_id
     * @param $type
     * @return array|null
     */
    public static function getNameItems($chat_id,$type)
    {
        if($type == 1) return null;
        $item = Chats::find()
            ->with(['items'])
            ->where(['id' => $chat_id])
            ->one();
        if(!$item) return null;
        return [
            'title' => mb_substr($item->items->title , 0, 80) ,
            'id' => $item->id,
            'url' => $type != 3 ? '/items/items/update?id='.$item->items->id : '/blogs/blog-posts/view?id='.$item->items->id,
        ];
    }

}
