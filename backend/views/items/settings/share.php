<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
	<?= $form->field($share, "value")->textarea(['rows'=>12])->label(false)?>
	<br>
	<?= Html::submitButton('Сохранить' , ['class' =>'btn btn-success']) ?>
<?php ActiveForm::end(); ?>