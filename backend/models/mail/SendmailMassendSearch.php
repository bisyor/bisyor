<?php

namespace backend\models\mail;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\mail\SendmailMassend;

/**
 * SendmailMassendSearch represents the model behind the search form about `backend\models\mail\SendmailMassend`.
 */
class SendmailMassendSearch extends SendmailMassend
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'template_id'], 'integer'],
            [['from', 'name', 'title', 'text', 'date_cr', 'date_up'], 'safe'],
            [['to_phone', 'shop_only'], 'boolean'],
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
        $query = SendmailMassend::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder'=>[
                    'date_cr' => SORT_DESC,
                ]
            ]
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
            'to_phone' => $this->to_phone,
            'shop_only' => $this->shop_only,
            'template_id' => $this->template_id,
            'date_cr' => $this->date_cr,
            'date_up' => $this->date_up,
        ]);

        $query->andFilterWhere(['like', 'from', $this->from])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
