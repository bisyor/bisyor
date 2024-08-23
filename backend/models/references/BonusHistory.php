<?php

namespace backend\models\references;

use backend\models\users\Users;
use Yii;

/**
 * This is the model class for table "bonus_history".
 *
 * @property int $id
 * @property int|null $user_id Пользователи
 * @property int|null $bonus_id Бонусы
 * @property string|null $date_cr Дата создания
 * @property float|null $summa Сумма
 *
 * @property BonusList $bonus
 * @property Users $user
 */
class BonusHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bonus_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'bonus_id'], 'default', 'value' => null],
            [['user_id', 'bonus_id'], 'integer'],
            [['date_cr'], 'safe'],
            [['summa'], 'number'],
            [['bonus_id'], 'exist', 'skipOnError' => true, 'targetClass' => BonusList::className(), 'targetAttribute' => ['bonus_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователи',
            'bonus_id' => 'Бонусы',
            'date_cr' => 'Дата создания',
            'summa' => 'Сумма',
        ];
    }

    /**
     * Gets query for [[Bonus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBonus()
    {
        return $this->hasOne(BonusList::className(), ['id' => 'bonus_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
