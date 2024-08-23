<?php

namespace backend\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\references\Vacancies;

/**
 * VacanciesSearch represents the model behind the search form about `backend\models\references\Vacancies`.
 */
class VacanciesSearch extends Vacancies
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vacancy_count','category_id','currency_id'], 'integer'],
            [['title','price'], 'safe'],
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
        $query = Vacancies::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder'=>[
                    'id' => SORT_ASC,
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'vacancy_count' => $this->vacancy_count,
            'category_id' => $this->category_id,
            'currency_id' => $this->currency_id,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
