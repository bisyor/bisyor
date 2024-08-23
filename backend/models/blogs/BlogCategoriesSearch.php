<?php

namespace backend\models\blogs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\blogs\BlogCategories;

/**
 * BlogCategoriesSearch represents the model behind the search form about `backend\models\BlogCategories`.
 */
class BlogCategoriesSearch extends BlogCategories
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sorting'], 'integer'],
            [['name', 'key', 'date_cr'], 'safe'],
            [['enabled'], 'boolean'],
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
        $query = BlogCategories::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sorting' => $this->sorting,
            'date_cr' => $this->date_cr,
            'enabled' => $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'key', $this->key]);

        return $dataProvider;
    }
}
