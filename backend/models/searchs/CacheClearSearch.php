<?php

namespace backend\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\references\CacheClear;

/**
 * CacheClearSearch represents the model behind the search form about `backend\models\references\CacheClear`.
 */
class CacheClearSearch extends CacheClear
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['id', 'minutes'], 'integer'],
//            [['name', 'key'], 'safe'],
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
        $query = CacheClear::find();

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
            'minutes' => $this->minutes,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'key', $this->key]);
        $query->orderBy(['id'=> SORT_DESC]);
        return $dataProvider;
    }
}
