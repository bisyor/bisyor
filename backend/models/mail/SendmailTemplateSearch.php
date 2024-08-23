<?php

namespace backend\models\mail;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\mail\SendmailTemplate;

/**
 * SendmailTemplateSearch represents the model behind the search form about `backend\models\mail\SendmailTemplate`.
 */
class SendmailTemplateSearch extends SendmailTemplate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'num'], 'integer'],
            [['title', 'content', 'date_cr', 'date_up'], 'safe'],
            [['is_html'], 'boolean'],
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
        $query = SendmailTemplate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_html' => $this->is_html,
            'num' => $this->num,
            'date_cr' => $this->date_cr,
            'date_up' => $this->date_up,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
