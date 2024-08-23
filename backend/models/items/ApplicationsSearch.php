<?php

namespace backend\models\items;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\items\Applications;

/**
 * ApplicationsSearch represents the model behind the search form of `backend\models\items\Applications`.
 */
class ApplicationsSearch extends Applications
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['phone', 'item_id', 'fullname', 'address','created_at'], 'safe'],
        ];
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params ,$status)
    {
        $query = Applications::find()
            ->andWhere(['applications.status' => $status])
            ->andWhere(['is_delete' => null])
            ->with('item')
            ->joinWith('item');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder'=>[
                    'created_at' => SORT_DESC,
                ]
            ],
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
            'applications.status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'applications.phone', $this->phone])
            ->andFilterWhere(['ilike', 'fullname', $this->fullname])
            ->andFilterWhere(['ilike', 'items.title', $this->item_id])
            ->andFilterWhere(['ilike', 'applications.address', $this->address]);

        return $dataProvider;
    }
}
