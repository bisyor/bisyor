<?php

namespace backend\models\items;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\items\Favorites;

/**
 * FavoritesSearch represents the model behind the search form of `backend\models\items\Favorites`.
 */
class FavoritesSearch extends Favorites
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'item_id', 'user_id'], 'integer'],
            [['default_price', 'price'], 'number'],
            [['changed_date'], 'safe'],
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
    public function search($params ,$id)
    {
        $query = Favorites::find()->where(['type' =>4 ,'user_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'item_id' => $this->item_id,
            'user_id' => $this->user_id,
            'default_price' => $this->default_price,
            'price' => $this->price,
            'changed_date' => $this->changed_date,
        ]);

        return $dataProvider;
    }
}
