<?php

namespace backend\models\bills;

use Yii;
use yii\base\Model;

class Operation extends Model
{
    
    public $price;
    public $description;
    public $notification;
    public $user_id;

    public function rules()
    {
        return [
            [['price', 'description', 'notification', 'user_id'] , 'safe'],
            [['price'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'price' => 'Сумма',
            'description' => 'Описания',
            'notification' => 'Отправлять увидамление пользователю',
        ];
    }

}
