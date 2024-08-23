<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;

?>

<?=GridView::widget([
    'id'=>'tags-datatable',
    'dataProvider' => $statisticDataProvider,
    //'filterModel' => $searchShops,
    'pjax'=>true,
    'panelBeforeTemplate' => false,
    'columns' => require(__DIR__.'/_statistic_columns.php'),
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
