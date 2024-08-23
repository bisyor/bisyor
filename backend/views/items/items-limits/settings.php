<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
	
?>
<?php $form = ActiveForm::begin(['action' => '/items/items-limits/change-settings' , 'method' => 'post']); ?>
	<div class="row">
		<div class="col-md-1">
			 <label for="" style="margin-top: 7px;"><b>Период</b></label>
		</div>
		<div class="col-md-2">
			  <?= $form->field($settings, 'value')->textInput(['type' => 'number'])->label(false) ?>
		</div>
		<div class="col-md-2">
			 <label for="" style="margin-top: 7px;"><b><?= $settings->name?></b></label>
		</div>
	</div>
	<?= Html::submitButton( 'Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>