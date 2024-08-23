<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\items\ItemsScale */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-scale-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ball')->textInput() ?>

    <?= $form->field($model, 'minimum_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->widget(\dosamigos\switchery\Switchery::className(), [
        'options' => [
            'label' => false
        ],
        'clientOptions' => [
            'color' => '#5fbeaa',
        ]
    ])?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
