<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\ShopsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="panel panel-inverse claims-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Общие настройки</h4>
    </div>
    <?php $form = ActiveForm::begin([
//        'enableAjaxValidation' => true,
        'options' => [
            'enctype' => 'multipart/form-data',
            'id' => 'items-form',
        ],
    ]); ?>
    <div class="panel-body" style="padding: 0px;">
        
        <div style="margin:0;">
            <ul class="nav nav-tabs" id="main-tab-nav">
                <li id="tab-1" class="active"><a href="#default-tab-1" data-toggle="tab">Описание</a></li>
                <li id="tab-2"><a href="#default-tab-2" data-toggle="tab">Фото (<?=count($upload_images)?>)</a></li>
                <?php if (!$model->isNewRecord): ?>
                    <li id="tab-3"><a href="#default-tab-3" data-toggle="tab">Жалобы</a></li>
                    <li id="tab-4"><a href="#default-tab-4" data-toggle="tab">Услуги</a></li>
                    <li  onclick="window.location.href='/chats/index?item_id=<?= $model->id;?>&type=6'"><a href="#" >Сообщения (<?= $chats_count?>)</a></li>
                <?php endif ?>
                <a href="<?=isset($itemLink) ? $itemLink : ''?>" class="btn btn-link pull-right" target="_blank">Страница объявления</a>
            </ul>
            
            <div class="tab-content" id="main-tab-content">
                <div class="tab-pane fade active in" id="default-tab-1">
                    <?= $this->render('tabs/tab1',[
                        'model' => $model,
                        'tab' => 'tab-1',
                        'form' => $form,
                        'category' => $category,
                        'fields' => $fields,
                    ]) ?>
                </div>

                <div class="tab-pane fade in" id="default-tab-2">
                    <?= $this->render('tabs/tab2',[
                        'model' => $model,
                        'upload_images' => $upload_images,
                        'tab' => 'tab-2',
                        'post' => $post,
                        'form' => $form,
                    ]) ?>
                </div>

                <?php if (!$model->isNewRecord): ?>
                    <div class="tab-pane fade in" id="default-tab-3">
                        <?= $this->render('tabs/tab3', [
                            'searchModelAll' => $searchModelAll,
                            'dataProviderAll' => $dataProviderAll,

                            'searchModelActive' => $searchModelActive,
                            'dataProviderActive' => $dataProviderActive,
                        ]); ?>
                    </div>
                    <div class="tab-pane fade in" id="default-tab-4">
                        <?= $this->render('tabs/tab4',[
                            'model' => $model
                        ]) ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <div class="panel-footer">
            <span id="submit-button">
                <?= Html::submitButton('Сохранить настройки', ['class' => 'btn btn-success']) ?>
            </span>
            <button class="btn btn-inverse" type="button" onClick="history.back();">Назад</button>
        </div>
    </div>
    <?= $form->field($model, 'tab')->hiddenInput(['id' => 'main-tab'])->label(false) ?>
    <?php ActiveForm::end(); ?>

</div>

<?php 
$this->registerJsFile('/js/cookie.js');
$this->registerJs(<<<JS
 
    $(document).ready(function(){
        var active_tab = $("#main-tab").val();
        active_tab = getCookie('tab-items-form');

        if(!active_tab || active_tab == 'undefined'){
            active_tab = 'tab-1';
        }
        for(i = 0; i<4; i++){
            $("#default-tab-" + i).removeClass('active');
            $("#tab-" + i).removeClass('active');
        }
        $("#"+active_tab).addClass('active');
        $("#default-"+active_tab).addClass('active');
        
        if(active_tab == 'tab-1' || active_tab == 'tab-2' || active_tab == 'tab-5'){
            $("#submit-button").show();
        }

        $('#main-tab-nav li').on('click',function(){
            value = $(this).attr('id');
            if(value == 'tab-3' || value == 'tab-4'){
                $("#submit-button").hide();
            }else{
                $("#submit-button").show();
            }
            setCookie('tab-items-form',value);
            $("#main-tab").val(value);
        });
    })
JS
)
?>