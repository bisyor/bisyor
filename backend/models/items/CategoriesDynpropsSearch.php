<?php

namespace backend\models\items;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\items\CategoriesDynprops;

/**
 * CategoriesDynpropsClaimSearch represents the model behind the search form of `backend\models\items\CategoriesDynprops`.
 */
class CategoriesDynpropsSearch extends CategoriesDynprops
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'type', 'is_cache', 'parent', 'parent_value', 'data_field', 'num','published_telegram'], 'integer'],
            [['title', 'description', 'default_value', 'cache_key', 'extra'], 'safe'],
            [['enabled', 'req', 'in_search', 'in_seek', 'num_first', 'txt', 'in_table', 'search_hidden'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function search($params,$category_id)
    {
        $query = CategoriesDynprops::find()->orderBy(['id' => SORT_ASC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $categories = \backend\models\items\Categories::getParents($category_id);
        $query->with('category');
        $query->joinWith('category');

        $query->orderBy(['categories.numlevel' => SORT_ASC, 'categories_dynprops.id' => SORT_ASC]);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'categories_dynprops.id' => $this->id,
            'categories_dynprops.category_id' => $categories,
            'categories_dynprops.type' => $this->type,
            'categories_dynprops.enabled' => $this->enabled,
            'categories_dynprops.req' => $this->req,
            'categories_dynprops.in_search' => $this->in_search,
            'categories_dynprops.in_seek' => $this->in_seek,
            'categories_dynprops.num_first' => $this->num_first,
            'categories_dynprops.is_cache' => $this->is_cache,
            'categories_dynprops.parent' => $this->parent,
            'categories_dynprops.parent_value' => $this->parent_value,
            'categories_dynprops.data_field' => $this->data_field,
            'categories_dynprops.num' => $this->num,
            'categories_dynprops.txt' => $this->txt,
            'categories_dynprops.in_table' => $this->in_table,
            'categories_dynprops.search_hidden' => $this->search_hidden,
        ]);

        $query->andFilterWhere(['ilike', 'categories_dynprops.title', $this->title])
            ->andFilterWhere(['ilike', 'categories_dynprops.description', $this->description])
            ->andFilterWhere(['ilike', 'categories_dynprops.default_value', $this->default_value])
            ->andFilterWhere(['ilike', 'categories_dynprops.cache_key', $this->cache_key])
            ->andFilterWhere(['ilike', 'categories_dynprops.extra', $this->extra]);

        return $dataProvider;
    }
}
