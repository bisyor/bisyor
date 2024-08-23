<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\mail\SendmailMassendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ' Список';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<?php \yii\widgets\Pjax::begin(['id' =>'crud-datatable-pjax']) ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" id="search_colapse" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-plus"></i></a>
        </div>
        <h4 class="panel-title">Поиск </h4>
    </div>
    <div class="panel-body" id="search_panel">
        <?= $this->render('_search', ['search' => $searchModel,'post' => $post])?>
    </div>
</div>
<div class="sendmail-massend-index">
    <div class="panel panel-inverse user-index">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
            <h4 class="panel-title"> Список</h4>
        </div>
        <div class="panel-body">
            <div id="ajaxCrudDatatable">
                <?=GridView::widget([
                    'id'=>'crud-datatable',
                    'dataProvider' => $dataProvider,
//                    'filterModel' => $searchModel,
                    'showPageSummary' => true,
                    'tableOptions' => ['class' => 'table table-bordered'],
                    'pjax'=>false,
                    'columns' => require(__DIR__.'/_columns.php'),
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,
                    'responsiveWrap' => false,
                    'panelBeforeTemplate' => false,
                    'pager' => [
                        'firstPageLabel' => 'Первый',
                        'lastPageLabel'  => 'Последный'
                    ],
                    'panel' => [
                        'headingOptions' => ['style' => 'display: none;'],
                        'after'=> '<div class="clearfix"></div>',
                    ]
                ])?>
            </div>
        </div>
    </div>
</div>
<?php \yii\widgets\Pjax::end();?>
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
