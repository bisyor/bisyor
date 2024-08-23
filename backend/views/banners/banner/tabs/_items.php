<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;

?>
<a href="/banners/banner-slide/create?id=<?=$model->id?>" data-pjax="0" class="btn btn-success">Добавить <i class="fa fa-plus"></i> </a><br><br>

<?=GridView::widget([
    'id'=>'items-datatable',
    'dataProvider' => $itemsDataProvider,
    //'filterModel' => $searchShops,
    'pjax'=>true,
    'panelBeforeTemplate' => false,
    'columns' => require(__DIR__.'/_items_columns.php'),
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'responsiveWrap' => false,
    'pager' => [
        'firstPageLabel' => 'Первый',
        'lastPageLabel'  => 'Последный'
    ],
    'panel' => false
])?>
