<?php

namespace backend\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\references\Helps;
use backend\models\references\Districts;

/**
 * HelpsSearch represents the model behind the search form about `app\models\Helps`.
 */
class HelpsSearch extends Helps
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'helps_categories_id', 'sorting', 'usefull_count', 'nousefull_count'], 'integer'],
            [['name', 'text'], 'safe'],
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
    public function search($params, $help_id)
    {
        if($help_id != null) $query = Helps::find()->where(['helps_categories_id' => $help_id]);
        else $query = Helps::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['sorting'=>SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'helps_categories_id' => $this->helps_categories_id,
            'sorting' => $this->sorting,
            'usefull_count' => $this->usefull_count,
            'nousefull_count' => $this->nousefull_count,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
