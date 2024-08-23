<?php
namespace backend\models\shops;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\shops\ShopsTariff;

/**
 * ShopsTariffSearch represents the model behind the search form about `backend\models\shops\ShopsTariff`.
 */
class ShopsTariffSearch extends ShopsTariff
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['date_cr', 'abonement_id', 'shop_id', 'data_access'], 'safe'],
            [['price'], 'number'],
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
    public function search($params,$id = null)
    {
        $query = ShopsTariff::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->joinWith('shop');
        $query->joinWith('abonement');

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ilike', 'shops_abonements.title', $this->abonement_id
        ]);

        $query->andFilterWhere([
            'shops_tariff.shop_id' => $id,
            'shops_tariff.date_cr' => $this->date_cr,
            'shops_tariff.status' => $this->status,
            'shops_tariff.data_access' => $this->data_access,
            'shops_tariff.price' => $this->price,
        ]);

        return $dataProvider;
    }
}
