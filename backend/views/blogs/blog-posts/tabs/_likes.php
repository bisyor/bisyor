<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;

?>
<?=GridView::widget([
    'id'=>'shops-datatable',
    'dataProvider' => $likeDataProvider,
    //'filterModel' => $searchShops,
    'pjax'=>true,
    'panelBeforeTemplate' => false,
    'columns' => require(__DIR__.'/_like_columns.php'),
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'responsiveWrap' => false,
    'panel' => false
])?>

