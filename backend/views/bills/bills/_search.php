<?php

use backend\components\StaticFunction;
use backend\models\bills\Bills;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;;
use kartik\select2\Select2;
use backend\models\shops\Services;
?>
<?php $form = ActiveForm::begin([
        'method' => 'get',
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
    <div class="col-md-2">
        <?=$form->field($search, 'id')->textInput(['type' => 'number', 'placeholder' => '№ счета'])->label(false)?>
    </div>
    <div class="col-md-2">
        <?=$form->field($search, 'item_id')->textInput(['type' => 'number', 'placeholder' => 'ID объекта'])->label(false)?>
    </div>
    <div class="col-md-3">
        <?=$form->field($search, 'reg_from')->widget(DatePicker::className(),
            [
                'type' => DatePicker::TYPE_RANGE,
                'attribute' => 'reg_from',
                'attribute2' => 'reg_to',
                'options' => [
                    'placeholder' => 'От',
                    'autoComplete' => 'off',
                    ''
                ],
                'layout' => $layout,
                'options2' => [
                    'placeholder' => 'До',
                    'autoComplete' => 'off',
                    ''
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy',
                    'todayHighlight' => true,
                ],
            ]
        )->label(false)?>
    </div>
    <div class="col-md-3">
        <?=$form->field($search, 'user_phone')->textInput(['placeholder' => 'E-mail или телефон номер'])->label(false)?>
    </div>
    <div class="col-md-2">
        <?=$form->field($search, 'type')->widget(Select2::className(),
            [
                'data' =>  Bills::getType(),
                'language' => 'ru',
                'options' => ['placeholder' => 'Тип операции'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false)?>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <?=$form->field($search, 'service_id')->widget(Select2::className(),
            [
                'data' =>  StaticFunction::mapService(Services::find()->asArray()->all(), 'id', 'title'),
                'language' => 'ru',
                'options' => ['placeholder' => 'Услуга'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false)?>
    </div>
    <div class="col-md-3">
        <?=$form->field($search, 'psystem')->widget(Select2::className(),
            [
                'data' =>  Bills::getPaySystem(),
                'language' => 'ru',
                'options' => ['placeholder' => 'Тип платежа'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false)?>
    </div>

    <div class="col-md-1">
        <div class="form-group" >
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

