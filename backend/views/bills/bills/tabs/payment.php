<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id'=>'payment']); ?>
	<div  style="text-align: left;">
		<a href="/bills/bills?BillsSearch[user_id]=<?=$user_id?>">Пополнить со счета <?=$model->user_id?> указанную сумму</a>
    </div>
    <br>
	<div class="row">
		<div class="col-md-1">
			<label>Сумма</label>
		</div>
		<div class="col-md-3">
			<?= $form->field($model, 'price')->textInput(['placeholder' =>'Минимальная цена 1000 сумов.' , 'id' => 'currencyFormat'])->label(false)?>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-1">
			<label>Описания</label>
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'description')->textInput(['value' =>'Подарок от администрации'])->label(false)?>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'notification')->checkbox(['label' => 'Отправлять уведамление пользователю'])?>
		</div>
	</div>	
	<br>
	<?= Html::submitButton('Сохранить' , ['class' =>'btn btn-success']) ?>
<?php ActiveForm::end(); ?>


<?php
$this->registerJs(<<<JS
    
$(document).ready(function(){
    $('#currencyFormat').on('blur, focus, keyup , change',
    function() {
        formatCurrency($('#currencyFormat'));
    });
});
JS
);
?>
