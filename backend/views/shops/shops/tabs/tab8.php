<?php
/**
* @var $dataProviderRating
* @var $searchModelRating
 */
?>
<h3>Оценка</h3>
<?=\kartik\grid\GridView::widget([
    'id'=>'crud-datatable-rating',
    'dataProvider' => $dataProviderRating,
    'filterModel' => $searchModelRating,
    'tableOptions' => ['class' => 'table table-bordered'],
    'pjax'=>true,
    'columns' => require(__DIR__.'/_columnsRating.php'),
    'panelBeforeTemplate' => '',
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'responsiveWrap' => false,
    'pager' => [
        'firstPageLabel' => 'Первый',
        'lastPageLabel'  => 'Последный'
    ],
    'panel' => [
        'headingOptions' => ['style' => 'display: none;'],
        'after'=>'<div class="clearfix"></div>',
    ]
])?>

