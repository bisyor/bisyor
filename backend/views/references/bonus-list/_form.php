<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\references\BonusList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bonus-list-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'bonus')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'keyword')->textInput(['maxlength' => true, 'disabled' => !$model->isNewRecord]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div id="image" class="col-md-12">
                <?=Html::img($model->getAvatar(), [
                    'class'=>'img-thumbnail',
                    'style' => 'object-fit: cover; width:300px; height:220px; ',
                ])?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'images')->fileInput(['class'=>"image_input", 'accept'=> 'image/*', 'style' => ['display' => 'none']])->label("Загрузить", ['class' => 'btn btn-info','style' => ['margin-top' => '22px', 'width' => '300px', 'padding' => '6px 65px']]) ?>
            </div>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->widget(\dosamigos\switchery\Switchery::className(), [
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
