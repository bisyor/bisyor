<?php
/**
 * @var $dataProviderComment
 * @var $searchModelComment
 */

?>

<h3>Комментарии</h3>
<?= \kartik\grid\GridView::widget([
    'id' => 'crud-datatable-comment',
    'dataProvider' => $dataProviderComment,
    'filterModel' => $searchModelComment,
    'tableOptions' => ['class' => 'table table-bordered'],
    'pjax' => true,
    'columns' => require(__DIR__ . '/_columnsComment.php'),
    'panelBeforeTemplate' => '',
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'responsiveWrap' => false,
    'pager' => [
        'firstPageLabel' => 'Первый',
        'lastPageLabel' => 'Последный'
    ],
    'panel' => [
        'headingOptions' => ['style' => 'display: none;'],
        'after' => '<div class="clearfix"></div>',
    ]
]) ?>

