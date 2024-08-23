<?php
namespace backend\models\items;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class  UserBuyedLimit extends ActiveRecord{

    public static function tableName(){
        return 'user_buyed_limit';
    }
    
    public function attributeLabels(){
        return [
            'id' => 'ID',
            'active' => 'Статус',
            'shop' => 'Для',
            'item_count' => 'Кол-во бесплатных',
            'used_count' => 'Кол-во использованных',
            'category_id' => 'Категория',
            'summa' => 'Стоимость',
        ];
    }


    /**
     * @param $user_id
     * @return ActiveDataProvider
     */
    public static function search($user_id){
        $query = parent::find()->where(['user_id' => $user_id])->with('category');
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }


    public function getCategory(){
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }
    

}


?>