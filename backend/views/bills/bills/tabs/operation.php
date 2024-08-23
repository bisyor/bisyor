<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
	<div  style="text-align: left;">
		<a href="/bills/bills?BillsSearch[user_id]=<?=$user_id?>">Списать со счета <?=$operation->user_id?> указанную сумму</a>
    </div>
    <br>
	<div class="row">
		<div class="col-md-1">
			<label>Сумма</label>
		</div>
		<div class="col-md-3">
			<?= $form->field($operation, 'price')->textInput(['placeholder' =>'Минимальная цена 1000 сумов.' , 'id'=>'operationCurrency'])->label(false)?>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-1">
			<label>Описания</label>
		</div>
		<div class="col-md-6">
			<?= $form->field($operation, 'description')->textInput(['value'=>'Списание со счета'])->label(false)?>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-4">
			<?= $form->field($operation, 'notification')->checkbox(['label' => 'Отправлять уведамление пользователю'])?>
		</div>
	</div>	
	<br>
	<?= Html::submitButton('Сохранить' , ['class' =>'btn btn-success']) ?>
<?php ActiveForm::end(); ?>

<?php
$this->registerJs(<<<JS
    
$(document).ready(function(){
    $('#operationCurrency').on('blur, focus, keyup , change',
    function() {
        formatCurrency($('#operationCurrency'));
    });
});
JS
);
?>
