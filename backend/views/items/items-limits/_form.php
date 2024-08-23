<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\items\ItemsLimits */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-limits-form">

    <?php $form = ActiveForm::begin(); ?>


    <div id="cat-select">
        <div class="form-group">
            <?php if($model->isNewRecord):?>
                <?=$form->field($model, 'cat_id')->hiddenInput()?>
                <select name="category" class="form-control" onchange="select($(this).val())">
                    <option disabled selected>Выберите</option>
                    <?php
                    $category = \backend\models\items\Categories::find()->where(['parent_id' => 1])->orderBy(['id' => SORT_ASC])->asArray()->all();
                    foreach($category as $value):?>
                        <option value="<?=$value['id']?>"><?=$value['title']?></option>
                    <?php endforeach;?>
                </select>
            <?php else:
                echo "<b>Категория</b>: " .$model->category->title;
                endif;?>
        </div>
    </div>
    <?= $form->field($model, 'items')->textInput(['type' => 'number'])->label('Количество') ?>
    <?= $form->field($model, 'enabled')->checkbox(['label' => 'Включена']) ?>
    <div class="alert alert-info">
        В случае если вы добаляете категорю вллключенной - пересчет активных "платных пакетов" пользователей будет выполнен сразу же.
    </div>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php $this->registerJs(<<<JS
function select(value) {
    $('input[name="ItemsLimits[cat_id]"]').val(value);
   $.ajax({
        url: '/items/items-limits/select',
        type: 'POST',
        data: {id : value},
        success: function(data) {
            if(data){
               $('#cat-select').append('<div class="form-group"><select class="form-control" onchange="select($(this).val())">'+data+'</select></div>');
           }
        }
    });
 }
JS
);?>