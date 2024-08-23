<?php

namespace backend\models\promocodes;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PromocodesSearch represents the model behind the search form about `backend\models\promocodes\Promocodes`.
 */
class PromocodesSearch extends Promocodes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'amount', 'usage_by', 'discount_type', 'discount', 'usage_for', 'usage_limit', 'used', 'service_id'], 'integer'],
            [['code', 'title', 'category_list', 'regions_list', 'active_to', 'created_at', 'active_from'], 'safe'],
            [['active', 'is_once', 'break_days'], 'boolean'],
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
    public function search($params, $type = 'all')
    {
        /**
         * Uchta hol uchun search qaytaradi Aktiva vse hamda Neaktiv uchun
         */
        switch ($type){
            case 'active' : $query = Promocodes::find()->where(['active' => 1]); break;
            case 'deactive' : $query = Promocodes::find()->where(['active' => 0]); break;
            default: $query = Promocodes::find(); break;;
        }

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
            'type' => $this->type,
            'amount' => $this->amount,
            'usage_by' => $this->usage_by,
            'discount_type' => $this->discount_type,
            'discount' => $this->discount,
            'usage_for' => $this->usage_for,
            'active' => $this->active,
            'active_to' => ($this->active_to) ? date("Y-m-d H:i", strtotime($this->active_to)) : $this->active_to,
            'usage_limit' => $this->usage_limit,
            'is_once' => $this->is_once,
            'break_days' => $this->break_days,
            'used' => $this->used,
            'created_at' => $this->created_at,
            'active_from' => ($this->active_from) ? date("Y-m-d H:i", strtotime($this->active_from)) : $this->active_from,
            'service_id' => $this->service_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'category_list', $this->category_list])
            ->andFilterWhere(['like', 'regions_list', $this->regions_list]);

        return $dataProvider;
    }
}