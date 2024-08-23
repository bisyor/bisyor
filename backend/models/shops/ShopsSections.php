<?php

namespace backend\models\shops;

use Yii;

/**
 * This is the model class for table "shops_sections".
 *
 * @property int $id
 * @property int|null $shop_id Магазин
 * @property int|null $section_id Раздел
 *
 * @property ShopCategories $section
 * @property Shops $shop
 */
class ShopsSections extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shops_sections';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shop_id', 'section_id'], 'default', 'value' => null],
            [['shop_id', 'section_id'], 'integer'],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopCategories::className(), 'targetAttribute' => ['section_id' => 'id']],
            [['shop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shops::className(), 'targetAttribute' => ['shop_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => 'Shop ID',
            'section_id' => 'Section ID',
        ];
    }

    /**
     * Gets query for [[Section]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(ShopCategories::className(), ['id' => 'section_id']);
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
}
