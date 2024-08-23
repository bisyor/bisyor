<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;;
?>
<?php $form = ActiveForm::begin([
        'method' => 'post',
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
<div class="row">
    <div class="col-md-4">
        <?=$form->field($search, 'reg_from')->widget(DatePicker::className(),
            [
                'type' => DatePicker::TYPE_RANGE,
                'attribute' => 'reg_from',
                'attribute2' => 'reg_to',
                'options' => [
                    'placeholder' => 'От',
                    'autoComplete' => 'off',
                ],
                'layout' => $layout,
                'options2' => [
                    'placeholder' => 'До',
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
    <div class="col-md-2">
        <?=$form->field($search, 'user_count')->textInput(['type' => 'number', 'placeholder' => 'количество','min'=>0])->label(false)?>
    </div>
    <div class="col-md-1">
        <div class="form-group" >
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

