<?php

namespace backend\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\references\Currencies;

/**
 * CurrenciesSearch represents the model behind the search form about `backend\models\references\Currencies`.
 */
class CurrenciesSearch extends Currencies
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sorting'], 'integer'],
            [['code', 'short_name', 'name'], 'safe'],
            [['rate'], 'number'],
            [['enabled', 'default'], 'boolean'],
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
        $query = Currencies::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['sorting'=>SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'rate' => $this->rate,
            'sorting' => $this->sorting,
            'enabled' => $this->enabled,
            'default' => $this->default,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'short_name', $this->short_name])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
