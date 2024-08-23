<?php

namespace backend\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\seobase\Landingpages;

/**
 * LandingpagesSearch represents the model behind the search form about `backend\models\seobase\Landingpages`.
 */
class LandingpagesSearch extends Landingpages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'joined'], 'integer'],
            [['landing_uri', 'original_uri', 'title', 'date_cr', 'modified', 'user_ip', 'enabled', 'is_relative', 'joined_module', 'titleh1', 'mtitle', 'mkeywords', 'mdescription', 'seotext'], 'safe'],
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
        $query = Landingpages::find()->orderBy(['id' => SORT_DESC]);

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
            'date_cr' => $this->date_cr,
            'modified' => $this->modified,
            'user_id' => $this->user_id,
            'joined' => $this->joined,
        ]);

        $query->andFilterWhere(['like', 'landing_uri', $this->landing_uri])
            ->andFilterWhere(['like', 'original_uri', $this->original_uri])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'user_ip', $this->user_ip])
            ->andFilterWhere(['like', 'enabled', $this->enabled])
            ->andFilterWhere(['like', 'is_relative', $this->is_relative])
            ->andFilterWhere(['like', 'joined_module', $this->joined_module])
            ->andFilterWhere(['like', 'titleh1', $this->titleh1])
            ->andFilterWhere(['like', 'mtitle', $this->mtitle])
            ->andFilterWhere(['like', 'mkeywords', $this->mkeywords])
            ->andFilterWhere(['like', 'mdescription', $this->mdescription])
            ->andFilterWhere(['like', 'seotext', $this->seotext]);

        return $dataProvider;
    }
}