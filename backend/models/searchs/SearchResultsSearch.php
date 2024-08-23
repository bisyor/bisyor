<?php

namespace backend\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\references\SearchResults;

/**
 * SearchResultsSearch represents the model behind the search form about `backend\models\references\SearchResults`.
 */
class SearchResultsSearch extends SearchResults
{
    /**
     * @inheritdoc
     */

    public $result_from;
    public $result_to;


    public function rules()
    {
        return [
            [['id', 'pid', 'region_id', 'counter', 'hits','district_id'], 'integer'],
            [['query', 'last_time','result_from','result_to'], 'safe'],
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
        $query = SearchResults::find()
            ->select(['*','(counter - hits) as diff',
                '(select count(*) from search_results d where d.pid=search_results.id and d.from_device=3) as android',
                '(select count(*) from search_results d where d.pid=search_results.id and d.from_device=1) as site',
                '(select count(*) from search_results d where d.pid=search_results.id and d.from_device=2) as telegram_bot',
                '(select count(*) from search_results d where d.pid=search_results.id and d.from_device=4) as ios'
            ])
            ->andWhere(['pid'=>0]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'last_time' => SORT_DESC,
                ],
            ],
        ]);

        $dataProvider->sort->attributes['diff'] = [
            'asc' => ['diff' => SORT_ASC],
            'desc' => ['diff' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'pid' => $this->pid,
            'region_id' => $this->region_id,
            'counter' => $this->counter,
            'hits' => $this->hits,
            'last_time' => $this->last_time,
        ]);

        if (!empty($this->result_from) && !empty($this->result_to)) {
            $start_reg = date("Y-m-d 00:00:00", strtotime($this->result_from));
            $end_reg = date("Y-m-d 23:59:59", strtotime($this->result_to));
            $query->andFilterWhere(['>=', 'last_time', $start_reg])->andFilterWhere(['<=', 'last_time', $end_reg]);
        }

        $query->andFilterWhere(['like', 'query', $this->query]);

        return $dataProvider;
    }

    public function searchView($params, $pid)
    {
        $query = SearchResults::find()
            ->with(['region'])
            ->select([
                'pid' ,
                'region_id',
                'sum(counter) as counter',
                'sum(hits) as hits',
                'SUM(CASE WHEN from_device = 1 THEN 1 ELSE 0  END) as site',
                'SUM(CASE WHEN from_device = 2 THEN 1 ELSE 0  END) as telegram_bot',
                'SUM(CASE WHEN from_device = 3 THEN 1 ELSE 0  END) as android',
                'SUM(CASE WHEN from_device = 4 THEN 1 ELSE 0  END) as ios',
                ])
            ->andWhere(['pid' => $pid])
            ->groupBy(['region_id','pid']);
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
            'pid' => $this->pid,
            'region_id' => $this->region_id,
            'counter' => $this->counter,
            'hits' => $this->hits,
            'last_time' => $this->last_time,
        ]);



        $query->andFilterWhere(['like', 'query', $this->query]);

        return $dataProvider;
    }

    public function searchViewDistricts($params, $pid ,$region_id)
    {
        $query = SearchResults::find()
            ->with('districts')
            ->select(['pid' ,
                'district_id',
                'sum(counter) as counter',
                'sum(hits) as hits',
                'SUM(CASE WHEN from_device = 1 THEN 1 ELSE 0  END) as site',
                'SUM(CASE WHEN from_device = 2 THEN 1 ELSE 0  END) as telegram_bot',
                'SUM(CASE WHEN from_device = 3 THEN 1 ELSE 0  END) as android',
                'SUM(CASE WHEN from_device = 4 THEN 1 ELSE 0  END) as ios',
            ])
            ->andWhere(['pid' => $pid,'region_id' =>$region_id ])
            ->groupBy(['district_id','pid']);

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
            'pid' => $this->pid,
            'region_id' => $this->region_id,
            'counter' => $this->counter,
            'hits' => $this->hits,
            'last_time' => $this->last_time,
        ]);



        $query->andFilterWhere(['like', 'query', $this->query]);

        return $dataProvider;
    }
}
