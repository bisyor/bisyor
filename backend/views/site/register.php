<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Регистрация';

$fieldOptions1 = [
    'options' => ['class' => 'form-group m-b-20'],
    'inputTemplate' => "{input}"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group m-b-20'],
    'inputTemplate' => "{input}"
];

?>
<style type="text/css">
.m-b-15 {
    margin-bottom: 0px !important; 
}
.control-label {
    color:   #d6d6c2 !important;
}
.voyti-a  a{
    color: #d6d6c2 !important;
}

.voyti-a a:hover {
    color: white !important;
}
</style>

    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade in hide"><span class="spinner"></span></div>
    <!-- end #page-loader -->
    
    <!-- begin #page-container -->
    <div id="page-container" class="">
        <!-- begin register -->
        <div class="register register-with-news-feed">
            <!-- begin news-feed -->
            <div class="news-feed">
                <div class="news-image">
                    <img src="assets/img/login-bg/bg-8.jpg" alt="">
                </div>
            </div>
            <!-- end news-feed -->
            <!-- begin right-content -->
            <div class="left-content col-md-7">
                <!-- begin register-header -->
                <h1 class="register-header" style="color: #d6d6c2;">
                    Регистрация
                </h1>
                <!-- end register-header -->
                <!-- begin register-content -->
                <div class="register-content">
                    <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false], $options = ['class' => 'margin-bottom-0']); ?>
                        <div class="row row-space-10">
                            <div class="col-md-12 m-b-15">
                                <label class="control-label"><?=$model->getAttributeLabel('fio')?> <span class="text-danger">*</span></label>
                                <?= $form->field($model, 'fio', $fieldOptions1)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('fio'), 'class' => 'form-control input-lg']) ?>
                            </div>
                        </div>
                        <div class="row m-b-15">
                            <div class="col-md-6 m-b-15">
                                <label class="control-label"><?=$model->getAttributeLabel('email')?> <span class="text-danger">*</span></label>
                                <?= $form->field($model, 'email', $fieldOptions1)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('email'), 'class' => 'form-control input-lg']) ?>
                            </div>
                            <div class="col-md-6 m-b-15">
                                <label class="control-label"><?=$model->getAttributeLabel('phone')?> <span class="text-danger">*</span></label>
                                <?= $form->field($model, 'phone', $fieldOptions1)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('phone'), 'class' => 'form-control input-lg']) ?>
                            </div>
                        </div>
                        <div class="row m-b-15">
                            <div class="col-md-6 m-b-15">
                                <label class="control-label"><?=$model->getAttributeLabel('login')?> <span class="text-danger">*</span></label>
                                <?= $form->field($model, 'login', $fieldOptions1)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('login'), 'class' => 'form-control input-lg']) ?>
                            </div>
                            <div class="col-md-6 m-b-15">
                                <label class="control-label"><?=$model->getAttributeLabel('password')?> <span class="text-danger">*</span></label>
                                <?= $form->field($model, 'password', $fieldOptions1)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('password'), 'class' => 'form-control input-lg']) ?>
                            </div>
                        </div>
                        <div class="row row-space-10">
                            <div class="col-md-12 m-b-15">
                                <label class="control-label"><?=$model->getAttributeLabel('name')?> <span class="text-danger">*</span></label>
                                <?= $form->field($model, 'name', $fieldOptions1)->label(false)->textInput(['placeholder' => $model->getAttributeLabel('name'), 'class' => 'form-control input-lg']) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="register-buttons">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg">Регистрация</button>
                                </div>
                            </div>
                            
                        </div>
                        <hr>
                        <div class="col-md-12 text-center  voyti-a">
                            <a href="/admin/site/login" class="btn">Войти</a>
                        </div>
                        <p class="text-center" style="color: #d6d6c2;">
                            © Progress Solution Technologies 2019
                        </p>
                    <?php ActiveForm::end(); ?>
                </div>
                <!-- end register-content -->
            </div>
            <!-- end right-content -->
        </div>
    </div>
        

  
