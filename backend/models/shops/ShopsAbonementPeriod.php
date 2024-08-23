<?php

namespace backend\models\shops;

use Yii;

/**
 * This is the model class for table "shops_abonement_period".
 *
 * @property int $id
 * @property int|null $abonement_id Абонемент
 * @property int|null $month Кол-во Месяцов
 * @property float|null $price_for_month Цена в месяц
 * @property float|null $total_price Стоимость
 *
 * @property ShopsAbonements $abonement
 */
class ShopsAbonementPeriod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shops_abonement_period';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price_for_month','month','total_price'],'required'],
            [['abonement_id', 'month'], 'integer'],
            [['price_for_month', 'total_price'], 'number'],
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
            'month' => 'Кол-во Месяцов',
            'price_for_month' => 'Цена в месяц',
            'total_price' => 'Стоимость',
        ];
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
}
