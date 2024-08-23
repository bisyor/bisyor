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
?>
<div class="panel panel-inverse claims-index">
    <div class="panel-body" style="padding: 0px;">
        <div style="margin:0;">
            <ul class="nav nav-tabs" id="claims-tab">
                <li id="items-claim-tab-1"><a href="#default-items-claim-tab-1" data-toggle="tab">Необработанные</a></li>
                <li id="items-claim-tab-2"><a href="#default-items-claim-tab-2" data-toggle="tab">Все</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="default-items-claim-tab-1">
                    <?= $this->render('index-claim',[
                        'searchModel' => $searchModelActive,
                        'dataProvider' => $dataProviderActive,
                        'tab' => 'items-claim-tab-1'
                    ]) ?>
                </div>

                <div class="tab-pane fade in" id="default-items-claim-tab-2">
                    <?= $this->render('index-claim',[
                        'searchModel' => $searchModelAll,
                        'dataProvider' => $dataProviderAll,
                        'tab' => 'items-claim-tab-2'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModalnew",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<?php 
$this->registerJsFile('/js/cookie.js');
$this->registerJs(<<<JS
    var active_tab = getCookie('tab-items-claims');
    if(!active_tab || active_tab == 'undefined'){
        active_tab = 'items-claim-tab-1';
    }
    $("#"+active_tab).addClass('active');
    $("[id^='default-items-claim-tab-']").removeClass('active');
    $("#default-"+active_tab).addClass('active');
    $('#claims-tab li').on('click',function(){
        value = $(this).attr('id');
        setCookie('tab-items-claims',value);
        $.pjax.reload({container:'#crud-datatable-item-claims-'+value+'-pjax',async:true});
    });
JS
)
?>