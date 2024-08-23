<?php

namespace backend\models\blogs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\blogs\BlogPosts;

/**
 * BlogPostsSearch represents the model behind the search form about `backend\models\BlogPosts`.
 */
class BlogPostsSearch extends BlogPosts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'blog_categories_id', 'status', 'view_count', 'user_id'], 'integer'],
            [['title', 'slug', 'image', 'short_text', 'text', 'date_cr'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BlogPosts::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'blog_categories_id' => $this->blog_categories_id,
            'status' => $this->status,
            'date_cr' => $this->date_cr,
            'view_count' => $this->view_count,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'short_text', $this->short_text])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
