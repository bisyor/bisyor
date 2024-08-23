<?=\kartik\grid\GridView::widget([
    'id'=>'crud-datatable-item-claims-'.$tab,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => ['class' => 'table table-bordered'],
    'pjax'=>true,
    'columns' => require(__DIR__.'/_columns-claim.php'),
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