<?php

namespace backend\models\shops;

use backend\models\users\Users;
use Yii;

/**
 * This is the model class for table "shops_rating".
 *
 * @property int $id
 * @property float|null $ball Балл
 * @property string|null $date_cr Дата создание
 * @property int|null $shop_id Магазин
 * @property int|null $user_id Пользователь
 *
 * @property Shops $shop
 * @property Users $user
 */
class ShopsRating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shops_rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ball'], 'number'],
            [['date_cr'], 'safe'],
            [['shop_id', 'user_id'], 'default', 'value' => null],
            [['shop_id', 'user_id'], 'integer'],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shops::className(), 'targetAttribute' => ['shop_id' => 'id']],
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
            'ball' => 'Балл',
            'date_cr' => 'Дата создание',
            'shop_id' => 'Магазин',
            'user_id' => 'Пользователь',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
