<?php

namespace backend\models\items;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\items\ItemsClaim;

/**
 * ItemsClaimSearch represents the model behind the search form about `backend\models\items\ItemsClaim`.
 */
class ItemsClaimSearch extends ItemsClaim
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'reason'], 'integer'],
            [['user_ip','user_id', 'item_id', 'message', 'date_cr'], 'safe'],
            [['viewed'], 'boolean'],
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
    public function search($params,$item_id = null)
    {
        $query = ItemsClaim::find()->orderBy(['date_cr'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->joinWith('user');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $item = ($item_id == null) ? $this->item_id : $item_id;
        $query->andFilterWhere([
            'id' => $this->id,
            'items_claim.reason' => $this->reason,
            'items_claim.viewed' => $this->viewed,
            'items_claim.date_cr' => $this->date_cr,
        ]);

        $query->andFilterWhere(['like', 'items_claim.user_ip', $this->user_ip])
            ->andFilterWhere(['ilike', 'users.fio', $this->user_id])
            ->andFilterWhere(['items_claim.item_id' => $item])
            ->andFilterWhere(['like', 'items_claim.message', $this->message]);

        return $dataProvider;
    }

    public function searchActive($params,$item_id = null)
    {
        $query = ItemsClaim::find()->orderBy(['date_cr'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->joinWith('user');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $item = ($item_id == null) ? $this->item_id : $item_id;
        $query->andFilterWhere([
            'id' => $this->id,
            'items_claim.reason' => $this->reason,
            'items_claim.viewed' => false,
            'items_claim.date_cr' => $this->date_cr,
        ]);

        $query->andFilterWhere(['like', 'items_claim.user_ip', $this->user_ip])
            ->andFilterWhere(['ilike', 'users.fio', $this->user_id])
            ->andFilterWhere(['items_claim.item_id' => $item])
            ->andFilterWhere(['like', 'items_claim.message', $this->message]);

        return $dataProvider;
    }
}
