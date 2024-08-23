<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\alerts\AlertsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alerts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'email')->checkbox() ?>

    <?= $form->field($model, 'sms')->checkbox() ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'key') ?>

    <?php // echo $form->field($model, 'key_title') ?>

    <?php // echo $form->field($model, 'key_text') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'subscription') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
