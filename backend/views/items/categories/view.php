<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\items\Categories */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="categories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sorting',
            'numlevel',
            'icon_b',
            'icon_s',
            'keyword',
            'enabled:boolean',
            'date_cr',
            'date_up',
            'parent_id',
            'title',
            'type_offer_form',
            'type_offer_search',
            'type_seek_form',
            'type_seek_search',
            'seek:boolean',
            'price:boolean',
            'price_sett:ntext',
            'photos',
            'owner_business:boolean',
            'owner_private_form',
            'owner_private_search',
            'owner_business_form',
            'owner_business_search',
            'owner_search:boolean',
            'owner_search_business:boolean',
            'address:boolean',
            'metro:boolean',
            'regions_delivery:boolean',
            'list_type',
            'keyword_edit',
            'search_exrta_keywords:ntext',
            'items',
            'shops',
            'subs_filter_level',
            'subs_filter_title:ntext',
            'tpl_title_enabled:ntext',
            'tpl_title_view:ntext',
            'tpl_title_list:ntext',
            'tpl_descr_list:ntext',
            'mtitle',
            'mkeywords:ntext',
            'mdescription:ntext',
            'breadcrumb',
            'titleh1',
            'seotext:ntext',
            'landing_id',
            'landing_url:ntext',
            'mtemplate:boolean',
            'view_mtitle',
            'view_mkeywords',
            'view_mdescription:ntext',
            'view_share_title',
            'view_share_description:ntext',
            'view_share_sitename',
            'view_mtemplate',
        ],
    ]) ?>

</div>
