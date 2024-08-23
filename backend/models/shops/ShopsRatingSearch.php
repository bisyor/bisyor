<?php

namespace backend\models\shops;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ShopsRatingSearch represents the model behind the search form about `backend\models\shops\ShopsRating`.
 */
class ShopsRatingSearch extends ShopsRating
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'shop_id', 'user_id'], 'integer'],
            [['ball'], 'number'],
            [['date_cr'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params, $id = null)
    {
        $query = ShopsRating::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'ball' => $this->ball,
            'date_cr' => $this->date_cr,
            'shop_id' => $id,
            'user_id' => $this->user_id,
        ]);

        return $dataProvider;
    }
}
