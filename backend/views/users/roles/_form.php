<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;
/* @var $this yii\web\View */
/* @var $model backend\models\Roles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="roles-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <?php  if ($model->isNewRecord) {?>
            <div class="col-md-6">
                <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>
            </div>
        <?php } ?>
        <div class="col-md-6">          
            <?= $form->field($model, 'color')->widget(ColorInput::classname(), [
                'options' => ['placeholder' => 'Выберите цвет...'],
            ]); ?>
        </div>
        <div class="col-md-6" style="margin-top: 25px">
            <?= $form->field($model, 'admin_access')->checkbox()->label(false) ?>
        </div>
    </div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
