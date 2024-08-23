<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin([
	'action' => ['index'],
    'method' => 'get',
    'options' => [
	    // 'id' => 'search-form-'.$tab,
        'data-pjax' => 1
    ],
    'id' => 'search-form-'.$tab
]);

$layout = <<< HTML
{input1}
<span class="input-group-addon"><i class="fa fa fa-arrows-h"></i></span>
{input2}
<span class="input-group-addon kv-date-remove">
<i class="glyphicon glyphicon-remove"></i>
</span>
HTML;
?>

<style>
    .datepicker-orient-top{
        z-index: 30000 !important;;
    }
</style>
	<?=$form->field($model,'status')->hiddenInput(['id' => 'status-'.$tab])->label(false);?>
<div class="row">

	<div class="col-md-2" style="padding-right:0px;">
    	<?= $form->field($model, 'id')->textInput(['placeholder' => 'ID / Заголовок','id' => 'id'.$tab])->label(false) ?>
	</div>
	<div class="col-md-2" style="padding-right:0px;">
    	<?= $form->field($model, 'user_id')->textInput(['placeholder' => 'ID / E-mail пользавателья','id' => 'user_id'.$tab])->label(false) ?>
	</div>
	<div class="col-md-2" style="padding-right:0px;">
    	<?= $form->field($model, 'shop_id')->textInput(['placeholder' => 'ID магазина','id' => 'shop_id'.$tab])->label(false) ?>
	</div>
    <div class="col-md-2" style="padding-right:0px;">
        <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Телефон','id' => 'id'.$tab])->label(false) ?>
    </div>



    <div class="col-md-4">
        <?=$form->field($model, 'begin_date')->widget(DatePicker::className(),
            [
                'type' => DatePicker::TYPE_RANGE,
                'attribute' => 'begin_date',
                'attribute2' => 'end_date',
                'options' => [
                    'id' => 'date-'.$tab,
                    'placeholder' => 'Дата',
                    'autoComplete' => 'off',
                ],
                'layout' => $layout,
                'options2' => [
                    'placeholder' => 'Публикация',
                    'autoComplete' => 'off',
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy',
                    'todayHighlight' => true,
                ],
            ]
        )->label(false)?>
    </div>
</div>
<div class="row">
    <div class="col-md-2" style="padding-right:0px;">
        <?= $form->field($model, 'service_id')->widget(Select2::classname(), [
            'data' => $model->getServicesList(),
            'options' => [
                'placeholder' => 'Услуга',
                'id' => 'service_id-'.$tab
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])->label(false);?>
    </div>
    <div class="col-md-2" style="padding-right:0px;">
        <?= $form->field($model, 'cat_id')->widget(Select2::classname(), [
            'data' => $model->getCategoryList(),
            'options' => [
                'placeholder' => 'Все разделы',
                'id' => 'cat_id-'.$tab
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true
            ],
        ])->label(false);?>
    </div>
    <div class="col-md-2" style="padding-right:0px;">
        <?= $form->field($model, 'district_id')->widget(Select2::classname(), [
            'data' => $model->getRegionsList(),
            'options' => [
                'placeholder' => 'Регион',
                'id' => 'district_id-'.$tab
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true
            ],
        ])->label(false);?>
    </div>
    <div class="col-md-2" style="width: 11%">
        <?= $form->field($model, 'paid')->checkbox(['id' => 'paid'.$tab,'label'=>'Платные']); ?>
    </div>

    <div class="col-md-1">
        <?= $form->field($model, 'your_own')->checkbox(['id' => 'your_own'.$tab,'label'=>'Своя']); ?>
    </div>
    <div class="col-md-1" style="padding-right:0px;">
        <div class="btn-group">
            <?= Html::submitButton('найти', ['class' => 'btn btn-success']) ?>
            <!--			<button type="button" class="btn btn-white active" onclick="refresh()"><i class="fa fa-refresh"></i></button>-->
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
