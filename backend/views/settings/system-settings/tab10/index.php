<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\ShopsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="panel-body" style="padding: 0px;">
    <div style="margin:0;">
        <ul class="nav nav-tabs" id="tab-10-nav">
            <li class="active" id="tab-10-1"><a href="#default-tab-10-1" data-toggle="tab">Общие</a></li>
            <li id="tab-10-2"><a href="#default-tab-10-2" data-toggle="tab">Почта</a></li>
            <li id="tab-10-3"><a href="#default-tab-10-3" data-toggle="tab">Системные</a></li>
        </ul>
        <hr>
        <div class="tab-content" id="tab-10-content">
            <div class="tab-pane fade active in" id="default-tab-10-1">
                <?= $this->render('tab1',[
                    'model' => $model,
                    'tab' => 'tab-1',
                    'form' => $form,
                ]) ?>
            </div>

            <div class="tab-pane fade in" id="default-tab-10-2">
                <?= $this->render('tab2',[
                    'model' => $model,
                    'tab' => 'tab-10',
                    'form' => $form,
                ]) ?>
            </div>

            <div class="tab-pane fade in" id="default-tab-10-3">
                <?= $this->render('tab3',[
                    'model' => $model,
                    'tab' => 'tab-10',
                    'form' => $form,
                ]) ?>
            </div>
        </div>
    </div>

    <div class="panel-footer">
        <?= Html::submitButton('Сохранить настройки', ['class' => 'btn btn-success','name' => 'tab-10-submit button']) ?>
    </div>
</div>

<?php 
$this->registerJsFile('/js/cookie.js');
$this->registerJs(<<<JS
    // var active_tab = getCookie('tab-settings');
    // if(!active_tab || active_tab == 'undefined'){
    //     active_tab = 'tab-1';
    // }
    
    // for(i = 0; i<4; i++){
    //     $("#default-tab-" + i).removeClass('active');
    //     $("#tab-" + i).removeClass('active');
    // }

    // $("#"+active_tab).addClass('active');
    // $("#default-"+active_tab).addClass('active');

    // $('.nav li').on('click',function(){
    //     value = $(this).attr('id');
    //     setCookie('tab-settings',value);
    //     $("#tab").val(value);
    //     // $.pjax.reload({container:'#crud-datatable-claims-'+value+'-pjax',async:true});
    // });
    

    $(document).ready(function(){
        var active_tab = $("#main-tab").val();
        active_tab = getCookie('tab-settings');
        if(!active_tab || active_tab == 'undefined'){
            active_tab = 'tab-1';
        }
        for(i = 0; i<4; i++){
            $("#default-tab-" + i).removeClass('active');
            $("#tab-" + i).removeClass('active');
        }
        $("#"+active_tab).addClass('active');
        $("#default-"+active_tab).addClass('active');
        $('#main-tab-nav li').on('click',function(){
            value = $(this).attr('id');
            setCookie('tab-settings',value);
            $("#main-tab").val(value);
        });
    })
JS
)
?>