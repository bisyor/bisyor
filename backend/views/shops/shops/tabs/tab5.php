<h3>Объявления</h3>
<?=\kartik\grid\GridView::widget([
    'id'=>'crud-datatable-items-tab-1',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => ['class' => 'table table-bordered'],
    'pjax'=>true,
    'columns' => require(__DIR__.'/_columnsItems.php'),
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

