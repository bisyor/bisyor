<?php

namespace backend\models\shops;

use Yii;

/**
 * This is the model class for table "shops_tariff".
 *
 * @property int $id
 * @property int|null $abonement_id Абонемент
 * @property int|null $shop_id Магазин
 * @property string|null $date_cr Дата создание
 * @property int|null $status 1 - Активно, 2 - Не активно
 * @property string|null $data_access Cрок действия
 * @property float|null $price Общая стоимость
 *
 * @property Shops $shop
 * @property ShopsAbonements $abonement
 */
class ShopsTariff extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shops_tariff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['abonement_id', 'shop_id', 'status'], 'default', 'value' => null],
            [['abonement_id', 'shop_id', 'status'], 'integer'],
            [['date_cr', 'data_access'], 'safe'],
            [['price'], 'number'],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shops::className(), 'targetAttribute' => ['shop_id' => 'id']],
            [['abonement_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopsAbonements::className(), 'targetAttribute' => ['abonement_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'abonement_id' => 'Абонемент',
            'shop_id' => 'Магазин',
            'date_cr' => 'Дата создание',
            'status' => 'Статус',
            'data_access' => 'Cрок действия',
            'price' => 'Общая стоимость',
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
     * Gets query for [[Abonement]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAbonement()
    {
        return $this->hasOne(ShopsAbonements::className(), ['id' => 'abonement_id']);
    }


    /**
     * status nomi
     * @return string
     */
    public function getStatusName()
    {
        switch ($this->status) {
            case self::STATUS_ACTIVE:return '<span class="label label-success"> Активно </span>';
            case self::STATUS_INACTIVE:return '<span class="label label-danger"> Не активно </span>';
        }
    }


    /**
     * status turlari
     * @return string[]
     */
    public static function getStatusType()
    {
       return [
            self::STATUS_ACTIVE => 'Активно',
            self::STATUS_INACTIVE => 'Не активно',
        ];
    }


    /**
     * @param $date
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getDate($date)
    {
        if($date){
            return Yii::$app->formatter->asDate($date,'php: H:i d.m.Y');
        }
    }

}
