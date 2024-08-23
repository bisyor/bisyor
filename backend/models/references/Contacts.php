<?php

namespace backend\models\references;

use backend\models\users\Users;
use Yii;

/**
 * This is the model class for table "contacts".
 *
 * @property int $id
 * @property int|null $type Тип
 * @property int|null $user_id Пользователь
 * @property string|null $user_ip IP
 * @property string|null $name Наименование
 * @property string|null $email E-mail
 * @property string|null $message Сообщение
 * @property string|null $useragent Браузер пользователья
 * @property string|null $date_cr Дата создание
 * @property string|null $date_up Дата изменение
 * @property bool|null $viewed Статус
 *
 * @property Users $user
 */
class Contacts extends \yii\db\ActiveRecord
{
    const VIEWED_ACTIVE = 1;
    const VIEWED_INACTIVE = 0; 
    const TYPE_ERROR_ON_THE_SITE = 1;
    const TYPE_TECHNICAL_QUESTION = 2;
    const TYPE_PREDLOJENIYA = 3;
    const TYPE_OTHER_QUESTION = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'user_id'], 'default', 'value' => null],
            [['type', 'user_id'], 'integer'],
            [['message', 'useragent','reason'], 'string'],
            [['date_cr', 'date_up'], 'safe'],
            [['viewed'], 'boolean'],
            [['user_ip', 'name', 'email'], 'string', 'max' => 255],
            [['reason'],'required'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'user_id' => 'Пользователь',
            'user_ip' => 'User Ip',
            'name' => 'Наименование',
            'email' => 'Email',
            'message' => 'Сообщение',
            'useragent' => 'Браузер пользователья',
            'date_cr' => 'Дата создание',
            'date_up' => 'Дата изменение',
            'viewed' => 'Статус',
            'reason' => 'Причина',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->date_cr = date("Y-m-d H:i:s");
            $this->date_up = date("Y-m-d H:i:s");
        }
        return parent::beforeSave($insert);
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

    public function getUserFio()
    {
        if($this->user_id != 0){
            if($this->user->fio != null) return $this->user->fio;
            else {
                if($this->user->phone != null) return $this->user->phone;
                else return $this->user->email;
            }
        }
    }

    public static function getViewedName($status = null)
    {
        switch ($status) {
            case self::VIEWED_ACTIVE:
                return '<span class="label label-success"> Да </span>';
                break;
            case self::VIEWED_INACTIVE:
                return '<span class="label label-danger"> Нет </span>';
                break;
        }
    }

    public static function getViewedType()
    {
       return  [
            self::VIEWED_ACTIVE => 'Да',
            self::VIEWED_INACTIVE => 'Нет',
        ];
    }
 
    public function getDateCr()
    {
        if($this->date_cr != null) return date('H:i d.m.Y', strtotime($this->date_cr) );
        else return null;
    }

    public function getDateUp()
    {
        if($this->date_up != null) return date('H:i d.m.Y', strtotime($this->date_up) );
        else return null;
    }

    public function getTypeDesc()
    {
        if(self::TYPE_ERROR_ON_THE_SITE == $this->type) return "Ошибка на сайте";
        if(self::TYPE_TECHNICAL_QUESTION == $this->type) return "Технический вопрос";
        if(self::TYPE_OTHER_QUESTION == $this->type) return "Другие вопросы";
        if(self::TYPE_PREDLOJENIYA == $this->type) return "Предложения";
    }
}
