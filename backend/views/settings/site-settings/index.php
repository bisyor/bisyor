<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset; 

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\ShopsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Общие настройки';
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);
?>
<div class="panel panel-inverse claims-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="/settings/site-settings/download-settings-file" role="modal-remote" class="btn btn-xs  btn-success">Загрузить настройки <i class="fa fa-download"></i> </a>
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Общие настройки</h4>
    </div>
    <?php $form = ActiveForm::begin([
        'enableAjaxValidation'      => false,
        'enableClientValidation'    => false,
        'validateOnChange'          => false,
        'validateOnSubmit'          => true,
        'validateOnBlur'            => false,
        'options' => [
            'enctype' => 'multipart/form-data',
            'id' => 'site-settings-form',
        ],
    ]); ?>
    <div class="panel-body" style="padding: 0px;">
        
        <div style="margin:0;">
            <ul class="nav nav-tabs" id="main-tab-nav">
                <li id="tab-1"><a href="#default-tab-1" data-toggle="tab">Общие настройки</a></li>
                <li id="tab-2"><a href="#default-tab-2" data-toggle="tab">Выключение сайта</a></li>
                <li id="tab-3"><a href="#default-tab-3" data-toggle="tab">Форма контактов</a></li>
                <li id="tab-4"><a href="#default-tab-4" data-toggle="tab">О компании</a></li>
            </ul>
            
            <div class="tab-content" id="main-tab-content">
                <div class="tab-pane fade active in" id="default-tab-1">
                    <?= $this->render('tab1',[
                        'model' => $model,
                        'tab' => 'tab-1',
                        'form' => $form,
                        'langs' => $langs
                    ]) ?>
                </div>

                <div class="tab-pane fade in panel-bg" id="default-tab-2">
                    <?= $this->render('tab2',[
                        'model' => $model,
                        'tab' => 'tab-2',
                        'form' => $form,
                        'langs' => $langs
                    ]) ?>
                </div>

                <div class="tab-pane fade in" id="default-tab-3">
                    <?= $this->render('tab3',[
                        'model' => $model,
                        'tab' => 'tab-3',
                        'form' => $form,
                        'langs' => $langs
                    ]) ?>
                </div>

                <div class="tab-pane fade in" id="default-tab-4">
                    <?= $this->render('tab4',[
                        'model' => $model,
                        'tab' => 'tab-4',
                        'form' => $form,
                        'langs' => $langs
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="panel-footer">
            <?= Html::submitButton('Сохранить настройки', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?= $form->field($model, 'tab')->hiddenInput(['id' => 'main-tab'])->label(false) ?>
    <?php ActiveForm::end(); ?>

</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<?php 
$this->registerJsFile('/js/cookie.js');
$this->registerJs(<<<JS
    $(document).ready(function(){
        var active_tab = $("#main-tab").val();
        active_tab = getCookie('tab-site-settings');
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
            setCookie('tab-site-settings',value);
            $("#main-tab").val(value);
        });
    })
JS
)
?>
