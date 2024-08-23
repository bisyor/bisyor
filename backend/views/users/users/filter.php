<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\components\StaticFunction;

 if (empty($post)){
    $post = ['reg_from' => '', 'reg_to' => '', 'last_from' => '', 'last_to' => '', 'status' => '', 'district' => ''];
 }

?>
    <?php $form = ActiveForm::begin([
            'method' => 'get',
        ]
        )?>
    <?php 
$layout = <<< HTML
<span class="input-group-addon">Регистрация: </span>
{input1}
<span class="input-group-addon"><i class="fa fa fa-arrows-h"></i></span>
{input2}
<span class="input-group-addon kv-date-remove">
<i class="glyphicon glyphicon-remove"></i>
</span>
HTML;
$layout2 = <<< HTML
<span class="input-group-addon">был: </span>
{input1}
<span class="input-group-addon"><i class="fa fa fa-arrows-h"></i></span>
{input2}
<span class="input-group-addon kv-date-remove">
<i class="glyphicon glyphicon-remove"></i>
</span>
HTML;
        ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($searchModel, 'reg_from')->widget(DatePicker::className(),
                [
                    'type' => DatePicker::TYPE_RANGE,
                    'attribute' => 'reg_from',
                    'attribute2' => 'reg_to',
                    'options' => [
                        'placeholder' => 'От',
                        'autoComplete' => 'off',
                    ],
                    'options2' => [
                        'placeholder' => 'До',
                        'autoComplete' => 'off',
                    ],
                    'layout' => $layout,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd.mm.yyyy',
                        'todayHighlight' => true,
                    ],
                ]
            )->label(false); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($searchModel, 'last_from')->widget(DatePicker::className(),
                [
                    'type' => DatePicker::TYPE_RANGE,
                    'attribute' => 'last_from',
                    'attribute2' => 'last_to',
                    'options' => [
                        'placeholder' => 'От',
                        'autoComplete' => 'off',
                    ],
                    'options2' => [
                        'placeholder' => 'До',
                        'autoComplete' => 'off',
                    ],
                    'layout' => $layout2,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd.mm.yyyy',
                        'todayHighlight' => true,
                    ],
                ]
            )->label(false); ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-3">
            <?=$form->field($searchModel, 'status')->widget(Select2::className(), [
                'data' =>  StaticFunction::getStatus(),
                'language' => 'ru',
                'name' => 'status',
                'options' => ['placeholder' => 'Выберите статус ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false)?>
        </div>
        <div class="col-md-3">
            <?=$form->field($searchModel, 'regionId')->widget(Select2::className(), [
                'data' =>  ArrayHelper::map(\backend\models\references\Regions::find()->asArray()->all(), 'id', 'name'),
                'language' => 'ru',
                'options' => ['placeholder' => 'Выберите регионь...',
                    'onchange'=> '$.post( "/users/users/districts",{id:$(this).val()}, function( data ){
                                            $( "select#userssearch-district_id" ).html(data);
                                        });',
                    ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false)?>
        </div>
        <div class="col-md-3">
            <?=$form->field($searchModel, 'district_id')->widget(Select2::className(), [
                'data' =>  StaticFunction::map(\backend\models\references\Districts::find()->asArray()->all(), 'id', 'name', 'region_id'),
                'language' => 'ru',
                'options' => ['placeholder' => 'Выберите районь...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false)?>
        </div>

        <div class="col-md-2">
            <div class="form-group" >
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-success']) ?>                
            </div>  
        </div>
    </div>
    <?php ActiveForm::end(); ?>
