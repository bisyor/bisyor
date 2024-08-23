<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Восстановление пароля';

$fieldOptions1 = [
    'options' => ['class' => 'form-group m-b-20'],
    'inputTemplate' => "{input}"
];

?>
<div class="login login-v2">
    <!-- begin brand -->
    <div class="login-header">
        <div class="brand">
            <span class="logo"></span> <?=Yii::$app->name?>
            <small>Восстановление пароля</small>
        </div>
        <div class="icon">
            <i class="fa fa-sign-in"></i>
        </div>
    </div>
    <!-- end brand -->
    <div class="login-content">
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false], $options = ['class' => 'margin-bottom-0']); ?>
        <?= $form
            ->field($model, 'email', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('email'), 'class' => 'form-control input-lg']) ?>
        <div class="login-buttons">
            <?= Html::submitButton('Отпиравыть', ['class' => 'btn btn-success btn-block btn-lg', 'name' => 'login-button']) ?>
            <div class="col-md-12 text-center  voyti-a">
                <a href="/admin/site/login" class="btn">Войти</a>
            </div>

        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

