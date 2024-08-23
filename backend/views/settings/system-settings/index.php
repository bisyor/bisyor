<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use johnitvn\ajaxcrud\CrudAsset; 
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\ShopsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Системные настройки';
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
        <h4 class="panel-title">Системные настройки</h4>
    </div>
    <div class="panel-body" style="padding: 0px;">
        <div style="margin:0;">
            <ul class="nav nav-tabs" id="main-tab-nav">
                <li id="tab-1"><a href="#default-tab-1" data-toggle="tab">Объявления</a></li>
                <li id="tab-2"><a href="#default-tab-2" data-toggle="tab">Магазины</a></li>
                <li id="tab-3"><a href="#default-tab-3" data-toggle="tab">Пользователи</a></li>
                <li id="tab-4"><a href="#default-tab-4" data-toggle="tab">Сообщения</a></li>
                <li id="tab-5"><a href="#default-tab-5" data-toggle="tab">Блог</a></li>
                <li id="tab-6"><a href="#default-tab-6" data-toggle="tab">Помощь</a></li>
                <li id="tab-7"><a href="#default-tab-7" data-toggle="tab">Контакты</a></li>
                <li id="tab-8"><a href="#default-tab-8" data-toggle="tab">Гео</a></li>
                <li id="tab-9"><a href="#default-tab-9" data-toggle="tab">SEO</a></li>
                <li id="tab-10"><a href="#default-tab-10" data-toggle="tab">Другие</a></li>
            </ul>
            <?php $form = ActiveForm::begin([
                'options' => [
                    'id' => 'system-settings-form',
                ],
            ]); ?>
            <div class="tab-content" id="main-tab-content" style="padding-top: 15px;">
                <div class="tab-pane fade active in" id="default-tab-1">
                    <?= $this->render('tab1/index',[
                        'model' => $model,
                        'form' => $form,

                    ]) ?>
                </div>
                <div class="tab-pane fade in" id="default-tab-2">
                    <?= $this->render('tab2/index',[
                        'model' => $model,
                        'form' => $form,

                    ]) ?>
                </div>
                <div class="tab-pane fade in" id="default-tab-3">
                    <?= $this->render('tab3/index',[
                        'model' => $model,
                        'form' => $form,

                    ]) ?>
                </div>
                <div class="tab-pane fade in" id="default-tab-4">
                    <?= $this->render('tab4/index',[
                        'model' => $model,
                        'form' => $form,

                    ]) ?>
                </div>
                <div class="tab-pane fade in" id="default-tab-5">
                    <?= $this->render('tab5/index',[
                        'model' => $model,
                        'form' => $form,

                    ]) ?>
                </div>
                <div class="tab-pane fade in" id="default-tab-6">
                    <?= $this->render('tab6/index',[
                        'model' => $model,
                        'form' => $form,

                    ]) ?>
                </div>
                <div class="tab-pane fade in" id="default-tab-7">
                    <?= $this->render('tab7/index',[
                        'model' => $model,
                        'form' => $form,

                    ]) ?>
                </div>
                <div class="tab-pane fade in" id="default-tab-8">
                    <?= $this->render('tab8/index',[
                        'model' => $model,
                        'form' => $form,

                    ]) ?>
                </div>
                <div class="tab-pane fade in" id="default-tab-9">
                    <?= $this->render('tab9/index',[
                        'model' => $model,
                        'form' => $form,

                    ]) ?>
                </div>

                <div class="tab-pane fade in" id="default-tab-10">
                    <?= $this->render('tab10/index',[
                        'model' => $model,
                        'form' => $form,

                    ]) ?>
                </div>
            </div>

            <?= $form->field($model, 'tab')->hiddenInput(['id' => 'main-tab'])->label(false) ?>
            <?php ActiveForm::end(); ?>
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
    $(document).ready(function(){
        var active_tab = $("#main-tab").val();
        active_tab = getCookie('tab-system-settings');
        if(!active_tab || active_tab == 'undefined'){
            active_tab = 'tab-1';
        }
        for(i = 1; i < 11; i++){
            $("#default-tab-" + i).removeClass('active');
            $("#tab-" + i).removeClass('active');
        }

        $("#"+active_tab).addClass('active');
        $("#default-"+active_tab).addClass('active');
        
        $('#main-tab-nav li').on('click',function(){
            value = $(this).attr('id');
            setCookie('tab-system-settings',value);
            $("#main-tab").val(value);
        });
    })
JS
);


$this->registerJs(<<<JS
    $(".float_number_input").inputFilter(function(value) {
        return /^-?\d*[.]?\d{0,5}$/.test(value); 
    });

    $(".number_input").inputFilter(function(value) {
      return /^\d*$/.test(value);
    });
JS
);
?>