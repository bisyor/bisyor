<?php

namespace backend\models\blogs;

use Yii;
use backend\models\users\Users;
use yii\data\ActiveDataProvider;


/**
 * This is the model class for table "blogs_posts_likes".
 *
 * @property int $id
 * @property int|null $blog_posts_id Блог
 * @property int|null $type Тип
 * @property int|null $user_id Пользователь
 *
 * @property BlogPosts $blogPosts
 * @property Users $user
 */
class BlogsPostsLikes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const POSITIVELY = 1;
    const NEGATIVELY = 2;
    public static function tableName()
    {
        return 'blogs_posts_likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blog_posts_id', 'type', 'user_id'], 'default', 'value' => null],
            [['blog_posts_id', 'type', 'user_id'], 'integer'],
            [['blog_posts_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlogPosts::className(), 'targetAttribute' => ['blog_posts_id' => 'id']],
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
            'blog_posts_id' => 'Блог',
            'type' => 'Тип',
            'user_id' => 'Пользователь',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getStatusname()
    {
        if($this->type == self::POSITIVELY) return 'Положительно';
        else return 'Отрицательно';
    }

    public static function getStatusList()
    {
        return [
            self::POSITIVELY => 'Положительно',
            self::NEGATIVELY => 'Отрицательно'
        ];
    }

    public function search($params, $id)
    {
        $query = BlogsPostsLikes::find()->where(['blog_posts_id' => $id]);

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
            'type' => $this->type,
            'user_id' => $this->user_id,
        ]);

        return $dataProvider;
    }
}
