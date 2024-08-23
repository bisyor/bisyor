<?php

namespace backend\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\references\BonusHistory;

/**
 * BonusHistorySearch represents the model behind the search form about `backend\models\references\BonusHistory`.
 */
class BonusHistorySearch extends BonusHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'bonus_id'], 'integer'],
            [['date_cr'], 'safe'],
            [['summa'], 'number'],
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
    public function search($params ,$id)
    {
        $query = BonusHistory::find()
            ->with('bonus')
            ->andWhere(['user_id' => $id]);

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
            'user_id' => $this->user_id,
            'bonus_id' => $this->bonus_id,
            'date_cr' => $this->date_cr,
            'summa' => $this->summa,
        ]);

        return $dataProvider;
    }
}