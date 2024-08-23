<?php

namespace backend\models\shops;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\shops\ShopCategories;

/**
 * ShopCategoriesSearch represents the model behind the search form about `backend\models\shops\ShopCategories`.
 */
class ShopCategoriesSearch extends ShopCategories
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sorting', 'parent_id'], 'integer'],
            [['title', 'keyword', 'icon_b', 'icon_s', 'enabled', 'date_cr'], 'safe'],
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
        $query = ShopCategories::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sorting' => $this->sorting,
            'parent_id' => $this->parent_id,
            'date_cr' => $this->date_cr,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'keyword', $this->keyword])
            ->andFilterWhere(['like', 'icon_b', $this->icon_b])
            ->andFilterWhere(['like', 'icon_s', $this->icon_s])
            ->andFilterWhere(['like', 'enabled', $this->enabled]);

        return $dataProvider;
    }
}
