<?php

namespace backend\models\bills;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BillsSearch represents the model behind the search form about `backend\models\bills\Bills`.
 */
class BillsSearch extends Bills
{
    /**
     * @inheritdoc
     */
    public $reg_from;
    public $reg_to;
    public $user_count;
    public $user_phone;

    public function rules(): array
    {
        return [
            [['id', 'service_id', 'item_id', 'type', 'psystem', 'currency_id', 'status', 'promocode_id','user_count'], 'integer'],
            [['user_balance', 'amount', 'money'], 'number'],
            ['user_id', 'integer'],
            [['svc_activate'], 'boolean'],
            [['svc_settings', 'date_cr', 'date_pay', 'description', 'details', 'ip', 'reg_from', 'reg_to','user_phone'], 'safe'],
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
     * @param array $params
     * @param string $type
     * @return ActiveDataProvider
     */
    public function search($params, $type)
    {
        $query = Bills::find()->joinWith(['user'])->orderBy(['id' => SORT_DESC])->andFilterWhere(['bills.status' => $type]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder'=>[
                    'date_cr' => SORT_DESC,
                ]
            ]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'bills.id' => $this->id,
            'bills.service_id' => $this->service_id,
            'bills.type' => $this->type,
            'bills.item_id' => $this->item_id,
            'bills.psystem' => $this->psystem,
        ]);

        if (!empty($this->reg_from) && !empty($this->reg_to)) {
            $start_reg = date("Y-m-d", strtotime($this->reg_from));
            $end_reg = date("Y-m-d", strtotime("+1 day", strtotime($this->reg_to)));
            $query->andFilterWhere(['>=', 'date_cr', $start_reg])->andFilterWhere(['<', 'date_cr', $end_reg]);
        }

        if($this->user_phone){
            $query->andFilterWhere([
                'or',
                [ 'like','users.phone', $this->user_phone],
                [ 'like','users.email', $this->user_phone],
            ]);
        }



        return $dataProvider;
    }

    public function searchByUser($params, $user_id)
    {
        $query = Bills::find()->joinWith(['user'])->orderBy(['id' => SORT_DESC])->andFilterWhere(['bills.user_id' => $user_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'bills.id' => $this->id,
            'bills.service_id' => $this->service_id,
            'bills.type' => $this->type,
            'bills.item_id' => $this->item_id,
        ]);

        // $query->andFilterWhere(['like', 'users.email', $this->user_id,]);
        $query->andFilterWhere([
            'or',
            ['like', 'users.email', $this->user_id],
            ['like', 'users.phone', $this->user_id]
        ]);
        if (!empty($this->reg_from) && !empty($this->reg_to)) {
            $start_reg = date("Y-m-d", strtotime($this->reg_from));
            $end_reg = date("Y-m-d", strtotime("+1 day", strtotime($this->reg_to)));
            $query->andFilterWhere(['>=', 'date_cr', $start_reg])->andFilterWhere(['<', 'date_cr', $end_reg]);
        }

        return $dataProvider;
    }

    /**
     * @param string $type
     * @param $post
     * @return ActiveDataProvider
     */
    public function searchFilter($type, $post)
    {
        $query = Bills::find()->joinWith(['user'])->orderBy(['id' => SORT_DESC]);
        $query->andFilterWhere(['bills.status' => $type]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->andFilterWhere([
            'bills.id' => $post['id'],
            'bills.service_id' => $post['service'],
            'bills.type' => $post['type'],
            'bills.item_id' => $post['item_id']
        ]);

        $query->andFilterWhere(['like', 'users.email', $post['user']]);
        if (!empty($post['reg_from']) && !empty($post['reg_to'])) {
            $start_reg = date("Y-m-d", strtotime($post['reg_from']));
            $end_reg = date("Y-m-d", strtotime("+1 day", strtotime($post['reg_to'])));
            $query->andFilterWhere(['>=', 'date_cr', $start_reg])->andFilterWhere(['<', 'date_cr', $end_reg]);
        }

        return $dataProvider;
    }

    public function topUserBills($params,$post)
    {
        $query = Bills::find()
            ->select([
                'users.balance',
                'user_id as id',
                'user_id',
                'SUM(CASE WHEN psystem = 145 THEN amount ELSE 0 END) as payme_summa',
                'SUM(CASE WHEN psystem = 146 THEN amount ELSE 0 END) as click_summa',
                'SUM(CASE WHEN psystem = 147 THEN amount ELSE 0 END) as paynet_summa',
                'SUM(amount) as totalSumma'
            ])
            ->innerJoin('users','users.id=bills.user_id')
            ->with(['user'])
            ->andWhere(['bills.status' => 2])
            ->andWhere(['bills.type' => 1])
            ->andWhere(['not' ,['bills.user_id' => null]])
            ->groupBy(['user_id','users.balance'])
            ->orderBy(['totalSumma' => SORT_DESC]);
        $this->user_count = 30;
        if(isset($post['BillsSearch'])){
            if($post['BillsSearch']['user_count'] != null)  $this->user_count = $post['BillsSearch']['user_count'];
            if (($post['BillsSearch']['reg_from']) && ($post['BillsSearch']['reg_to'])) {
                $this->reg_from = $post['BillsSearch']['reg_from'];
                $this->reg_to = $post['BillsSearch']['reg_to'];
                $start_reg = date("Y-m-d", strtotime($post['BillsSearch']['reg_from']));
                $end_reg = date("Y-m-d", strtotime("+1 day", strtotime($post['BillsSearch']['reg_to'])));
                $query->andFilterWhere(['>=', 'bills.date_cr', $start_reg])->andFilterWhere(['<', 'bills.date_cr', $end_reg]);
            }
            if (($post['BillsSearch']['reg_from']) && $post['BillsSearch']['reg_to'] == null) {
                $this->reg_from = $post['BillsSearch']['reg_from'];
                $start_reg = date("Y-m-d", strtotime($post['BillsSearch']['reg_from']));
                $query->andFilterWhere(['>=', 'bills.date_cr', $start_reg]);
            }

            if (($post['BillsSearch']['reg_from'] == null) && ($post['BillsSearch']['reg_to'])) {
                $this->reg_to = $post['BillsSearch']['reg_to'];
                $end_reg = date("Y-m-d", strtotime("+1 day", strtotime($post['BillsSearch']['reg_to'])));
                $query->andFilterWhere(['<', 'bills.date_cr', $end_reg]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->limit( $this->user_count)->asArray(),
            'pagination' => false
        ]);

        return $dataProvider;
    }
}
