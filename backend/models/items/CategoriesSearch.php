<?php

namespace backend\models\items;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\items\Categories;

/**
 * CategoriesSearch represents the model behind the search form of `backend\models\items\Categories`.
 */
class CategoriesSearch extends Categories
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sorting', 'numlevel', 'parent_id', 'photos', 'list_type', 'items', 'shops', 'subs_filter_level', 'landing_id'], 'integer'],
            [['icon_b', 'icon_s', 'keyword', 'date_cr', 'date_up', 'title', 'type_offer_form', 'type_offer_search', 'type_seek_form', 'type_seek_search', 'price_sett', 'owner_private_form', 'owner_private_search', 'owner_business_form', 'owner_business_search', 'keyword_edit', 'search_exrta_keywords', 'subs_filter_title', 'tpl_title_enabled', 'tpl_title_view', 'tpl_title_list', 'tpl_descr_list', 'mtitle', 'mkeywords', 'mdescription', 'breadcrumb', 'titleh1', 'seotext', 'landing_url', 'view_mtitle', 'view_mkeywords', 'view_mdescription', 'view_share_title', 'view_share_description', 'view_share_sitename', 'view_mtemplate'], 'safe'],
            [['enabled', 'seek', 'price', 'owner_business', 'owner_search', 'owner_search_business', 'address', 'metro', 'regions_delivery', 'mtemplate'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Categories::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sorting' => $this->sorting,
            'numlevel' => $this->numlevel,
            'enabled' => $this->enabled,
            'date_cr' => $this->date_cr,
            'date_up' => $this->date_up,
            'parent_id' => $this->parent_id,
            'seek' => $this->seek,
            'price' => $this->price,
            'photos' => $this->photos,
            'owner_business' => $this->owner_business,
            'owner_search' => $this->owner_search,
            'owner_search_business' => $this->owner_search_business,
            'address' => $this->address,
            'metro' => $this->metro,
            'regions_delivery' => $this->regions_delivery,
            'list_type' => $this->list_type,
            'items' => $this->items,
            'shops' => $this->shops,
            'subs_filter_level' => $this->subs_filter_level,
            'landing_id' => $this->landing_id,
            'mtemplate' => $this->mtemplate,
        ]);

        $query->andFilterWhere(['ilike', 'icon_b', $this->icon_b])
            ->andFilterWhere(['ilike', 'icon_s', $this->icon_s])
            ->andFilterWhere(['ilike', 'keyword', $this->keyword])
            ->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'type_offer_form', $this->type_offer_form])
            ->andFilterWhere(['ilike', 'type_offer_search', $this->type_offer_search])
            ->andFilterWhere(['ilike', 'type_seek_form', $this->type_seek_form])
            ->andFilterWhere(['ilike', 'type_seek_search', $this->type_seek_search])
            ->andFilterWhere(['ilike', 'price_sett', $this->price_sett])
            ->andFilterWhere(['ilike', 'owner_private_form', $this->owner_private_form])
            ->andFilterWhere(['ilike', 'owner_private_search', $this->owner_private_search])
            ->andFilterWhere(['ilike', 'owner_business_form', $this->owner_business_form])
            ->andFilterWhere(['ilike', 'owner_business_search', $this->owner_business_search])
            ->andFilterWhere(['ilike', 'keyword_edit', $this->keyword_edit])
            ->andFilterWhere(['ilike', 'search_exrta_keywords', $this->search_exrta_keywords])
            ->andFilterWhere(['ilike', 'subs_filter_title', $this->subs_filter_title])
            ->andFilterWhere(['ilike', 'tpl_title_enabled', $this->tpl_title_enabled])
            ->andFilterWhere(['ilike', 'tpl_title_view', $this->tpl_title_view])
            ->andFilterWhere(['ilike', 'tpl_title_list', $this->tpl_title_list])
            ->andFilterWhere(['ilike', 'tpl_descr_list', $this->tpl_descr_list])
            ->andFilterWhere(['ilike', 'mtitle', $this->mtitle])
            ->andFilterWhere(['ilike', 'mkeywords', $this->mkeywords])
            ->andFilterWhere(['ilike', 'mdescription', $this->mdescription])
            ->andFilterWhere(['ilike', 'breadcrumb', $this->breadcrumb])
            ->andFilterWhere(['ilike', 'titleh1', $this->titleh1])
            ->andFilterWhere(['ilike', 'seotext', $this->seotext])
            ->andFilterWhere(['ilike', 'landing_url', $this->landing_url])
            ->andFilterWhere(['ilike', 'view_mtitle', $this->view_mtitle])
            ->andFilterWhere(['ilike', 'view_mkeywords', $this->view_mkeywords])
            ->andFilterWhere(['ilike', 'view_mdescription', $this->view_mdescription])
            ->andFilterWhere(['ilike', 'view_share_title', $this->view_share_title])
            ->andFilterWhere(['ilike', 'view_share_description', $this->view_share_description])
            ->andFilterWhere(['ilike', 'view_share_sitename', $this->view_share_sitename])
            ->andFilterWhere(['ilike', 'view_mtemplate', $this->view_mtemplate]);

        return $dataProvider;
    }
}
