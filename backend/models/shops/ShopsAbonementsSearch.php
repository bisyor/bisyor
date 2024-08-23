<?php
namespace backend\models\shops;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\shops\ShopsAbonements;

/**
 * ShopsAbonementsSearch represents the model behind the search form about `backend\models\shops\ShopsAbonements`.
 */
class ShopsAbonementsSearch extends ShopsAbonements
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','enabled','is_free', 'price_free_period', 'ads_count', 'num'], 'integer'],
            [['title', 'import', 'mark', 'fix', 'icon_b', 'icon_s', 'one_time', 'is_default'], 'safe'],
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
        $query = ShopsAbonements::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder'=>[
                    'id' => SORT_ASC,
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'ads_count' => $this->ads_count,
            'num' => $this->num,
            'enabled' => ($this->enabled == 0 && $this->enabled!= '') ? false : $this->enabled,
            'import' => ($this->import == 0 && $this->import!= '') ? false : $this->import,
            'mark' => ($this->mark == 0 && $this->mark!= '') ? false : $this->mark,
            'one_time' => ($this->one_time == 0 && $this->one_time!= '') ? false : $this->one_time,
            'is_default' => ($this->is_default == 0 && $this->is_default!= '') ? false : $this->is_default,
            'is_free' => ($this->is_free == 0 && $this->is_free!= '') ? false : $this->is_free,
            'fix' => ($this->fix == 0 && $this->fix!= '') ? false : $this->fix
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'icon_b', $this->icon_b])
            ->andFilterWhere(['like', 'icon_s', $this->icon_s]);

        return $dataProvider;
    }
}
