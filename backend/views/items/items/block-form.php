<?php 
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin([]); ?>

<div class="row">
	<div class="col-md-12" style="padding-right:0px;">
	    <?= $form->field($model, 'blocked_status')->widget(Select2::classname(), [
            'data' => \backend\models\items\Items::BLOCKED_REASONS,
            'pluginOptions' => [
                'allowClear' => true,
            ],
	    ])->label(false);?>
	</div>
    <div class="col-md-12"  id="period" <?=($model->blocked_status !='Другая причина' || $model->blocked_status) ? 'style="display:none; padding-right:0px;"' : 'style="padding-right:0px;"'?>>
        <?= $form->field($model, 'blocked_reason')->textarea([]); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
$this->registerJs(<<<JS
    
$('select#items-blocked_status').on('change', function(){  
    var value = this.value;
    $('#period').hide();
    if(value == 'Другая причина') $('#period').show(1000);
});
JS);?>