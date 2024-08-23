<?php

namespace backend\models\references;

use Yii;

/**
 * This is the model class for table "transactions".
 *
 * @property int $id
 * @property string|null $paycom_transaction_id
 * @property string|null $param_id
 * @property int|null $order_id
 * @property string|null $paycom_time
 * @property string|null $paycom_time_datetime
 * @property string|null $create_time
 * @property string|null $perform_time
 * @property string|null $cancel_time
 * @property int|null $amount
 * @property int|null $state
 * @property int|null $reason
 * @property string|null $receivers
 */
class Transactions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'amount', 'state', 'reason'], 'integer'],
            [['paycom_time_datetime', 'create_time'], 'safe'],
            [['paycom_transaction_id', 'param_id', 'paycom_time', 'perform_time', 'cancel_time', 'receivers'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'paycom_transaction_id' => Yii::t('app', 'Paycom Transaction ID'),
            'param_id' => Yii::t('app', 'Param ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'paycom_time' => Yii::t('app', 'Paycom Time'),
            'paycom_time_datetime' => Yii::t('app', 'Paycom Time Datetime'),
            'create_time' => Yii::t('app', 'Create Time'),
            'perform_time' => Yii::t('app', 'Perform Time'),
            'cancel_time' => Yii::t('app', 'Cancel Time'),
            'amount' => Yii::t('app', 'Amount'),
            'state' => Yii::t('app', 'State'),
            'reason' => Yii::t('app', 'Reason'),
            'receivers' => Yii::t('app', 'Receivers'),
        ];
    }
}
