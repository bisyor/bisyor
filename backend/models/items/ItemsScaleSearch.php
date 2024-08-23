<?php

namespace backend\models\items;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\items\ItemsScale;

/**
 * ItemsScaleSearch represents the model behind the search form about `backend\models\items\ItemsScale`.
 */
class ItemsScaleSearch extends ItemsScale
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'description', 'key', 'minimum_value'], 'safe'],
            [['ball'], 'number'],
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
        $query = ItemsScale::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder'=>[
                    'id' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'ball' => $this->ball,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'minimum_value', $this->minimum_value]);

        return $dataProvider;
    }
}
