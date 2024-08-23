<?php

namespace backend\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\users\Orders;

/**
 * OrdersSearch represents the model behind the search form about `backend\models\users\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'state', 'change_state', 'type'], 'integer'],
            [['created_date', 'description'], 'safe'],
            [['user_balance', 'amount'], 'number'],
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
        $query = Orders::find()->where(['user_id' => $params['id']]);

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
            'created_date' => ($this->created_date) ? date("Y-m-d H:i", strtotime($this->created_date)) : $this->created_date,
            'user_id' => $this->user_id,
            'user_balance' => $this->user_balance,
            'amount' => $this->amount,
            'state' => $this->state,
            'change_state' => $this->change_state,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
