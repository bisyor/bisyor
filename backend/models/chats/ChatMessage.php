<?php

namespace backend\models\chats;

use Yii;
use backend\models\users\Users;
use yii\data\Pagination;

/**
 * This is the model class for table "chat_message".
 *
 * @property int $id
 * @property int|null $chat_id Чат
 * @property int|null $user_id Пользователь
 * @property string|null $message Сообщение
 * @property string|null $file Файл
 * @property string|null $date_cr Дата создание
 * @property int|null $is_read Прочитано
 * @property int|null $answer_to Прочитано
 *
 * @property Chats $chat
 * @property Users $user
 */
class ChatMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['chat_id', 'user_id', 'is_read', 'answer_to' ,'is_moderated'], 'integer'],
            [['message'], 'string'],
             [['message','chat_id'], 'required'],
            [['date_cr'], 'safe'],
            [['file'], 'string', 'max' => 255],
            [['chat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chats::className(), 'targetAttribute' => ['chat_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['answer_to'], 'exist', 'skipOnError' => true, 'targetClass' => ChatMessage::className(), 'targetAttribute' => ['answer_to' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'chat_id' => 'Чат',
            'user_id' => 'Пользователь',
            'message' => Yii::t('app', "Xabar matni"),
            'file' => 'Файл',
            'date_cr' =>'Дата создание',
            'is_read' =>'Прочитано',
        ];
    }


    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord)
        {
            $this->date_cr = date("Y-m-d H:i:s");
            $this->is_read = 0;
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
        $messages = ChatMessage::find()->where(['chat_id' => $this->chat_id])->all();
        foreach ($messages as $msg) {
            $msg->delete();
        }
        return parent::beforeDelete();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChat()
    {
        return $this->hasOne(Chats::className(), ['id' => 'chat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
    public function getChatReplay()
    {
        return $this->hasMany(ChatMessage::className(), ['answer_to' => 'id']);
    }


    /**
     * messagelarni lisitini olish
     * @param $query
     * @param $user_id
     * @return array
     */
    public static function getMessageList($query,$user_id )
    {

        $array = [];
        $pagination = new Pagination([
            'defaultPageSize' => Yii::$app->params['paginationSizeChats'],
            'totalCount' => $query->count(),
            'pageParam' => 'pagination',
        ]);
        $dataProvider = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        foreach ($dataProvider as $value) {
            $value->checkMessageFrom($user_id);
            $array [] = [
                'id' => $value->id,
                'user_id' => $value->user_id,
                'date_cr' =>  date('H:i d.m.Y', strtotime($value->date_cr)),
                'user' => $value->user->getChatUsers(),
                'message' =>$value->message,
                'is_moderated' => $value->is_moderated,
            ];
        }
        return [
            'pagination' => $pagination,
            'messagesList' => $array,
        ];
    }


    /**
     * @param $user_id
     * @return string
     */
    public function checkMessageFrom($user_id)
    {
        if($this->user_id == $user_id) {
            return  'me';
        }
        else {
            $this->is_read = true;
            $this->save(false);
            return 'you';
        }
    }
}
