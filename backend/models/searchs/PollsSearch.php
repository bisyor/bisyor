<?php

namespace backend\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\polls\Polls;

/**
 * PollsSearch represents the model behind the search form about `backend\models\Polls`.
 */
class PollsSearch extends Polls
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'finish_type', 'choice', 'view_result', 'audience'], 'integer'],
            [['name', 'start', 'finish', 'ownoption_text'], 'safe'],
            [['ownoption', 'resultvotes', 'showfinishing'], 'boolean'],
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
    public function search($params,$status)
    {
        $query = Polls::find()->orderBy(['id'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if($status !=  '') $query->andFilterWhere(['status' => $status]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'start' => $this->start,
            'finish' => $this->finish,
            'status' => $this->status,
            'finish_type' => $this->finish_type,
            'ownoption' => $this->ownoption,
            'choice' => $this->choice,
            'view_result' => $this->view_result,
            'resultvotes' => $this->resultvotes,
            'showfinishing' => $this->showfinishing,
            'audience' => $this->audience,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'ownoption_text', $this->ownoption_text]);

        return $dataProvider;
    }
}
