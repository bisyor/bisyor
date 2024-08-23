<?php

namespace backend\models\items;

use Yii;

/**
 * This is the model class for table "items_scale".
 *
 * @property int $id
 * @property string|null $name Наименование
 * @property string|null $description Описание
 * @property string|null $key Ключ
 * @property int|null $status Статус
 * @property float|null $ball Балл
 * @property string|null $minimum_value Минимальная значение
 */
class ItemsScale extends \yii\db\ActiveRecord
{

    const  STATUS_ACTIVE = 1;
    const  STATUS_INACTIVE = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items_scale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['ball'], 'number'],
            [['name', 'key', 'minimum_value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'description' => 'Описание',
            'key' => 'Ключ',
            'status' => 'Статус',
            'ball' => 'Балл',
            'minimum_value' => 'Минимальная значение',
        ];
    }


    public function getStatusType(){
        switch ($this->status) {
            case self::STATUS_ACTIVE :  return "Не активно";
            case self::STATUS_INACTIVE  : return "Активно";
        }
    }

    public static function getImageSize($image ,$size){
        $itemsPath = Yii::$app->params['itemsPath'];
        $imageSize = self::getHeaderValue($itemsPath.$image,1);
        if(isset($imageSize['Content-Length']) && ($size <= $imageSize['Content-Length'] / 1024))
            return true;
        return false;
    }


    public static function getHeaderValue($url){
        $arrContextOptions = stream_context_create([
            "ssl"=>[
                "verify_peer"   =>  false,
                "verify_peer_name"  =>  false,
            ],
        ]); 

        return get_headers($url , 1 , $arrContextOptions);
    }

    /**
     * set ball for items
     * @param $model
     */
    public static function setBallItems($model)
    {
        $scale_value = 0;
        $result = '';
        $itemsScale = ItemsScale::find()->where(['status' =>1])->all();
        foreach ($itemsScale as $value){

            // for title
            if($value->key == "title" && ($value->minimum_value <= strlen($model->title)) ){
                $scale_value += $value->ball;
                $result .= '<br>title =' . $value->ball;
            }

            // for image_quality
            if($value->key == "image_quality" && self::getImageSize($model->img_m, $value->minimum_value) ){
                $scale_value += $value->ball;
            }

            // for description
            elseif($value->key == "description" && ($value->minimum_value <= strlen($model->description))){
                $scale_value += $value->ball;
                $result .= '<br>description =' . $value->ball;
            }


            // for phone
            elseif($value->key == "phone" && !empty($model->phones) && $value->minimum_value  <= count(($model->phones))){
                $scale_value += $value->ball;
                $result .= '<br>phone =' . $value->ball;
            }


            // for video
            elseif($value->key == "video" && $model->video){
                $scale_value += $value->ball;
                $result .= '<br>video =' . $value->ball;
            }


            // for image count
            elseif($value->key == "image_count" ){
                $scale_value += $value->ball* $model->getImagesCount();
                $result .= '<br> image count =' . $value->ball;
            }


            // for view count
            elseif($value->key == "view_count" && ($value->minimum_value <= array_sum(array_column( $model->itemViews,'item_views')) )){
                $scale_value += $value->ball;
                $result .= '<br>view count =' . $value->ball;
            }


            // for favorites count
            elseif($value->key == "favorites" && $value->minimum_value <= count($model->itemFavorites)){
                $scale_value += $value->ball;
                $result .= '<br>favorites =' . $value->ball;
            }
        }
        //return $scale_value;
        Yii::$app->db->createCommand()->update('items', ['popular_degree' => $scale_value], [ 'id' => $model->id ])->execute();
        return $result;
    }

    public static function setBallItemsForCrone($model, $itemsScale)
    {
        $scale_value = 0;
        $result = '';
        foreach ($itemsScale as $value){

            // for title
            if( $value->key == "title" && ($value->minimum_value <= strlen($model->title)) ){
                $scale_value += $value->ball;
                $result .= '<br>title =' . $value->ball;
            }

//            // for image_quality
//            if($value->key == "image_quality" && self::getImageSize($model->img_m ,$value->minimum_value) ){
//                $scale_value += $value->ball;
//            }

            // for description
            elseif($value->key == "description" && ($value->minimum_value <= strlen($model->description))){
                $scale_value += $value->ball;
                $result .= '<br>description =' . $value->ball;
            }


            // for phone
            elseif($value->key == "phone" && $value->minimum_value  <= count(($model->phones))){
                $scale_value += $value->ball;
                $result .= '<br>phone =' . $value->ball;
            }


            // for video
            elseif($value->key == "video" && $model->video){
                $scale_value += $value->ball;
                $result .= '<br>video =' . $value->ball;
            }


            // for image count
            elseif($value->key == "image_count" ){
                $scale_value += $value->ball* $model->getImagesCount();
                $result .= '<br> image count =' . $value->ball;
            }


            // for view count
            elseif($value->key == "view_count" && ($value->minimum_value <= array_sum(array_column( $model->itemViews,'item_views')) )){
                $scale_value += $value->ball;
                $result .= '<br>view count =' . $value->ball;
            }


            // for favorites count
            elseif($value->key == "favorites" && $value->minimum_value <= count($model->itemFavorites)){
                $scale_value += $value->ball;
                $result .= '<br>favorites =' . $value->ball;
            }
        }


        //return $scale_value;
        Yii::$app->db->createCommand()->update('items', ['popular_degree' => $scale_value], [ 'id' => $model->id ])->execute();
        return $result;
    }
}
