<?php

namespace backend\models\promocodes;
use backend\models\shops\Services;

use Yii;

/**
 * This is the model class for table "promocodes".
 *
 * @property int $id
 * @property string|null $code Промокод
 * @property string|null $title Название
 * @property int|null $type Тип
 * @property int|null $amount Сумма пополнения
 * @property int|null $usage_by Кто может применить
 * @property int|null $discount_type Вариант скидки
 * @property int|null $discount Размер скидки
 * @property int|null $usage_for Зона действия
 * @property string|null $category_list Список категории
 * @property string|null $regions_list Список регионов
 * @property bool|null $active Активен
 * @property string|null $active_to Действует до
 * @property int|null $usage_limit Кол-во срабатываний
 * @property bool|null $is_once Доступно пользователю
 * @property bool|null $break_days Не чаще чем
 * @property int|null $used
 * @property string|null $created_at Дата создание
 * @property string|null $active_from Дата активации
 * @property int|null $service_id Услуга
 *
 * @property Services $service
 * @property PromocodesUsage[] $promocodesUsages
 */
class Promocodes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    /***
     * Constanta for type list
     */
    const TYPE_DISCOUNT = 1;
    const TYPE_AMOUNT = 2;
    /**
     * Constanta for usage_by list
     */
    const USAGE_INDIVUDAL = 2;
    const USAGE_ALL = 1;
    const USAGE_SHOPS = 3;
    /**
     * Constanta for discount type list
     */
    const DISCOUNT_PERCENT = 1;
    const DISCOUNT_SUMM = 2;
    const DISCOUNT_FREE = 3;
    /**
     * Constanta for usage_for list
     */
    const USAGEFOR_ONE = 1;
    const USAGEFOR_TWO = 2;
    const USAGEFOR_THRE = 3;

    public static function tableName()
    {
        return 'promocodes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'amount', 'usage_by', 'discount_type', 'discount', 'usage_for', 'usage_limit',  'service_id'], 'default', 'value' => null],
            [['type', 'amount', 'usage_by', 'discount_type', 'discount', 'usage_for', 'usage_limit', 'used', 'service_id', 'break_days'], 'integer'],
            ['code', 'unique'],
            [['title', 'title', 'usage_limit'], 'required'],
            ['discount', 'required', 'when' => function($model){ return $model->discount_type != 3 && $model->type == 1;}, 'enableClientValidation' => true],
            ['amount', 'required', 'when' => function($model){ return $model->type == 2;}, 'enableClientValidation' => true],
            [['category_list', 'regions_list'], 'safe'],
            [['active', 'is_once'], 'boolean'],
            [['active_to', 'created_at', 'active_from'], 'safe'],
            [['code', 'title'], 'string', 'max' => 255],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Промокод',
            'title' => 'Название',
            'type' => 'Тип',
            'amount' => 'Сумма пополнения',
            'usage_by' => ' Кто может применить',
            'discount_type' => 'Вариант скидки',
            'discount' => 'Размер скидки',
            'usage_for' => 'Зона действия',
            'category_list' => 'Список категории',
            'regions_list' => 'Список регионов',
            'active' => 'Активен',
            'active_to' => 'Действует до',
            'usage_limit' => 'Кол-во срабатываний',
            'is_once' => 'Доступно пользователю',
            'break_days' => 'Не чаще чем',
            'used' => 'Сколько использовано',
            'created_at' => 'Дата создание',
            'active_from' => 'Дата активации',
            'service_id' => 'Услуга',
        ];
    }


    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->created_at = date("Y-m-d H:i");
            $this->used = 0;
        }
        if($this->active_to){
            $this->active_to = date('Y-m-d H:i', strtotime($this->active_to));
        }
        if($this->regions_list){
            $str="";
            foreach ($this->regions_list as $value){
                $str.=$value.",";
            }
            $this->regions_list = $str;
        }
        if($this->category_list){
            $str="";
            foreach ($this->category_list as $value){
                $str.=$value.",";
            }
            $this->category_list = $str;
        }
        return parent::beforeSave($insert);
    }


    /**
     * after faind
     */
    public function afterFind()
    {
        if($this->active_to){
            $this->active_to = date("d.m.Y", strtotime($this->active_to));
        }
        if(!empty($this->regions_list)){
            $this->regions_list = explode(',', $this->regions_list);
        }
        if(!empty($this->category_list)){
            $this->category_list = explode(',', $this->category_list);
        }
        parent::afterFind();
    }


    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Services::className(), ['id' => 'service_id']);
    }


    /**
     * Gets query for [[PromocodesUsages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromocodesUsages()
    {
        return $this->hasMany(PromocodesUsage::className(), ['promocode_id' => 'id']);
    }


    /**
     * @return string[]
     */
    public static  function getTypeList(){
        return [
            self::TYPE_DISCOUNT => 'Скидка',
            self::TYPE_AMOUNT => 'Пополнение'
        ];
    }


    /**
     * @return string[]
     */
    public static function getUsageByList(){
        return [
            self::USAGE_ALL => 'Все',
            self::USAGE_INDIVUDAL => 'Частные лица',
            self::USAGE_SHOPS => 'Магазины'
        ];
    }


    /**
     * @return string[]
     */
    public static function getDiscountList(){
        return [
            self::DISCOUNT_PERCENT => 'Процент',
            self::DISCOUNT_SUMM => 'Сумма',
            self::DISCOUNT_FREE => 'Бесплатно'
        ];
    }


    /**
     * @return string[]
     */
    public static function getUsageForList(){
        return [
            self::USAGEFOR_ONE => 'Все платные услуги объявлений + пакеты',
            self::USAGEFOR_TWO => 'Все платные услуги магазинов',
            self::USAGEFOR_THRE => 'Конкретная услуга или пакет услуг для объявлений или услуга магазинов'
        ];
    }

    /**
     * Promokod generatsiyasi uchun mahsus funksia
     * @return string
     */
    public function codeGenerate(){
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $result = "";
        while (true){
            for ($i = 0; $i < 4; $i++) {
                $result .= $chars[mt_rand(0, strlen($chars)-1)];
            }
            if(strlen($result) != 19)
                $result .= "-";
            else{
                if(!empty(Promocodes::find()->where(['code' => $result])->asArray()->all())){
                    $result = "";
                    continue;
                }else{
                    break;
                }
            }
        }
        return $result;
    }
}