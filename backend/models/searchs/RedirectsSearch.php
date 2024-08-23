<?php

namespace backend\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\references\Redirects;


/**
 * BrandsSearch represents the model behind the search form about `app\models\Brands`.
 */
class RedirectsSearch extends Redirects
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'user_id', 'joined'], 'integer'],
            [['from_uri', 'to_uri', 'joined_module', 'user_ip'], 'safe'],
            [['date_cr', 'date_up'], 'datetime'],
            [['is_relative', 'add_extra', 'add_query', 'enabled'], 'boolean'],
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
        $query = Redirects::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'joined' => $this->joined,
            'from_uri' => $this->from_uri,
            'to_uri' => $this->to_uri,
            'joined_module' => $this->joined_module,
            'user_ip' => $this->user_ip,
            'date_cr' => $this->date_cr,
            'date_up' => $this->date_up,
            'is_relative' => $this->is_relative,
            'add_extra' => $this->add_extra,
            'add_query' => $this->add_query,
            'enabled' => $this->enabled,
        ]);

       // $query->andFilterWhere(['like', 'name', $this->name])
         //   ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
