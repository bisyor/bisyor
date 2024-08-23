<?php

namespace backend\models\items;

use backend\models\references\Districts;
use backend\models\references\Regions;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use function foo\func;

/**
 * This is the model class for table "items_limits".
 *
 * @property int $id
 * @property int|null $cat_id
 * @property int|null $district_id
 * @property int|null $shop
 * @property int|null $free
 * @property int|null $items
 * @property string|null $settings
 * @property int|null $enabled
 * @property int|null $group_id
 * @property string|null $title
 * @property string|null|array $regions
 *
 * @property Categories $category
 */
class ItemsLimits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $regions;
    public $price;
    public $count;
    public $check;
    public $itemCheck;
    public static function tableName()
    {
        return 'items_limits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_id', 'district_id', 'shop', 'free', 'items', 'enabled', 'group_id'], 'default', 'value' => 0],
            [['cat_id', 'district_id', 'shop', 'free', 'items', 'enabled', 'group_id', 'price', 'count'], 'integer'],
            [['settings', 'title'], 'string'],
            [['check'], 'boolean'],
            [['regions', 'itemCheck'], 'safe'],
            ['regions', 'required', 'when' => function(){return ($this->isNewRecord && $this->group_id == null && $this->cat_id == null) ? true:false;}, 'enableClientValidation' => false],
            [['price', 'count'], 'required', 'when' => function(){return ($this->itemCheck == 'check') ? true:false;}, 'enableClientValidation' => false],
            ['cat_id', 'required', 'when' => function(){return ($this->isNewRecord && $this->group_id == null && $this->regions == null) ? true:false;}, 'enableClientValidation' => false],
//            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['cat_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Категория',
            'district_id' => 'District ID',
            'shop' => 'Shop',
            'free' => 'Free',
            'items' => 'Лимит',
            'settings' => 'Settings',
            'enabled' => 'Активно',
            'group_id' => 'Group ID',
            'title' => 'Title',
            'regions' => 'Регионы',
            'count' =>'Количество',
            'price' =>'Цена',
            'check' => 'Включена'
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'cat_id']);
    }
    public function getDistrict()
    {
        return $this->hasOne(Districts::className(), ['id' => 'district_id']);
    }


    /**
     * @param $type
     * @return ActiveDataProvider
     */
    public static function getData($type)
    {
        return new ActiveDataProvider(
            [
                'query' => parent::find()->joinWith(['category'])->where(
                    ['shop' => $type, 'free' => 1, 'district_id' => 0]
                )->andWhere(['!=', 'cat_id', 0])->orderBy('id')
            ]
        );
    }

    /**
     * @param $post
     * @param $price
     * @return array
     */
    public static function setSettings($post, $price){
        $settings = [];
        foreach ($price as $value){
            $settings[] = [
                'id' => $value['id'],
                'items' => $value['items'],
                'price' => $post['value_'.$value['id']],
                'checked' => isset($post['check_'.$value['id']]),
            ];;
        }
        return $settings;
    }


    /**
     * @param $model
     */
    public static function setRegions($model){
        foreach ($model->regions as $value){
            $dist = Regions::findOne($value);
            $regs[$value] =[
                'lvl' => 3,
                't' => $dist->name,
                'c' => '9061'
            ];
        }
    }
}
