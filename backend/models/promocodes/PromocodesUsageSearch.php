<?php

namespace backend\models\promocodes;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PromocodesUsageSearch represents the model behind the search form about `backend\models\promocodes\PromocodesUsage`.
 */
class PromocodesUsageSearch extends PromocodesUsage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'category_root_id', 'item_id', 'shop_id'], 'integer'],
            [['shop_categories', 'used_at'], 'safe'],
            [['is_active', 'success'], 'boolean'],
            [['user_id', 'promocode_id'], 'string', 'max' => 255]
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
    public function search($params, $type = 0, $code = null)
    {
        $query = PromocodesUsage::find()->joinWith(['user', 'promocode', 'category'])
                                    ->orderBy(['id' => SORT_DESC]);
        /**
         * Agar promocod bo'sh bo'lsa default 3 ta listni qaytaradi.
         * Agar bironta promocodning idsi kelib qolsa qidirish shu id bo'yicha bo'ladi
         */
        if($code == null){
            switch ($type){
                case '1':
                    $query->andFilterWhere(['promocodes.type' => 1]);
                    break;
                case '2':
                    $query->andFilterWhere(['promocodes.type' => 2]);
                    break;
                default:
                    break;
            }
        }else{
            switch ($type){
                case '1':
                    $query->andFilterWhere(['promocodes.type' => 1, 'promocode_id' => $code]);
                    break;
                case '2':
                    $query->andFilterWhere(['promocodes.type' => 2, 'promocode_id' => $code]);
                    break;
                default:
                    $query->andFilterWhere(['promocode_id' => $code]);
                    break;
            }
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
            'category_id' => $this->category_id,
            'category_root_id' => $this->category_root_id,
            'item_id' => $this->item_id,
            'shop_id' => $this->shop_id,
            'is_active' => $this->is_active,
            'success' => $this->success,
            'used_at' => ($this->used_at) ? date("Y-m-d", strtotime($this->used_at)) : $this->used_at,
        ]);

        $query->andFilterWhere(['like', 'shop_categories', $this->shop_categories])
            ->andFilterWhere(['like', 'users.email', $this->user_id])
            ->orFilterWhere(['like', 'users.phone', $this->user_id])
            ->andFilterWhere(['like', 'promocodes.code', $this->promocode_id]);

        return $dataProvider;
    }
}