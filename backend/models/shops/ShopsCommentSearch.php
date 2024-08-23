<?php

namespace backend\models\shops;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ShopsCommentSearch represents the model behind the search form about `backend\models\shops\ShopsComment`.
 */
class ShopsCommentSearch extends ShopsComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'shop_id'], 'integer'],
            [['enabled'], 'boolean'],
            [['text', 'user_ip', 'fio'], 'safe'],
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
    public function search($params, $id = null)
    {
        $query = ShopsComment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'enabled' => $this->enabled,
            'shop_id' => $id

        ]);

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'user_ip', $this->user_ip])
            ->andFilterWhere(['like', 'fio.fio', $this->fio]);

        return $dataProvider;
    }
}
