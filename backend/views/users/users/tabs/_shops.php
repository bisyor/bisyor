<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
// /* @var $this yii\web\View */
//  @var $searchModel backend\models\searchs\OrdersSearch 
// /* @var $dataProvider yii\data\ActiveDataProvider */

// CrudAsset::register($this);
?>
<?=GridView::widget([
      'id'=>'shops-datatable',
      'dataProvider' => $dataShops,
      'filterModel' => $searchShops,
      'pjax'=>true,
      'panelBeforeTemplate' => false,
      'columns' => require(__DIR__.'/_columns_shops.php'),
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
