<?php

namespace backend\models\shops;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ShopsSubscribersSearch represents the model behind the search form about `backend\models\shops\ShopsSubscribers`.
 */
class ShopsSubscribersSearch extends ShopsSubscribers
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'shop_id', 'user_id'], 'integer'],
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
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $id = null)
    {
        $query = ShopsSubscribers::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date_cr' => $this->date_cr,
            'user_id' => $this->user_id,
            'shop_id' => $id,
        ]);

        return $dataProvider;
    }
}
