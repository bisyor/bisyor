<?php

namespace backend\models\users;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserHistorySearch represents the model behind the search form about `backend\models\UserHistory`.
 */
class UserHistorySearch extends UserHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'type','from_device'], 'integer'],
            [['date_cr', 'title', 'value'], 'safe'],
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
    public function search($params, $id)
    {
        $query = UserHistory::find()->where(['user_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder'=>[
                    'id' => SORT_DESC,
                ]
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
            'user_id' => $this->user_id,
            'date_cr' => $this->date_cr,
            'type' => $this->type,
            'from_device' => $this->from_device,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
