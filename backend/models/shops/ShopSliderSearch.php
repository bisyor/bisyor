<?php
namespace backend\models\shops;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\shops\ShopSlider;

/**
 * ShopSliderSearch represents the model behind the search form about `backend\models\shops\ShopSlider`.
 */
class ShopSliderSearch extends ShopSlider
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'shop_id'], 'integer'],
            [['title', 'text', 'link'], 'safe'],
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
        $query = ShopSlider::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'shop_id' => $id,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'text', $this->text])
            ->andFilterWhere(['ilike', 'link', $this->link]);

        return $dataProvider;
    }
}
