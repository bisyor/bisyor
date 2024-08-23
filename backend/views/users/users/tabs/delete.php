<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 ?>

<p>Siz rostdanam</p>
<?php $form = ActiveForm::begin() ?>
	<input type="text" name="delete" value="true">
	<a href="#" class="btn btn-inverse pull-left" data-dismiss="modal">Закрыть</a>
	<?= Html::submitButton('Ok' , ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end() ?>
