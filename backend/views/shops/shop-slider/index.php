<?php
use yii\helpers\Url;
use yii\helpers\Html;
use johnitvn\ajaxcrud\BulkButtonWidget;
?>
<div class="shop-slider-index">
    <div id="ajaxCrudDatatable">
        <?=\kartik\grid\GridView::widget([
            'id'=>'crud-datatable-slider',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered'],
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'panelBeforeTemplate' => Html::a('Добавить <i class="fa fa-plus"></i>', ['/shops/shop-slider/create','shop_id'=>$shopModel->id],
                    ['role'=>'modal-remote','title'=> 'Добавить','class'=>'pull-right btn btn-success','data-toggle' => 'tooltip']).'<div class="clearfix"></div>',
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
            'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Are you sure?',
                                    'data-confirm-message'=>'Are you sure want to delete this item'
                                ]),
                        ]).'<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>

