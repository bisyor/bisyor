<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2; 

/* @var $this yii\web\View */
/* @var $model backend\models\BlogTags */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-tags-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'tag_id')->widget(Select2::classname(), [
            'data' => $model->getTagsList(),
            'language' => 'ru',
            'options' => ['placeholder' => 'Выберите тега ...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>
  
    	<?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
