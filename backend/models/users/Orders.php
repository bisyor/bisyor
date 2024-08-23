<?php

namespace backend\models\users;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string|null $created_date Дата создание
 * @property int|null $user_id Пользователь
 * @property float|null $user_balance Баланс пользователя
 * @property float|null $amount Сумма
 * @property int|null $state Статус
 * @property int|null $change_state Дата изменение статуса
 * @property string|null $description Описание
 * @property int|null $type Тип
 *
 * @property Users $user
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_date'], 'safe'],
            [['user_id', 'state', 'change_state', 'type'], 'default', 'value' => null],
            [['user_id', 'state', 'change_state', 'type'], 'integer'],
            [['user_balance', 'amount'], 'number'],
            [['description'], 'string'],
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
            'created_date' => 'Дата создание',
            'user_id' => 'Пользователь',
            'user_balance' => 'Баланс пользователя',
            'amount' => 'Сумма',
            'state' => 'Статус',
            'change_state' => 'Дата изменение статуса',
            'description' => 'Описание',
            'type' => 'Тип',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function beforSave($insert){
        if ($this->isNewRecord) {
            $this->created_date = date("Y-m-d H:i");
        }
    }
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
    public function getType(){
        switch ($this->type) {
            case 1: return "Пополнение счета";
                break;
            case 2: return "Покупка услуг";
                break;
            
        }
    }
    public function State(){
        switch ($this->state) {
            case 1: return "Создано";
            case 2: return "В ожидании";
            case 3: return "Оплачено";
            case 4: return "Отменено";
        }
    }
    public function getStateList()
    {
        return [
            1 => 'Создано',
            2 => 'В ожидании',
            3 => 'Оплачено',
            4 => 'Отменено',
        ];
    }
}
