<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="panel">
    <div class="panel-body" style="padding: 0px;">
        <?= $form->field($model, 'help_search_pagesize', [
            'template' => '<div class="row">
                                    <div class="col-md-3">{label}<br>Список</div>
                                    <div class="col-md-2">
                                        <div class="input-group">{input}<span class="input-group-addon">на страницу</span></div>{hint}{error}
                                    </div>
                                </div>'
            ])->textInput(['class' => 'form-control number_input'])?> 
        <?= $form->field($model, 'help_questions_form_wysiwyg',[
            'template' => '<div class="row">
                                    <div class="col-md-3">{label}</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-3">{input}{error}</div>
                                            <div class="col-md-12">{hint}</div>
                                        </div>
                                    </div>
                                </div>'
            ])->dropDownLIst($model->getStatus())->hint('использовать более польный редактор для редактирования краткого описания вопросов'); ?>
    </div>
    <div class="panel-footer">
        <?= Html::submitButton('Сохранить настройки', ['class' => 'btn btn-success','name' => 'tab-4-submit button']) ?>
    </div>
</div>