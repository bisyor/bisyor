<?php

namespace backend\models\items;

use Yii;
use backend\models\shops\Services;

/**
 * This is the model class for table "pakets_service".
 *
 * @property int $id
 * @property int|null $service_id Сервис
 * @property int|null $paket_id Пакет
 * @property bool|null $status Статус
 * @property float|null $value Значение
 *
 * @property Services $service
 * @property Services $paket
 */
class PaketsService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pakets_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'paket_id'], 'default', 'value' => null],
            [['value'], 'default', 'value' => 0],
            [['service_id', 'paket_id'], 'integer'],
            [['status'], 'boolean'],
            [['value'], 'number'],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['service_id' => 'id']],
            [['paket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['paket_id' => 'id']],
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
            'paket_id' => 'Пакет',
            'status' => 'Статус',
            'value' => 'Значение',
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
     * Gets query for [[Paket]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaket()
    {
        return $this->hasOne(Services::className(), ['id' => 'paket_id']);
    }
}
