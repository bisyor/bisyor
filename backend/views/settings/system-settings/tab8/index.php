<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="panel">
    <div class="" style="margin:0;">
        <?= $form->field($model, 'geo_ip_location',[
            'template' => '<div class="row">
                                    <div class="col-md-3">{label}</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-3">{input}{error}</div>
                                            <div class="col-md-12">{hint}</div>
                                        </div>
                                    </div>
                                </div>'
            ])->dropDownLIst($model->getStatus()); ?>
        <?= $form->field($model, 'geo_maps_type',[
            'template' => '<div class="row">
                                    <div class="col-md-3">{label}</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-3">{input}{error}</div>
                                            <div class="col-md-12">{hint}</div>
                                        </div>
                                    </div>
                                </div>'
            ])->dropDownLIst($model->getMapType()); ?>
        <?= $form->field($model, 'geo_maps_yandexKey', [
            'template' => '<div class="row">
                                    <div class="col-md-3">{label}</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-8">{input}{error}</div>
                                            <div class="col-md-12">{hint}</div>
                                        </div>
                                    </div>
                                </div>'
            ])?>
        <?= $form->field($model, 'geo_maps_googleKey', [
            'template' => '<div class="row">
                                    <div class="col-md-3">{label}</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-8">{input}{error}</div>
                                            <div class="col-md-12">{hint}</div>
                                        </div>
                                    </div>
                                </div>'
            ])?>
        <?= $form->field($model, 'geo_maps_default_coords_x', [
            'template' => '<div class="row">
                                    <div class="col-md-3">{label}</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-5">{input}{error}</div>
                                            <div class="col-md-12">{hint}</div>
                                        </div>
                                    </div>
                                </div>'
            ])->textInput(['class' => 'form-control float_number_input'])?>
        <?= $form->field($model, 'geo_maps_default_coords_y', [
            'template' => '<div class="row">
                                    <div class="col-md-3">{label}</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-5">{input}{error}</div>
                                            <div class="col-md-12">{hint}</div>
                                        </div>
                                    </div>
                                </div>'
            ])->textInput(['class' => 'form-control float_number_input'])?>

        <?= $form->field($model, 'geo_districts',[
            'template' => '<div class="row">
                                    <div class="col-md-3">{label}</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-3">{input}{error}</div>
                                            <div class="col-md-12">{hint}</div>
                                        </div>
                                    </div>
                                </div>'
            ])->dropDownLIst($model->getStatus())->hint('задействовать районы города в форме подачи объявления и поиска'); ?>
        <?= $form->field($model, 'geo_filter_url',[
            'template' => '<div class="row">
                                    <div class="col-md-3">{label}</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-5">{input}{error}</div>
                                            <div class="col-md-12">{hint}</div>
                                        </div>
                                    </div>
                                </div>'
            ])->dropDownLIst($model->getFilterUrl())->hint('данный режим рекомендуется при нескольлых странах в проекте'); ?>
        <?= $form->field($model, 'geo_city_select_presuggest_limit', [
            'template' => '<div class="row">
                                    <div class="col-md-3">{label}</div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-5">{input}{error}</div>
                                            <div class="col-md-12">{hint}</div>
                                        </div>
                                    </div>
                                </div>'
            ])->textInput(['class' => 'form-control number_input'])?>
    </div>

    <div class="panel-footer">
        <?= Html::submitButton('Сохранить настройки', ['class' => 'btn btn-success','name' => 'tab-4-submit button']) ?>
    </div>
</div>
