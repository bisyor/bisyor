<?php

namespace backend\models\users;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UsersBanListSearch represents the model behind the search form about `backend\models\users\UsersBanlist`.
 */
class UsersBanListSearch extends UsersBanlist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'selected'], 'integer'],
            [['ip_list', 'date_cr', 'finished', 'description', 'reason'], 'safe'],
            [['exclude', 'status'], 'boolean'],
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
        $query = UsersBanlist::find();

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
            'date_cr' => $this->date_cr,
            'finished' => $this->finished,
            'type' => $this->type,
            'selected' => $this->selected,
            'exclude' => $this->exclude,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'ip_list', $this->ip_list])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
