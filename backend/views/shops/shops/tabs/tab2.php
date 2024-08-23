<h3>Жалобы</h3>
<?=\kartik\grid\GridView::widget([
    'id'=>'crud-datatable-claims',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => ['class' => 'table table-bordered'],
    'pjax'=>true,
    'columns' => require(__DIR__.'/_columnsClaims.php'),
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

