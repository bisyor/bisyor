<?php

namespace backend\models\users;

use Yii;
/**
 * This is the model class for table "user_history".
 *
 * @property int $id
 * @property int|null $user_id Пользователь
 * @property string|null $date_cr Дата создание
 * @property int|null $type Тип
 * @property string|null $title Заголовок
 * @property string|null $value Значение
 *
 * @property Users $user
 */
class UserHistory extends \yii\db\ActiveRecord
{

    const TYPE_REGISTRATION = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'default', 'value' => null],
            [['user_id', 'type','from_device'], 'integer'],
            [['date_cr'], 'safe'],
            [['value'], 'string'],
            [['title'], 'string', 'max' => 255],
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
            'user_id' => 'Пользователь',
            'date_cr' => 'Дата создание',
            'type' => 'Тип',
            'title' => 'Заголовок',
            'value' => 'Значение',
            'from_device' => 'Устройства',
        ];
    }
    public function beforeSave($insert){
        if ($this->isNewRecord) {
            $this->date_cr = date("Y-m-d H:i");
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


    public function getFromDevice()
    {
        if($this->from_device == 1) return 'Сайт';
        elseif($this->from_device == 2) return 'Телеграм Бот';
        elseif($this->from_device == 3) return 'Андроид';
        elseif($this->from_device == 4) return 'IOS';
        return 'Не задано';
    }

    public static function getDeviceList(){
        return [
            '1' => 'Сайт',
            '2' => 'Телеграм Бот',
            '3' => 'Андроид',
            '4' => 'IOS',
        ];
    }
}
