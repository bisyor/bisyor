<?php
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

?>

<div class="lang-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
      <div class="col-md-12">
         <?= $form->field($model, 'key')->textInput([]) ?>
      </div>
    </div>
    <div class="row">
      <?php $i = 0; foreach($langs as $lang): ?>
        <div class="col-md-12">
            <?= $form->field($model, 'translate['.$lang->url.']')->textInput(['maxlength' => true])->label('Перевести'.'_'.$lang->url) ?>
        </div>
      <?php endforeach; ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
