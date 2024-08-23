<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
$i = 0;
/* @var $this yii\web\View */
/* @var $model backend\models\alerts\Alerts */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="panel panel-inverse alerts-form">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title"><?=$title?></h4>
    </div>
    <?php $form = ActiveForm::begin([
        'options' => 
            [
                'id' => 'alerts-form'
            ]
    ]); ?>    
    <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>
    <div class="panel-body" style="padding: 50px;">
        <ul class="nav nav-pills" id="tab-2-nav">
            <?php foreach($langs as $lang):?>
                <li class="<?= $i == 0 ? 'active' : '' ?>">
                    <a data-toggle="tab" href="#<?=$lang->url?>-tab-2"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
                </li>
            <?php $i++; endforeach;?>
        </ul>
        <hr>
        <?php
            $templateInput = '<div class="row"><div class="col-md-2">
                    {label}</div><div class="col-md-9">{input}{hint}{error}</div></div>
                    ';
            $templateCheckbox = '<div class="row"><div class="col-md-2">
                            {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-5">{hint}</div></div>
                            ';
        ?>
        <div class="row">
            <div class="col-md-9">
                <?= $form->field($model, 'email',['template' => $templateCheckbox])->widget(CheckboxX::classname(),[
                        'pluginOptions'=>[
                                'threeState'=>false
                            ],
                        'options'=>[
                                'onchange' => "
                                    element = $(this).parent('div').parent('div').next().children('div');
                                    value = $(this).val();
                                    if(value == 1){
                                        $('.inputs').prop('readonly',true);
                                        element.html('Включено');
                                    }else{
                                        $('.inputs').prop('readonly',false);
                                        element.html('Выключено');
                                    }
                                "
                            ]
                ])->hint(($model->email == 1) ? 'Включено' : 'Выключено'); ?>
                
                <div class="tab-content" id="tab-2-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
                    <div id="ru-tab-2" class="tab-pane active in">
                        <?= $form->field($model, "title",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;'])?>
                        <?= $form->field($model, "text",['template' => $templateInput])->textarea(['rows' => 10])?> 
                        <?= $form->field($model, "sms_text",['template' => $templateInput])->textarea(['rows' => 10])?>
                    </div>
                    <?php $i = 0; foreach($langs as $lang): ?>
                        <?php if ($lang->url == 'ru') continue; ?>
                        <div id="<?=$lang->url?>-tab-2" class="tab-pane fade in">
                            <?= $form->field($model, 'translation_title['.$lang->url.']',['template' => $templateInput])->textInput()?>
                            <?= $form->field($model, 'translation_text['.$lang->url.']',['template' => $templateInput])->textarea(['rows' => 10])?>
                            <?= $form->field($model, 'translation_sms_text['.$lang->url.']',['template' => $templateInput])->textarea(['rows' => 10])?>
                        </div>
                    <?php $i++; endforeach;?>
                </div>
                <?= $form->field($model, 'sms',['template' => $templateCheckbox])->widget(CheckboxX::classname(),[
                        'pluginOptions'=>[
                                'threeState'=>false
                            ],
                        'options'=>[
                                'onchange' => "
                                    element = $(this).parent('div').parent('div').next().children('div');
                                    value = $(this).val();
                                    if(value == 1){
                                        $('.inputs').prop('readonly',true);
                                        element.html('Включено');
                                    }else{
                                        $('.inputs').prop('readonly',false);
                                        element.html('Выключено');
                                    }
                                "
                            ]
                ])->hint(($model->sms == 1) ? 'Включено' : 'Выключено'); ?>
            </div>

            <div class="col-md-3" >
                <div style="max-height: 330px;overflow-y: auto;">
                    <?php foreach (unserialize($model->extra) as $key => $value): ?>
                        <button class="btn btn-link tags" type="button"><?=$value['link']?></button>
                        <br>
                        <p class="muted" style="margin-left: 10px;"><?=$value['title']?></p>
                    <?php endforeach ?>
                </div>
                <hr>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-10">
                <p class="text-right m-b-0">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name' => 'submit-button']) ?>
                    <button class="btn btn-inverse" type="button" onClick="history.back();">Назад</button>
                </p>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>    

</div>
<?php 
$this->registerJs(<<<JS
    var prevFocus;
    $.fn.setCursorPosition = function (pos) {
        this.each(function (index, elem) {
            if (elem.setSelectionRange) {
                elem.setSelectionRange(pos, pos);
            } else if (elem.createTextRange) {
                var range = elem.createTextRange();
                range.collapse(true);
                range.moveEnd('character', pos);
                range.moveStart('character', pos);
                range.select();
            }
        });
        return this;
    };

    $("input").on("focus",function() {
        prevFocus = $(this);
    });

    $("textarea").on("focus",function() {
        prevFocus = $(this);
    });

    $(".tags").on("click",function(){
        if(!prevFocus) return;
        newValue = $(this).html();
        var v = prevFocus.val();
        var index = v.indexOf(newValue);
        var cursorPos = prevFocus.prop('selectionStart');
        var textBefore = v.substring(0,  cursorPos);
        var textAfter  = v.substring(cursorPos, v.length);
        prevFocus.val(textBefore + newValue + textAfter);
        prevFocus.focus().setCursorPosition(cursorPos+newValue.length);
        // if (index === -1) {
        //     var cursorPos = prevFocus.prop('selectionStart');
        //     var textBefore = v.substring(0,  cursorPos);
        //     var textAfter  = v.substring(cursorPos, v.length);
        //     prevFocus.val(textBefore + newValue + textAfter);
        //     prevFocus.focus().setCursorPosition(cursorPos+newValue.length);
        // }else{
        //     prevFocus.val(v.slice(0, index) + v.slice(index + newValue.length));
        //     prevFocus.focus().setCursorPosition(index);
        // }
    });

    $("div").each(function( index ) {
       $( this ).removeClass('form-group');
    });
JS
)
?>