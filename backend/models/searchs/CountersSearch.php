<?php

namespace backend\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\references\Counters;

/**
 * CountersSearch represents the model behind the search form about `backend\models\references\Counters`.
 */
class CountersSearch extends Counters
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'code_position', 'num'], 'integer'],
            [['title', 'code', 'enabled', 'date_cr'], 'safe'],
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
        $query = Counters::find();

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
            'code_position' => $this->code_position,
            'date_cr' => $this->date_cr,
            'num' => $this->num,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'enabled', $this->enabled]);

        return $dataProvider;
    }
}