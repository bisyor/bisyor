<?php
use kartik\grid\GridView;
 /* @var $this yii\web\View */
  /* @var $searchItems */
 /* @var $dataItems yii\data\ActiveDataProvider */
?>
<?=GridView::widget([
    'id'=>'crud-datatable-items-tab-1',
    'dataProvider' => $dataItems,
    'filterModel' => $searchItems,
    'pjax'=>true,
    'panelBeforeTemplate' => false,
    'columns' => require(__DIR__.'/_columns_items.php'),
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
