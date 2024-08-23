<?php
use yii\helpers\Url;
use yii\helpers\Html;
// use yii\bootstrap\Modal;
// use kartik\grid\GridView;
// use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\ShopSliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// CrudAsset::register($this);

?>
<div class="shop-slider-index">
    <div id="ajaxCrudDatatable">
        <?=\kartik\grid\GridView::widget([
            'id'=>'crud-datatable-abanoment',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered'],
            'pjax'=>true,
            // 'rowOptions' => ['class' => 'danger'],
            'columns' => require(__DIR__.'/_columns.php'),
            'panelBeforeTemplate' => /*Html::a('Добавить <i class="fa fa-plus"></i>', ['/shops/shops-tariff/create','shop_id'=>$shopModel->id],
                    ['role'=>'modal-remote','title'=> 'Добавить','class'=>'pull-right btn btn-success','data-toggle' => 'tooltip']).*/'<div class="clearfix"></div>',
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
            'after'=>/*BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Are you sure?',
                                    'data-confirm-message'=>'Are you sure want to delete this item'
                                ]),
                        ]).*/'<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>

