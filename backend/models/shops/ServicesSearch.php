<?php

namespace backend\models\shops;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\shops\Services;

/**
 * ServicesSearch represents the model behind the search form about `backend\models\shops\Services`.
 */
class ServicesSearch extends Services
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'day', 'sorting','enabled'], 'integer'],
            [['keyword', 'changed_id', 'module', 'module_title', 'title', 'short_description', 'description', 'icon_b', 'icon_s'], 'safe'],
            [['price'], 'number'],
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
        $query = Services::find()->orderBy(['sorting' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->joinWith('changed');
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'services.id' => $this->id,
            'services.type' => Services::TYPE_SERVICE,
            'services.price' => $this->price,
            'services.day' => $this->day,
            'services.sorting' => $this->sorting,
            'services.module' => Services::MODULE_SHOPS,
            'services.enabled' => ($this->enabled == 0 && $this->enabled != '') ? false : $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'services.keyword', $this->keyword])
            ->andFilterWhere(['like', 'users.fio', $this->changed_id])
            ->andFilterWhere(['like', 'services.module_title', $this->module_title])
            ->andFilterWhere(['like', 'services.title', $this->title])
            ->andFilterWhere(['like', 'services.short_description', $this->short_description])
            ->andFilterWhere(['like', 'services.description', $this->description]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchAdsServices($params)
    {
        $query = Services::find()->orderBy(['sorting' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->joinWith('changed');
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'services.id' => $this->id,
            'services.type' => Services::TYPE_SERVICE,
            'services.price' => $this->price,
            'services.day' => $this->day,
            'services.sorting' => $this->sorting,
            'services.module' => Services::MODULE_BBS,
            'services.enabled' => ($this->enabled == 0 && $this->enabled != '') ? false : $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'services.keyword', $this->keyword])
            ->andFilterWhere(['like', 'users.fio', $this->changed_id])
            ->andFilterWhere(['like', 'services.module_title', $this->module_title])
            ->andFilterWhere(['like', 'services.title', $this->title])
            ->andFilterWhere(['like', 'services.short_description', $this->short_description])
            ->andFilterWhere(['like', 'services.description', $this->description]);

        return $dataProvider;
    }

        /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchAdsPackets($params)
    {
        $query = Services::find()->orderBy(['sorting' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->joinWith('changed');

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'services.id' => $this->id,
            'services.type' => Services::TYPE_PACKET,
            'services.price' => $this->price,
            'services.day' => $this->day,
            'services.sorting' => $this->sorting,
            'services.module' => Services::MODULE_BBS,
            'services.enabled' => ($this->enabled == 0 && $this->enabled != '') ? false : $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'services.keyword', $this->keyword])
            ->andFilterWhere(['like', 'services.module_title', $this->module_title])
            ->andFilterWhere(['like', 'users.fio', $this->changed_id])
            ->andFilterWhere(['like', 'services.title', $this->title])
            ->andFilterWhere(['like', 'services.short_description', $this->short_description])
            ->andFilterWhere(['like', 'services.description', $this->description]);

        return $dataProvider;
    }
}
