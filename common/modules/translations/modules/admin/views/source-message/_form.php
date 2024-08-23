<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<div class="col-md-8">

    <div class="panel panel-default">
        <div class="panel-body source-message-form">

        <?php $form = ActiveForm::begin(); ?>
        
        <div class="row">
                <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="row">

            <div class="col-md-6">
                <?= $form->field($model, 'message')->textarea(['rows' => 6,'required'=>true]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'tr')->textarea(['rows' => 6,'required'=>true]) ?>
            </div>

        </div>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
