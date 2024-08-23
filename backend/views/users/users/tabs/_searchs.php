<?php
/* 
    Веб разработчик: Abdulloh Olimov 
*/


use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;

?>
<?= GridView::widget([
    'id' => 'shops-datatable',
    'dataProvider' => $dataFavorites,
    'filterModel' => false,
    'pjax' => true,
    'panelBeforeTemplate' => false,
    'columns' => require(__DIR__ . '/_columns_search.php'),
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'responsiveWrap' => false,
    'pager' => [
        'firstPageLabel' => 'Первый',
        'lastPageLabel' => 'Последный'
    ],
    'panel' => false
]) ?>
