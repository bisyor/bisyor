<?php

namespace backend\models\shops;

use Yii;

/**
 * This is the model class for table "tariff_service_discount".
 *
 * @property int $id
 * @property int|null $abonoment_id Абонемент
 * @property int|null $service_id Сервис
 * @property float|null $percent Скидка
 *
 * @property Services $service
 * @property ShopsAbonements $abonoment
 */
class TariffServiceDiscount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tariff_service_discount';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['abonoment_id', 'service_id'], 'default', 'value' => null],
            [['abonoment_id', 'service_id'], 'integer'],
            [['percent'], 'number'],
            [['percent'],'required'],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['service_id' => 'id']],
            [['abonoment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopsAbonements::className(), 'targetAttribute' => ['abonoment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'abonoment_id' => 'Абонемент',
            'service_id' => 'Сервис',
            'percent' => 'Скидка',
        ];
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
     * Gets query for [[Abonoment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAbonoment()
    {
        return $this->hasOne(ShopsAbonements::className(), ['id' => 'abonoment_id']);
    }
}
