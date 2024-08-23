<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\UserHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

CrudAsset::register($this);
?>
<?=GridView::widget([
    'id'=>'crud-datatable-items-tab-6',
    'dataProvider' => $dataProvider,
    // 'filterModel' => false,
    'panelBeforeTemplate' => false,
    'pjax'=>true,
    'columns' => require(__DIR__.'/_history_columns.php'),
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

