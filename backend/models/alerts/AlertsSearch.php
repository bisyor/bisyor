<?php

namespace backend\models\alerts;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\alerts\Alerts;

/**
 * AlertsSearch represents the model behind the search form of `backend\models\alerts\Alerts`.
 */
class AlertsSearch extends Alerts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['email', 'sms'], 'boolean'],
            [['title', 'text', 'key', 'key_title', 'key_text', 'type', 'subscription'], 'safe'],
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
    public function search($params,$type)
    {
        $query = Alerts::find()->orderBy(['id' => SORT_ASC]);

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
            'email' => $this->email,
            'sms' => $this->sms,
            'type' => $type
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'text', $this->text])
            ->andFilterWhere(['ilike', 'key', $this->key])
            ->andFilterWhere(['ilike', 'key_title', $this->key_title])
            ->andFilterWhere(['ilike', 'key_text', $this->key_text])
            ->andFilterWhere(['ilike', 'subscription', $this->subscription]);

        return $dataProvider;
    }
}
