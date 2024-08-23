<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\components\StaticFunction;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="users-form">

    <?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>
    <div class="row">
        <div class="col-md-12"><?= $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => StaticFunction::getStatus(),
            'language' => 'ru',
            'hideSearch' => false,
            'options' => ['id' => 'status', 'placeholder' => 'Выберите статус ...'],
            'pluginOptions' => [
                'allowClear' => false,
            ],
        ]) ?>
        </div>
        <div id="block_reason" <?=($model->status == 2 || $model->status == 3) ? 'class="col-md-12 show"' : 'class="col-md-12 hide"'?>><?= $form->field($model, 'block_reason')->textArea(); ?>
        </div>
    </div>  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
	    </div>
	<?php } ?>
    <?php ActiveForm::end(); ?>
</div>
<?php 
$this->registerJs(<<<JS
    
$(document).ready(function(){

    $(document).on('change', '#status', function(e){
        
        var status = $('#status').val();
        if(status == 2 || status == 3){
            $('#block_reason').removeClass("hide").addClass("show");
        }else{
            $('#block_reason').removeClass("show").addClass("hide");
        }
    });
});
JS
);
?>