<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<?=GridView::widget([
    'id'=>'balance-datatable',
    'dataProvider' => $dataBalance,
    'filterModel' => $searchBalance,
    'pjax'=>true,
    'panelBeforeTemplate' => false,
    'columns' => require(__DIR__.'/_columns_balance.php'),
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