<?php

namespace backend\models\bills;

use backend\models\users\Users;
use Yii;
use yii\base\Model;

class Payment extends Model
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

    public function getUserBalanse($user_id){
        $user = Users::findOne($user_id);
        if($user) return $user->balance;
        return 0;
    }

}
