<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\ShopsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

CrudAsset::register($this);

$this->title = 'Жалобы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-inverse claims-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Список</h4>
    </div>
    <div class="panel-body" style="padding: 0px;">
        <div style="margin:0;">
            <ul class="nav nav-tabs">
                <li id="tab-1"><a href="#default-tab-1" data-toggle="tab">Необработанные</a></li>
                <li id="tab-2"><a href="#default-tab-2" data-toggle="tab">Все</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="default-tab-1">
                    <?= $this->render('tab',[
                        'searchModel' => $searchModelActive,
                        'dataProvider' => $dataProviderActive,
                        'tab' => 'tab-1'
                    ]) ?>
                </div>

                <div class="tab-pane fade in" id="default-tab-2">
                    <?= $this->render('tab',[
                        'searchModel' => $searchModelAll,
                        'dataProvider' => $dataProviderAll,
                        'tab' => 'tab-2'
                    ]) ?>
                </div>
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
$this->registerJsFile('/js/cookie.js');
$this->registerJs(<<<JS
    var active_tab = getCookie('tab-item-claims');
    if(!active_tab || active_tab == 'undefined'){
        active_tab = 'tab-1';
    }
    
    $("#"+active_tab).addClass('active');
    $(".tab-pane").removeClass('active');
    $("#default-"+active_tab).addClass('active');

    $('.nav li').on('click',function(){
        value = $(this).attr('id');
        setCookie('tab-item-claims',value);
        // $.pjax.reload({container:'#crud-datatable-item-claims-'+value+'-pjax',async:true});
    });
JS
)
?>