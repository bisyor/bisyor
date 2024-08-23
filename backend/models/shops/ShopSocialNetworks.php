<?php

namespace backend\models\shops;


use Yii;
use yii\base\Model;

class ShopSocialNetworks extends Model
{
    public $id;
    public $name;
    public $address;

    public function rules()
    {
        return [
            [['id'],'integer'],
            [['name','address'],'required']
        ];
    }
    

    public function attributeLabels()
    {
        return [
            'networks' => 'Социальные сети',
        ];
    }
    public function getIsNewRecord()
    {
      return $this->name == '' && $this->address =='';
    }
}
