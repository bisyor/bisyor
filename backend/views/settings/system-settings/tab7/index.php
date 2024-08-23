<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="panel">
    <div class="panel-body" style="padding: 0px;">
        <?= $form->field($model, 'contacts_captcha',[
            'template' => '<div class="row">
                                    <div class="col-md-3">{label}</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-3">{input}{error}</div>
                                            <div class="col-md-12">{hint}</div>
                                        </div>
                                    </div>
                                </div>'
            ])->dropDownLIst($model->getStatus())->hint('отображать поле ввода капчи для неавторизованных пользавателей в форме контактов'); ?>
        <?= $form->field($model, 'contacts_from_sender',[
            'template' => '<div class="row">
                                    <div class="col-md-3">{label}</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-3">{input}{error}</div>
                                            <div class="col-md-12">{hint}</div>
                                        </div>
                                    </div>
                                </div>'
            ])->dropDownLIst($model->getStatus())->hint('отправлять уведомления админстратору от имени/адреса отправителя (данных указанных в форме)'); ?>
    </div>
    <div class="panel-footer">
        <?= Html::submitButton('Сохранить настройки', ['class' => 'btn btn-success','name' => 'tab-4-submit button']) ?>
    </div>
</div>