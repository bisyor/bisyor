<?php

namespace backend\models\promocodes;
use backend\models\shops\Shops;
use backend\models\users\Users;
use backend\models\items\Categories;
use backend\models\items\Items;
use Yii;

/**
 * This is the model class for table "promocodes_usage".
 *
 * @property int $id
 * @property int|null $promocode_id Промокоды
 * @property int|null $user_id Пользователь
 * @property int|null $category_id Категория
 * @property int|null $category_root_id
 * @property int|null $item_id Объявление
 * @property int|null $shop_id Магазин
 * @property string|null $shop_categories Категория магазина 
 * @property bool|null $is_active Актино или нет
 * @property bool|null $success Статус
 * @property string|null $used_at Использован
 *
 * @property Categories $category
 * @property Promocodes $promocode
 * @property Users $user
 */
class PromocodesUsage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    /**
     * Contanta for succes lists
     */
    const SUCCESS_FALSE = 0;
    const SUCCESS_TRUE = 1;

    public static function tableName()
    {
        return 'promocodes_usage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['promocode_id', 'user_id', 'category_id', 'category_root_id', 'item_id', 'shop_id'], 'default', 'value' => null],
            [['promocode_id', 'user_id', 'category_id', 'category_root_id', 'item_id', 'shop_id'], 'integer'],
            [['shop_categories'], 'string'],
            [['is_active', 'success'], 'boolean'],
            [['used_at'], 'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Items::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['promocode_id'], 'exist', 'skipOnError' => true, 'targetClass' => Promocodes::className(), 'targetAttribute' => ['promocode_id' => 'id']],
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
            'promocode_id' => 'Промокоды',
            'user_id' => 'Пользователь',
            'category_id' => 'Категория',
            'category_root_id' => 'Категория',
            'item_id' => 'Объявление',
            'shop_id' => 'Магазин',
            'shop_categories' => 'Категория магазина',
            'is_active' => 'Актино или нет',
            'success' => 'Статус',
            'used_at' => 'Использован',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
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
     * Gets query for [[Shop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shops::className(), ['id' => 'shop_id']);
    }


    /**
     * Gets query for [[Promocode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPromocode()
    {
        return $this->hasOne(Promocodes::className(), ['id' => 'promocode_id']);
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


    /**
     * @return string[]
     */
    public static function getSuccess(){
        return [
            self::SUCCESS_FALSE => 'Не успешно',
            self::SUCCESS_TRUE => 'Успешно'
        ];
    }
}