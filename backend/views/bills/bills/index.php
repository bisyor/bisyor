<?php

use backend\models\bills\Bills;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var yii\web\View $this */
/* @var backend\models\bills\BillsSearch $searchModel */
/* @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Счета';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" id="search_colapse" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-plus"></i></a>
        </div>
        <h4 class="panel-title">Поиск </h4>
    </div>
    <div class="panel-body" id="search_panel">
        <?= $this->render('_search', ['search' => $searchModel])?>
    </div>
</div>
<div class="panel panel-inverse user-index">
    <div class="panel-body" style="padding: 0">
        <ul class="nav nav-tabs nav-tabs-inverse">
            <li class=""><a href="#All" data-toggle="tab">Все</a></li>
            <li class=""><a href="#dataZavershen" data-toggle="tab">Завершен</a></li>
            <li class=""><a href="#dataNezavershen" data-toggle="tab">Незавершен</a></li>
            <li class=""><a href="#dataOtmenen" data-toggle="tab">Отменен</a></li>
            <li class=""><a href="#dataObrabat" data-toggle="tab">Обрабатывается</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade" id="All">
                <div id="ajaxCrudDatatable">
                    <?=GridView::widget([
                        'id'=>'crud-datatable',
                        'dataProvider' => $dataProvider,
                        'showPageSummary' => isset($get['BillsSearch']) ?  true : false,
                        'filterModel' => false,
                        'tableOptions' => ['class' => 'table table-bordered'],
                        'pjax'=>true,
                        'columns' => require(__DIR__.'/_columns.php'),
                        'panelBeforeTemplate' => false,
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
                            'after'=>
                                '<div class="clearfix"></div>',
                        ]
                    ])?>
                </div>
            </div>
            <div class="tab-pane" id="dataZavershen">
                <?=GridView::widget([
                    'id'=>'crud-datatable-zav',
                    'dataProvider' => $dataZavershen,
                    'showPageSummary' => isset($get['BillsSearch']) ?  true : false,
                    'filterModel' => false ,
                    'tableOptions' => ['class' => 'table table-bordered'],
                    'pjax'=>true,
                    'columns' => require(__DIR__.'/_columns.php'),
                    'panelBeforeTemplate' => false,
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
                        'after'=>
                            '<div class="clearfix"></div>',
                    ]
                ])?>
            </div>
            <div class="tab-pane" id="dataNezavershen">
                <?=GridView::widget([
                    'id'=>'crud-datatable-nezav',
                    'dataProvider' => $dataNezavershen,
                    'showPageSummary' => isset($get['BillsSearch']) ?  true : false,
                    'filterModel' => false,
                    'tableOptions' => ['class' => 'table table-bordered'],
                    'pjax'=>true,
                    'columns' => require(__DIR__.'/_columns.php'),
                    'panelBeforeTemplate' => false,
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
                        'after'=>
                            '<div class="clearfix"></div>',
                    ]
                ])?>
            </div>
            <div class="tab-pane" id="dataOtmenen">
                <?=GridView::widget([
                    'id'=>'crud-datatable-otmen',
                    'dataProvider' => $dataOtmenen,
                    'showPageSummary' => isset($get['BillsSearch']) ?  true : false,
                    'filterModel' => false,
                    'tableOptions' => ['class' => 'table table-bordered'],
                    'pjax'=>true,
                    'columns' => require(__DIR__.'/_columns.php'),
                    'panelBeforeTemplate' => false,
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
                        'after'=>
                            '<div class="clearfix"></div>',
                    ]
                ])?>
            </div>
            <div class="tab-pane" id="dataObrabat">
                <?=GridView::widget([
                    'id'=>'crud-datatable-obrabat',
                    'dataProvider' => $dataObrabat,
                    'showPageSummary' => isset($get['BillsSearch']) ?  true : false,
                    'filterModel' => false,
                    'tableOptions' => ['class' => 'table table-bordered'],
                    'pjax'=>true,
                    'columns' => require(__DIR__.'/_columns.php'),
                    'panelBeforeTemplate' => false,
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
                        'after'=>
                            '<div class="clearfix"></div>',
                    ]
                ])?>
            </div>
        </div>

    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<?php
$this->registerJs(<<<JS
    
$(document).ready(function(){

    let panel = sessionStorage.getItem("search_panel");
    let tab = sessionStorage.getItem('tab');
    if(tab != "undefined" && tab !== null){
        $("[href='" + tab + "']").parent().addClass('active');
        $(tab).addClass('active in');
    }else{
       $("[href='#All']").parent().addClass('active');
        $("#All").addClass('active in');
    }
    
    if(panel == "no"){
        $('#search_colapse i').addClass('fa-minus').removeClass('fa-plus');
    }else{
       $('#search_panel').css('display', 'none');
       $('#search_colapse i').addClass('fa-plus').removeClass('fa-minus');
    }
    $('.nav-tabs li a').click(function(){
        var value =$(this).attr('href');
        sessionStorage.setItem("tab", value);
    });
    $(document).on('click', '#search_colapse', function(){
        if($('#search_colapse i').hasClass("fa-minus")){
            sessionStorage.setItem("search_panel", 'ok');
            $('#search_colapse i').removeClass("fa-minus").addClass("fa-plus");
        }else{
            sessionStorage.setItem("search_panel", 'no');
            $('#search_colapse i').removeClass("fa-plus").addClass("fa-minus");
        }
    });
});
JS
);
?>