<?php

namespace backend\models\blogs;

use Yii;
use backend\models\references\Translates;

/**
 * This is the model class for table "blog_tags".
 *
 * @property int $id
 * @property string|null $name Наименование
 *
 * @property BlogPostTags[] $blogPostTags
 */
class BlogTags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    public $translation_name;

    public static function tableName()
    {
        return 'blog_tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['translation_name'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
        ];
    }

    public static function NeedTranslation()
    {
        return [
            'name'=>'translation_name',
        ];
    }

    /**
     * Gets query for [[BlogPostTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPostTags()
    {
        return $this->hasMany(BlogPostTags::className(), ['tag_id' => 'id']);
    }


    /**
     * blogni ohirganda unga tegishli taglarni o'chirish
     * @param $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function deleteFromPost($id)
    {
        $blogPostTags = BlogPostTags::find()->where(['tag_id' => $id])->all();
        foreach ($blogPostTags as $value) {
            $value->delete();
        }

        $translations = Translates::find()->where(['table_name' => self::tableName(), 'field_id' => $id])->all();
        foreach ($translations as $value) {
            $value->delete();
        }
    }
}
