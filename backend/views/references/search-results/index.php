<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\SearchResultsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/**
 * @var $searchRes
 */
$this->title = 'Результат поиска';
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
        <?= $this->render('_search', ['search' => $searchModel,'get' => $get])?>
    </div>
</div>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn"> 
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Список </h4>
    </div>
    <div class="panel-body">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered'],
            'pjax'=>true,
            // 'rowOptions' => ['class' => 'danger'],
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
                'after'=>BulkButtonWidget::widget([
                                'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Удалить все',
                                    ["bulk-delete"] ,
                                    [
                                        "class"=>"btn btn-danger btn-xs",
                                        'role'=>'modal-remote-bulk',
                                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                        'data-request-method'=>'post',
                                        'data-confirm-title'=>'Are you sure?',
                                        'data-confirm-message'=>'Are you sure want to delete this item'
                                    ]),
                            ]).
                    '<div class="clearfix"></div>',
                ],
            ])?>
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
