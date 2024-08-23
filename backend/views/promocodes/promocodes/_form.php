<?php

use backend\models\references\Regions;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use dosamigos\switchery\Switchery;
use yii\helpers\ArrayHelper;
use backend\models\promocodes\Promocodes;

$label = $model->attributeLabels();
/* @var yii\web\View $this */
/* @var backend\models\promocodes\Promocodes $model */
/* @var yii\widgets\ActiveForm $form */
?>

<div class="panel">
    <div class="panel-body">
        <div class="promocodes-form">

            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-3">
                    <?=$label['code']?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'code')->textInput(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?=$label['title']?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label(false) ?>
                </div>
                <div class="col-md-3">
                    Видно только вам
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?=$label['type']?>
                </div>
                <div class="col-md-6">
                    <?php ($model->isNewRecord && empty($model->type)) ? $model->type = 1 : $model->type; echo $form->field($model, 'type')->radioList(Promocodes::getTypeList())->label(false); ?>
                </div>
            </div>
            <div id="popolnena" <?= $model->type == 2 ? 'class="hide"' : 'class="show"'?>>
                <div class="row">
                    <div class="col-md-3">
                        <?=$label['usage_by']?>
                    </div>
                    <div class="col-md-6">
                        <?php
                        ($model->isNewRecord && empty($model->usage_by)) ? $model->usage_by = 1 : $model->usage_by;
                        echo $form->field($model, 'usage_by')->widget(Select2::classname(), [
                            'data' => Promocodes::getUsageByList(),
                            'language' => 'ru',
                            'hideSearch' => true,
                            'options' => ['placeholder' => 'Выберите...'],
                            'pluginOptions' => [
                                'allowClear' => false,
                            ],
                        ])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <?=$label['discount_type']?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        ($model->isNewRecord && empty($model->discount_type)) ? $model->discount_type = 1 : $model->discount_type;
                        echo $form->field($model, 'discount_type')->widget(Select2::classname(), [
                            'data' => Promocodes::getDiscountList(),
                            'language' => 'ru',
                            'hideSearch' => true,
                            'options' => ['placeholder' => 'Выберите...'],
                            'pluginOptions' => [
                                'allowClear' => false,
                            ],
                        ])->label(false); ?>
                    </div>
                    <div id="discount" class="col-md-3">
                        <?= $form->field($model, 'discount')->textInput(['type' => 'number', 'placeholder' => 'Размер скидки'])->label(false) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <?=$label['usage_for']?>
                    </div>
                    <div class="col-md-6">
                        <?php
                        ($model->isNewRecord && empty($model->usage_for)) ? $model->usage_for = 1 : $model->usage_for;
                        echo $form->field($model, 'usage_for')->widget(Select2::classname(), [
                            'data' => Promocodes::getUsageForList(),
                            'language' => 'ru',
                            'hideSearch' => true,
                            'options' => ['placeholder' => 'Выберите...'],
                            'pluginOptions' => [
                                'allowClear' => false,
                            ],
                        ])->label(false); ?>
                    </div>
                    <div class="col-md-3">
                        Кроме лимитов
                    </div>
                </div>
                <div id="service" <?= $model->usage_by == 2 ? 'class="row"' : 'class="row hide"'?>>
                    <div class="col-md-3">
                        <?=$label['service_id']?>
                    </div>
                    <div class="col-md-6">
                        <? $form->field($model, 'service_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\backend\models\shops\Services::find()->asArray()->all(), 'id', 'title'),
                            'language' => 'ru',
                            'hideSearch' => false,
                            'options' => ['placeholder' => 'Выберите...'],
                            'pluginOptions' => [
                                'allowClear' => false,
                            ],
                        ])->label(false) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <?=$label['category_list']?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'category_list')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\backend\models\items\Categories::find()->asArray()->all(), 'id', 'title'),
                            'language' => 'ru',
                            'hideSearch' => false,
                            'options' => [
                                'multiple' => true,
                                'placeholder' => 'Выберите...'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label(false) ?>
                    </div>
                </div>
            </div>
            <div id="amount" <?= $model->type == 2 ? 'class="row"' : 'class="row hide"'?>>
                <div class="col-md-3">
                    <?=$label['amount']?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'amount')->textInput(['type' => 'number'])->label(false) ?>
                </div>
                <div class="col-md-3">
                    В основной валюте сайта
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?=$label['regions_list']?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'regions_list')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Regions::find()->asArray()->all(), 'id', 'name'),
                        'language' => 'ru',
                        'options' => [
                            'placeholder' => 'Выберите',
                            'multiple' => true,
                        ],
                        'hideSearch' => false,
                        'pluginOptions' => [
                            'allowClear' => false,
                        ],
                    ])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?=$label['active']?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'active')->widget(Switchery::className(), [
                        'options' => [
                            'label' => false,
                        ],
                        'clientOptions' => [
                            'color' => '#5fbeaa',
                        ],
                    ])->label(false);?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <?=$label['active_to']?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'active_to')->widget(DatePicker::className(), [
                                'language' => 'ru',
                                'clientOptions' => [
                                    'format' => 'dd.mm.yyyy',
                                    'autoclose' => true
                                ]
                            ])->label(false) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?=$label['usage_limit']?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'usage_limit')->textInput(['type' => 'number'])->label(false) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    Эсли ни дата, ни кол-во срабатываний не указаны, то промокод действуйет бессрочно, пока не будет деактивирован вручную
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?=$label['is_once']?>
                </div>
                <div class="col-md-6">
                    <?php $model->is_once = 1; echo $form->field($model, 'is_once')->radioList(['1' => 'Один раз', '0' => 'Несколько раз'])->label(false); ?>
                </div>
            </div>
            <div id="break_days" <?= $model->is_once == 0 ? 'class="row"' : 'class="row hide"'?>>
                <div class="col-md-3">
                    <?=$label['break_days']?>
                </div>
                <div class="col-md-6">
                    <?php ($model->isNewRecord && empty($model->break_days)) ? $model->break_days = 1 : $model->break_days;
                    echo $form->field($model, 'break_days')->textInput(['type' => 'number'])->label(false); ?>
                </div>
                <div class="col-md-3">
                    Один раз в N дней
                </div>
            </div>

            <?php if (!Yii::$app->request->isAjax){ ?>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
                </div>
            <?php } ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$this->registerJs(<<<JS
    
$(document).ready(function(){
    $('input[name="Promocodes[type]"]').change(function() {
      if ($(this).val() == 2){
          $('#popolnena').removeClass('show').addClass('hide');
          $('#amount').removeClass('hide').addClass('show');
           $('select[name="Promocodes[usage_by]"]').val('1').change();
           $('select[name="Promocodes[discount_type]"]').val('').change();
           $('select[name="Promocodes[usage_for]"]').val('').change();
           $('input[name="Promocodes[discount]"]').val('');
      }else{
          $('#popolnena').removeClass('hide').addClass('show');
          $('#amount').removeClass('show').addClass('hide');
           $('input[name="Promocodes[amount]"]').val('');
      }
    });
    $('input[name="Promocodes[is_once]"]').change(function() {
        if($(this).val() == 0){
            $('#break_days').removeClass('hide').addClass('show');
        }else{
            $('#break_days').removeClass('show').addClass('hide');
            $('input[name="Promocodes[break_days]"]').val('1');
        }
    });
    $('select[name="Promocodes[discount_type]"]').change(function() {
       if($(this).val() == 3){
           $('#discount').removeClass('show').addClass('hide');
           $('input[name="Promocodes[discount]"]').val('');
       }else{
           $('#discount').removeClass('hide').addClass('show');
       }
    });
    $('select[name="Promocodes[usage_for]"]').change(function() {
       if($(this).val() == 2){
           $('#service').removeClass('hide').addClass('show');
           $('select[name="Promocodes[usage_by]"]').val('3').change();
       }else{
           $('#service').removeClass('show').addClass('hide');
       }
    });
});
JS
);
?>