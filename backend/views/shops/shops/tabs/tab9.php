<?php
/**
 * @var $dataProviderSubscribers
 * @var $searchModelSubscribers
 */

?>
<h3>Подписчики</h3>
<?=\kartik\grid\GridView::widget([
    'id'=>'crud-datatable-subscribers',
    'dataProvider' => $dataProviderSubscribers,
    'filterModel' => $searchModelSubscribers,
    'tableOptions' => ['class' => 'table table-bordered'],
    'pjax'=>true,
    'columns' => require(__DIR__.'/_columnsSubscribers.php'),
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

