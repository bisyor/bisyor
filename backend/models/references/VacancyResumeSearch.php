<?php

namespace backend\models\references;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\references\VacancyResume;

/**
 * VacancyResumeSearch represents the model behind the search form of `backend\models\references\VacancyResume`.
 */
class VacancyResumeSearch extends VacancyResume
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'vacancy_id'], 'integer'],
            [['name', 'phone', 'file', 'description'], 'safe'],
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
    public function search($params)
    {
        $query = VacancyResume::find();

        // add conditions that should always apply here

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
            'vacancy_id' => $this->vacancy_id,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'file', $this->file])
            ->andFilterWhere(['ilike', 'description', $this->description]);

        return $dataProvider;
    }
}
