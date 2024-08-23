<?php

namespace backend\models\items;

use Yii;
use backend\models\users\Users;
/**
 * This is the model class for table "favorites".
 *
 * @property int $id
 * @property int|null $item_id Объявление
 * @property int|null $user_id Пользователья
 * @property float|null $default_price Первоначальная Цена
 * @property float|null $price Текущая цена
 * @property string|null $changed_date Дата изменение цены
 *
 * @property Items $item
 * @property Users $user
 */
class Favorites extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'user_id'], 'default', 'value' => null],
            [['item_id', 'user_id'], 'integer'],
            [['search_text'], 'string'],
            [['default_price', 'price'], 'number'],
            [['changed_date'], 'safe'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Items::className(), 'targetAttribute' => ['item_id' => 'id']],
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
            'item_id' => 'Объявление',
            'user_id' => 'Пользователья',
            'default_price' => 'Первоначальная Цена',
            'price' => 'Текущая цена',
            'changed_date' => 'Дата создания',
            'search_text' => 'Текст',
        ];
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Items::className(), ['id' => 'item_id']);
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
