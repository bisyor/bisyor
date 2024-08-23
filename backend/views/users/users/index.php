<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var yii\web\View $this */
/* @var backend\models\users\UsersSearch $searchModel */
/* @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" id="search_colapse" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i <?=(empty($post)) ? 'class="fa fa-plus"' : 'class="fa fa-minus"'?>></i></a>
        </div>
        <h4 class="panel-title">Поиск </h4>
    </div>
    <div class="panel-body" id="search_panel">
         <?=$this->render('filter', ['searchModel' => $searchModel]);?>
    </div>
</div>

<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?= Html::a('Добавить <i class="fa fa-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Добавить','class'=>'btn btn-xs btn-success'])?>
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Пользователи </h4>
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
                        'data-confirm-title'=>'Подтвердите действие?',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'
                    ]),
            ]).   
            '<div class="clearfix"></div>',
            ]
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

    let panel = sessionStorage.getItem("search_panel_user");
    
    if(panel == "no"){
        $('#search_colapse i').addClass('fa-minus').removeClass('fa-plus');
    }else{
       $('#search_panel').css('display', 'none');
       $('#search_colapse i').addClass('fa-plus').removeClass('fa-minus');
    }
    $(document).on('click', '#search_colapse', function(){
        if($('#search_colapse i').hasClass("fa-minus")){
            sessionStorage.setItem("search_panel_user", 'ok');
            $('#search_colapse i').removeClass("fa-minus").addClass("fa-plus");
        }else{
            sessionStorage.setItem("search_panel_user", 'no');
            $('#search_colapse i').removeClass("fa-plus").addClass("fa-minus");
        }
    });
});
JS
);
?>