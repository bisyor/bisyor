<?php
namespace backend\models\shops;

use backend\models\shops\ShopsSections;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ShopsSearch represents the model behind the search form about `backend\models\shops\Shops`.
 */
class ShopsSearch extends Shops
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'district_id','is_verify'], 'integer'],
            [['name','user_id', 'logo', 'keyword', 'description', 'address', 'coordinate_x', 'coordinate_y', 'phone', 'phones', 'site', 'blocked_reason', 'admin_comment', 'social_networks', 'date_cr', 'date_up', 'id','sections'], 'safe'],
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
    public function search($params,$type = null)
    {
        if(isset($type)){
            $query = Shops::find()
                ->with(['shopsSections'])
                ->andWhere(['shops.status' => Shops::STATUS_CHECKING]);
        }else{
            $query = Shops::find()
                ->with(['shopsSections'])
                ->andWhere(['!=', 'shops.status', Shops::STATUS_CHECKING]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => [
                    'id'=>SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if($this->sections){
            $id_shop = ShopsSections::find()->where(['section_id' => $this->sections])->all();
            $id_shops = \yii\helpers\ArrayHelper::getColumn($id_shop,'shop_id');
            $query->andWhere(['shops.id' => $id_shops]);
        }

        $query->joinWith('user');

        $query->andFilterWhere([
            'shops.status' => $this->status,
            'shops.district_id' => $this->district_id,
            'shops.is_verify' => $this->is_verify,
        ]);


        $query->andFilterWhere(['ilike', 'shops.name', $this->name])
            ->andFilterWhere(['ilike', 'users.fio', $this->user_id])
            ->andFilterWhere(['ilike', 'shops.keyword', $this->keyword])
            ->andFilterWhere(['ilike', 'shops.description', $this->description])
            ->andFilterWhere(['ilike', 'shops.address', $this->address])
            ->andFilterWhere(['ilike', 'shops.coordinate_x', $this->coordinate_x])
            ->andFilterWhere(['ilike', 'shops.coordinate_y', $this->coordinate_y])
            ->andFilterWhere(['ilike', 'shops.phone', $this->phone])
            ->andFilterWhere(['ilike', 'shops.phones', $this->phones])
            ->andFilterWhere(['ilike', 'shops.site', $this->site])
            ->andFilterWhere(['ilike', 'shops.blocked_reason', $this->blocked_reason])
            ->andFilterWhere(['ilike', 'shops.admin_comment', $this->admin_comment])
            ->andFilterWhere(['ilike', 'shops.social_networks', $this->social_networks]);

        return $dataProvider;
    }
    public function searchShops($params)
    {
        $query = Shops::find()->where(['user_id' => $params['id']]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if($this->sections){
            $id_shop = ShopsSections::find()->where(['section_id' => $this->sections])->all();
            $id_shops = \yii\helpers\ArrayHelper::getColumn($id_shop,'shop_id');
            $query->andWhere(['shops.id' => $id_shops]);
        }
        $query->andFilterWhere([
            'status' => $this->status,
        ]);


        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
