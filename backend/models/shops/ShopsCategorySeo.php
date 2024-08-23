<?php

namespace backend\models\shops;

use Yii;

/**
 * This is the model class for table "shops_category_seo".
 *
 * @property int $id
 * @property string|null $title Заголовок
 * @property string|null $keywords Ключевые слова
 * @property string|null $description Описание
 * @property string|null $breadcumb Хлебная крошка
 * @property string|null $h1_title Заголовок H1
 * @property string|null $seo_text SEO текст
 * @property int|null $category_id Категория
 *
 * @property ShopCategories $category
 */
class ShopsCategorySeo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shops_category_seo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keywords'],'required'],
            [['keywords', 'description', 'seo_text'], 'string'],
            [['category_id'], 'default', 'value' => null],
            [['category_id'], 'integer'],
            [['title', 'breadcumb', 'h1_title'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopCategories::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'keywords' => 'Ключевые слова',
            'description' => 'Описание',
            'breadcumb' => 'Хлебная крошка',
            'h1_title' => 'Заголовок H1',
            'seo_text' => 'SEO текст',
            'category_id' => 'Категория',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ShopCategories::className(), ['id' => 'category_id']);
    }
}
