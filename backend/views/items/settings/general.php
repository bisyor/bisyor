<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-3">
            <b>Срок публикации объявления:</b>
        </div>
        <div class="col-md-1">
            <?= $form->field($model, "the_term_of_publication_of_the_announcement")->textInput(['type' => 'number'])->label(false)?>
        </div>
        <div class="col-md-1">
            <b>в днях</b>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-3">
            <b>Срок продления объявления:</b>
        </div>
        <div class="col-md-1">
            <?= $form->field($model, "the_term_of_ad_renewal_period_365")->textInput(['type' => 'number'])->label(false)?>
        </div>
        <div class="col-md-1">
            <b>в днях</b>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <b>Уведомлять пользователей о завершении публикации объявлений:</b>
        </div>
        <div class="col-md-1" >
            <?= $form->field($model, "notify_users_of_the_completion_of_publishing_ads_the_1_day")->checkbox(['label' => '<b >за 1 день</b>'])?>
        </div>
        <div class="col-md-1">
            <?= $form->field($model, "notify_users_of_the_completion_of_publishing_ads_the_2_day")->checkbox(['label' => '<b>за 2 день</b>'])?>
        </div>
        <div class="col-md-1">
            <?= $form->field($model, "notify_users_of_the_completion_of_publishing_ads_the_5_day")->checkbox(['label' => '<b>за 5 день</b>'])?>
        </div>
    </div>
    <br>
    <?= Html::submitButton('Сохранить' , ['class' =>'btn btn-success']) ?>
<?php ActiveForm::end(); ?>