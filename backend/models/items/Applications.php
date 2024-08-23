<?php


namespace backend\models\items;


class Applications extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_PROCESS = 2;
    const STATUS_CANCELED = 3;
    const STATUS_ENDED = 4;

    const IS_DELETED = 4; //boolean

    public static function tableName()
    {
        return 'applications';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Объявления',
            'phone' => 'Телефон номеры',
            'address' => 'Адрес',
            'fullname' => 'ФИО',
            'status' => 'Статус',
            'comment' => 'Комментарий',
            'created_at' => 'Дата создания'
        ];
    }

    public function rules()
    {
        return [
            [['item_id', 'status'], 'default', 'value' => null],
            [['item_id', 'status'], 'integer'],
            [['created_at', 'updated_at','is_delete'], 'safe'],
            [['phone', 'fullname', 'address', 'comment'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Items::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    public function getItem()
    {
        return $this->hasOne(Items::class, ['id' => 'item_id']);
    }

    public static function statusLabels(){
        return [
            self::STATUS_NEW => 'Новый',
            self::STATUS_PROCESS => 'В процессе работы',
            self::STATUS_CANCELED => 'Отменено',
            self::STATUS_ENDED => 'Завершение',
        ];
    }

    public function status(){
        return self::statusLabels()[$this->status] ?? '(не задано)';
    }


}