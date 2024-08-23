<?php

namespace backend\models\items;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ItemsSearch represents the model behind the search form about `backend\models\items\Items`.
 */
class ItemsSearch extends Items
{
    public $phone;
    public $your_own;
    public $paid;
    public $begin_date;
    public $end_date;
    public $service_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id','district_id','status','is_publicated','is_moderating','your_own','paid','begin_date',
                'end_date','service_id'],'safe'],
            [['id','user_id','shop_id','phone'], 'string'],
            [['from_device'], 'integer']
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
    public function search($params,$status=null)
    {
        $query = Items::find()->orderBy([
            'items.id' => SORT_DESC       
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->with('cat');
        $query->joinWith('user');
        $query->joinWith('district');
        $query->with('shop');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $categories = $this->cat_id;

        if($this->cat_id){
            $categories = \backend\models\items\Categories::getAllSubCategories($this->cat_id);
        }
        $query->andFilterWhere([
            'items.cat_id' => $categories,
        ]);
        
        if($status != null)
            $query->andFilterWhere([
                'items.status' => $status['status'],
                'items.is_moderating' => $status['is_moderating'],
                'items.is_publicated' => $status['is_publicated']
            ]);


        $user_id = ((int)($this->user_id) != 0) ? ((int)($this->user_id) < 2147483647 ? (int)($this->user_id) : '') : '';
        $item_id = ((int)($this->id) != 0) ? ((int)($this->id) < 2147483647 ? (int)($this->id) : '') : '';
        $shop_id = ((int)($this->shop_id) != 0) ? ((int)($this->shop_id) < 2147483647 ? (int)($this->shop_id) : '') : '';

        $query->andFilterWhere(['items.id' => $item_id])
            ->andFilterWhere([
                    'or',
                    ['items.user_id' => $user_id],
                    ['like', 'users.email', $this->user_id]
                ])
            ->andFilterWhere([
                    'or',
                    ['items.shop_id' => $shop_id],
                ])
           ->andFilterWhere(['districts.region_id' => $this->district_id]);

        if(!is_numeric($this->id)) {

            $query->andFilterWhere(['like', 'items.title',$this->id]);
        }
        if($this->phone){
            $query->andFilterWhere(['like', "replace(replace(items.phones,'-',''),' ','')", '%'.str_replace(' ','',str_replace('-','',$this->phone)).'%',false
            ]);
        }

        if($this->your_own){
            $query->andWhere(['is' ,'users.olx_link' ,null]);
        }

        if($this->begin_date){
            $this->begin_date .= " ".date('H:i');
            $query->andWhere(['>=' ,'items.status_changed' ,date('Y-m-d H:i' ,strtotime($this->begin_date))]);
            $this->begin_date = date('d.m.Y' , strtotime($this->begin_date));
        }

        if($this->end_date){
            $this->end_date .= " ".date('H:i');
            $query->andWhere(['<=' ,'items.status_changed' ,date('Y-m-d H:i' ,strtotime($this->end_date))]);
            $this->end_date = date('d.m.Y' , strtotime($this->end_date));
        }

        if($this->paid){
            $query->andWhere([
                'or',
                ['>=','items.svc_up_date' , date("Y-m-d H:i")],
                ['items.svc_fixed' => 1],
                ['items.svc_premium' => 1],
                ['>=' , 'items.svc_marked_to' , date("Y-m-d H:i") ],
            ]);
        }


        if($this->service_id){
            if($this->service_id == 1){
                $query->andFilterWhere([
                    'and',
                    ['>' ,'items.svc_up_date' ,date('Y-m-d H:i' ,strtotime(date('Y-m-d H:i')))],
                    ['items.svc_up_activate' => 1]
                ]);
            }

            elseif($this->service_id == 4){
                $query->andFilterWhere([
                    'and',
                    ['>' ,'items.svc_fixed_to' ,date('Y-m-d H:i' ,strtotime(date('Y-m-d H:i')))],
                    ['items.svc_fixed' => 1]
                ]);
            }

            elseif($this->service_id == 8){
                $query->andFilterWhere([
                    'and',
                    ['>' ,'items.svc_premium_to' ,date('Y-m-d H:i' ,strtotime(date('Y-m-d H:i')))],
                    ['items.svc_premium' => 1]
                ]);
            }

            elseif($this->service_id == 2){
                $query->andFilterWhere(['>' ,'items.svc_marked_to' ,date('Y-m-d H:i' ,strtotime(date('Y-m-d H:i')))]);
            }

            elseif( $this->service_id == 32){
                $query->andFilterWhere(['>' ,'items.svc_quick_to' ,date('Y-m-d H:i' ,strtotime(date('Y-m-d H:i')))]);
            }
        }


        return $dataProvider;
    }


    public function searchByUser($params, $id)
    {
        $query = Items::find()->andFilterWhere(['user_id' => (int)$id])->orderBy([
            'items.id' => SORT_DESC
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->with('cat');
        $query->joinWith('user');
        $query->joinWith('district');
        $query->with('shop');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $categories = $this->cat_id;

        if($this->cat_id){
            $categories = \backend\models\items\Categories::getAllSubCategories($this->cat_id);
        }
        $query->andFilterWhere([
            'items.cat_id' => $categories,
        ]);

        $user_id = ((int)($this->user_id) != 0) ? ((int)($this->user_id) < 2147483647 ? (int)($this->user_id) : '') : '';
        $item_id = ((int)($this->id) != 0) ? ((int)($this->id) < 2147483647 ? (int)($this->id) : '') : '';
        $shop_id = ((int)($this->shop_id) != 0) ? ((int)($this->shop_id) < 2147483647 ? (int)($this->shop_id) : '') : '';

        $query->andFilterWhere([
                    'or',
                    ['items.id' => $item_id],
                    ['like', 'items.title', $this->id],
                    ['like', 'items.phones', $this->id]
                ])
            ->andFilterWhere([
                    'or',
                    ['items.user_id' => $user_id],
                    ['like', 'users.email', $this->user_id]
                ])
            ->andFilterWhere([
                    'or',
                    ['items.shop_id' => $shop_id],
                ])
           ->andFilterWhere(['districts.region_id' => $this->district_id]);

        return $dataProvider;
    }
    
    public function searchShopItem($params,$id)
    {
        $query = Items::find()->where(['items.shop_id' => $id])
                    ->orderBy([
                        'items.id' => SORT_DESC       
                    ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->with('cat');
        $query->joinWith('user');
        $query->joinWith('district');
        $query->with('shop');

        if (!$this->validate()) {
            return $dataProvider;
        }
        $categories = $this->cat_id;

        if($this->cat_id){
            $categories = \backend\models\items\Categories::getAllSubCategories($this->cat_id);
        }
        $query->andFilterWhere([
            'items.cat_id' => $categories,
        ]);
        
        if($this->status){
            $status = Items::STATUS_TYPE[$this->status]['statuses'];
            $query->andFilterWhere([
                'items.status' => $status['status'],
                'items.is_moderating' => $status['is_moderating'],
                'items.is_publicated' => $status['is_publicated']
            ]);
        }
        
        $item_id = ((int)($this->id) != 0) ? ((int)($this->id) < 2147483647 ? (int)($this->id) : '') : '';
        
        $query->andFilterWhere(['items.id' => $item_id]);

        return $dataProvider;
    }

    public function getCategoryList()
    {
        $data = \backend\models\items\Categories::getDb()->cache(function ($db) {
            return \backend\models\items\Categories::find()
                            ->where(['parent_id' => 1 ,'enabled' =>1])
                            ->orderBy('id asc')
                            ->all();
        });
        return \yii\helpers\ArrayHelper::map($data,'id','title');
    }

    public function getRegionsList()
    {
        $data = \backend\models\references\Regions::getDb()->cache(function ($db) {
            return \backend\models\references\Regions::find()->all();
        });
        return \yii\helpers\ArrayHelper::map($data,'id','name');
    }
}
