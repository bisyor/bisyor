<?php

namespace backend\models\blogs;

use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "blog_post_tags".
 *
 * @property int $id
 * @property int|null $blog_posts_id Блог
 * @property int|null $tag_id Тег
 *
 * @property BlogPosts $blogPosts
 * @property BlogTags $tag
 */
class BlogPostTags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog_post_tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blog_posts_id', 'tag_id'], 'default', 'value' => null],
            [['blog_posts_id', 'tag_id'], 'integer'],
            [['tag_id'], 'required'],
            [['blog_posts_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogPosts::className(), 'targetAttribute' => ['blog_posts_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogTags::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'blog_posts_id' => 'Блог',
            'tag_id' => 'Тег',
        ];
    }

    /**
     * Gets query for [[BlogPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogPosts()
    {
        return $this->hasOne(BlogPosts::className(), ['id' => 'blog_posts_id']);
    }

    /**
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(BlogTags::className(), ['id' => 'tag_id']);
    }

    public function getTagsList()
    {
        $tags = BlogTags::find()->all();
        return ArrayHelper::map($tags, 'id', 'name');
    }

    public function search($params, $id)
    {
        $query = BlogPostTags::find()->where(['blog_posts_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'blog_posts_id' => $this->blog_posts_id,
            'tag_id' => $this->tag_id,
        ]);

        return $dataProvider;
    }

}
