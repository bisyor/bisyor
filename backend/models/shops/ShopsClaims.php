<?php

namespace backend\models\shops;

use Yii;
use backend\models\users\Users;

/**
 * This is the model class for table "shops_claims".
 *
 * @property int $id
 * @property int|null $shop_id Магазин
 * @property int|null $user_id Пользователь
 * @property string|null $user_ip Ip пользователья
 * @property int|null $reason
 * @property string|null $message Сообщение (текст)
 * @property bool|null $viewed Просмотрено да или Нет
 * @property string|null $date_cr Дата создание
 *
 * @property Shops $shop
 * @property Users $user
 */
class ShopsClaims extends \yii\db\ActiveRecord
{
    const VIEWED = 1;
    const NOT_VIEWED = 0;

    const REASON_LIST = ['Неверная рубрика','Запрещенный товар/услуга','Неверный адрес','Другое'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shops_claims';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shop_id', 'user_id', 'reason'], 'default', 'value' => null],
            [['shop_id', 'user_id', 'reason'], 'integer'],
            [['message'], 'string'],
            [['viewed'], 'boolean'],
            [['date_cr'], 'safe'],
            [['user_ip'], 'string', 'max' => 255],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shops::className(), 'targetAttribute' => ['shop_id' => 'id']],
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
            'shop_id' => 'Магазин',
            'user_id' => 'Пользователь',
            'user_ip' => 'Ip пользователья',
            'reason' => 'Причина',
            'message' => 'Сообщение (текст)',
            'viewed' => 'Просмотрено',
            'date_cr' => 'Дата создание',
        ];
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


    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }


    /**
     * @return string|null
     */
    public function getReasonDescription()
    {
        if($this->reason == 3 ) return $this->message;
        return isset(self::REASON_LIST[$this->reason]) ? self::REASON_LIST[$this->reason] : "не задано";
    }


    /**
     * @return string[]
     */
    public static function getReason()
    {
        return self::REASON_LIST;
    }


    /**
     * @return string
     */
    public function getYesNo()
    {
        return ($this->viewed == 1) ? "<span class='label label-success'>Да</span>" : "<span class='label label-danger'>Нет</span>";
    }


    /**
     * @return string[]
     */
    public static function getAnswerType()
    {
       return [
            0 => 'Нет',
            1 => 'Да'
        ];
    }


    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getDate()
    {
        if($this->date_cr)
            return Yii::$app->formatter->asDate($this->date_cr,'php: H:i d.m.Y');
    }
}
