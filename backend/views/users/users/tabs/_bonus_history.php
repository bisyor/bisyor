<?php
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataBonus */
?>
<?=GridView::widget([
    'id'=>'crud-datatable-items-tab-8',
    'dataProvider' => $dataBonus,
    'pjax'=>true,
    'panelBeforeTemplate' => false,
    'columns' => require(__DIR__.'/_bonus_history_columns.php'),
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
