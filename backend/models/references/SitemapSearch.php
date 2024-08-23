<?php

namespace backend\models\references;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\references\Sitemap;

/**
 * SitemapSearch represents the model behind the search form about `backend\models\references\Sitemap`.
 */
class SitemapSearch extends Sitemap
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sitemap_id', 'type'], 'integer'],
            [['name', 'keyword', 'link', 'date_cr', 'target'], 'safe'],
            [['is_system', 'allow_submenu', 'enabled'], 'boolean'],
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
        $query = Sitemap::find()->where(['sitemap_id' => 1])->andFilterWhere(['!=', 'id', '1'])->orderBy(['id' => SORT_ASC]);

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
            'sitemap_id' => $this->sitemap_id,
            'type' => $this->type,
            'target' => $this->target,
            'is_system' => $this->is_system,
            'allow_submenu' => $this->allow_submenu,
            'enabled' => $this->enabled,
            'date_cr' => $this->date_cr,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'keyword', $this->keyword])
            ->andFilterWhere(['like', 'link', $this->link]);

        return $dataProvider;
    }
}
