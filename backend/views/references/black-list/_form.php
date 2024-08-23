<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\switchery\Switchery;

/* @var $this yii\web\View */
/* @var $model backend\models\references\BlackList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="black-list-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">
        <div class="col-md-12">
	    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	   </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'enabled')->widget(Switchery::className(), [
                'options' => [
                    'label' => false
                ],
                'clientOptions' => [
                    'color' => '#5fbeaa',
                ]
            ])->label();?>
        </div>
    </div>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
