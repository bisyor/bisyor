<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/**
 * @var $searchModel
 */
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
<span class="input-group-addon">Диапазон: </span>
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

    <div class="col-md-2">
        <div class="form-group" >
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
