<?php

namespace backend\models\items;

use Yii;
use backend\models\users\Users;
/**
 * This is the model class for table "items_claim".
 *
 * @property int $id
 * @property int|null $item_id Объявление
 * @property int|null $user_id Пользователь
 * @property string|null $user_ip User IP
 * @property int|null $reason Причина
 * @property string|null $message Сообщение
 * @property bool|null $viewed Обработан
 * @property string|null $date_cr Дата создание
 *
 * @property Items $item
 * @property Users $user
 */
class ItemsClaim extends \yii\db\ActiveRecord
{
    const VIEWED = 1;
    const NOT_VIEWED = 0;

    const REASON_LIST = [
        0 => 'Объявления не актуально',
        1 => 'Запрещенный товар/услуга',
        2 => 'Неверное описание, фото',
        3 => 'Неверная рубрика',
        4 => 'Неверная цена',
        5 => 'Мошенничество',
        6 => 'Спам',
        7 => 'Другая причина',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items_claim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'user_id', 'reason'], 'default', 'value' => null],
            [['item_id', 'user_id', 'reason'], 'integer'],
            [['message'], 'string'],
            [['viewed'], 'boolean'],
            [['date_cr'], 'safe'],
            [['user_ip'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Items::className(), 'targetAttribute' => ['item_id' => 'id']],
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
            'item_id' => 'Объявление',
            'user_id' => 'Пользователь',
            'user_ip' => 'User IP',
            'reason' => 'Причина',
            'message' => 'Сообщение',
            'viewed' => 'Обработан',
            'date_cr' => 'Дата создание',
        ];
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Items::className(), ['id' => 'item_id']);
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

    public function getReasonDescription()
    {
        switch ($this->reason) {
            case 0: return 'Объявления не актуально';break;
            case 1: return 'Запрещенный товар/услуга';break;
            case 2: return'Неверное описание, фото';break;
            case 3: return 'Неверная рубрика';break;
            case 4: return 'Неверная цена';break;
            case 5: return 'Мошенничество';break;
            case 6: return 'Спам';break;
            case 7: return 'Другая причина';break;
            default :return '';
        }

    }

    public static function getReason()
    {
        return self::REASON_LIST;
    }

    public function getYesNo()
    {
        return ($this->viewed == 1) ? "<span class='label label-success'>Да</span>" : "<span class='label label-danger'>Нет</span>";
    }

    //status 
    public static function getStatusName($status = null)
    {
        return ($status == 1) ? '<span class="label label-success"> Активно </span>' : '<span class="label label-danger">Не активно</span>';
    }
    
    public static function getAnswerType()
    {
       return [
            0 => 'Нет',
            1 => 'Да'
        ];
    }

    public function getDate()
    {
        if($this->date_cr)
            return date('d.m.Y H:i:s' ,strtotime($this->date_cr));
    }


    /**
     * qoilmagan jalbalar soni
     * @return bool|int|string|null
     */
    public static  function getItemsClaimCount()
    {
        return (new \yii\db\Query())
            ->select(['id'])
            ->from('items_claim')
            ->where(['viewed' => 0])
            ->count();
    }
}
