<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="chats-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'message')->textArea(['rows' => 4]) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    
</div>