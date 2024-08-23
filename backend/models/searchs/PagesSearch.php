<?php

namespace backend\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\references\Pages;

/**
 * PagesSearch represents the model behind the search form about `backend\models\references\Pages`.
 */
class PagesSearch extends Pages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'changed_id'], 'integer'],
            [['filename', 'date_cr', 'date_up', 'title', 'description', 'mtitle', 'mkeywords', 'mdescription'], 'safe'],
            [['noindex'], 'boolean'],
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
        $query = Pages::find();

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
            'changed_id' => $this->changed_id,
            'date_cr' => $this->date_cr,
            'date_up' => $this->date_up,
            'noindex' => $this->noindex,
        ]);

        $query->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'mtitle', $this->mtitle])
            ->andFilterWhere(['like', 'mkeywords', $this->mkeywords])
            ->andFilterWhere(['like', 'mdescription', $this->mdescription]);

        return $dataProvider;
    }
}
