<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\references\Redirects;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Currencies */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="redirect-form">
    <?php $form = ActiveForm::begin([ 'options' => ['method' => 'post']]); ?>
        <div class="tab-content">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'from_uri')->textInput()->label('Начинаюшая слова') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'to_uri')->textInput()->label('Добавляюшая слова') ?>
                </div>  
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>