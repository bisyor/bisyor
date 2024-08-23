<?php

namespace backend\models\shops;

use Yii;

/**
 * This is the model class for table "regional_prices".
 *
 * @property int $id
 * @property int|null $service_id Сервис
 * @property float|null $price Цена
 * @property string|null $regions Выбранные регионы
 * @property string|null $sections Выбранные разделы
 *
 * @property Services $service
 */
class RegionalPrices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regional_prices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price','regions'],'required'],
            [['service_id'], 'default', 'value' => null],
            [['service_id'], 'integer'],
            [['price'], 'number'],
            [['regions', 'sections'], 'safe'],
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
            'service_id' => 'Сервис',
            'price' => 'Цена',
            'regions' => 'Выбранные регионы',
            'sections' => 'Выбранные разделы',
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

    public function beforeSave($insert)
    {
        $this->regions = json_encode($this->regions);
        $this->sections = json_encode($this->sections);
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->regions = json_decode($this->regions);
        $this->sections = json_decode($this->sections);
        return parent::afterFind();
    }
}
