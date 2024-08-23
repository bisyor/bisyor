<?php
namespace backend\models\shops;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\shops\ShopsClaims;

/**
 * ShopsClaimsSearch represents the model behind the search form of `backend\models\shops\ShopsClaims`.
 */
class ShopsClaimsSearch extends ShopsClaims
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'reason'], 'integer'],
            [['user_ip', 'message','shop_id', 'date_cr','user_id'], 'safe'],
            [['viewed'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function search($params,$type = null,$id = null)
    {
        $query = ShopsClaims::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->joinWith('user');
        $query->joinWith('shop');
        
        if (!$this->validate()) {
            return $dataProvider;
        }

        if($id != null)
            $query->andFilterWhere([
                'shops_claims.shop_id' => $id,
            ]);
        else
            $query->andFilterWhere([
                'ilike', 'shops.name', $this->shop_id
            ]);

        if($type === false || $type === true)
            $query->andFilterWhere([
                'shops_claims.viewed' => $type,
            ]);
        else
            $query->andFilterWhere([
                'shops_claims.viewed' => $this->viewed,
            ]);
        // grid filtering conditions
        $query->andFilterWhere([
            'shops_claims.reason' => $this->reason,
            'shops_claims.date_cr' => $this->date_cr,
        ]);

        $query->andFilterWhere(['ilike', 'shops_claims.user_ip', $this->user_ip])
            ->andFilterWhere(['ilike', 'users.fio', $this->user_id])
            ->andFilterWhere(['ilike', 'shops_claims.message', $this->message]);

        return $dataProvider;
    }
}
