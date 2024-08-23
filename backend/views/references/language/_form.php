<?php
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

?>

<div class="lang-form">
    <?php $form = ActiveForm::begin(); ?>
   
    <div class="row">
      <div class="col-md-6">
          <?= $form->field($model, 'url')->widget(\yii\widgets\MaskedInput::className(), ['mask' => 'aa','options'=>['placeholder'=>'ru']]) ?>
      </div>
      <div class="col-md-6">
         <?= $form->field($model, 'local')->textInput([]) ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
          <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'Русский']) ?>
      </div>
      <div class="col-md-6">
          <?= $form->field($model, 'status')->dropDownList($model->getStatus(), ['options'=>['0'=>['disabled'=>($model->default&& $model->id == 1)?true:false]]]); ?>
      </div>
      <div class="col-md-5">
          <?= $form->field($model, 'flag')->fileInput(['class'=>"image_input", 'accept'=> 'image/*']) ?>
      </div>
        <div id="image" class="col-md-3">
            <?=Html::img($model->getFlag(), [
                'style' => 'width:100px; height:100px;object-fit: cover;',
            ])?>
        </div>
        <?php if ($model->isNewRecord || $model->default == 0):?>
        <div class="col-md-4">
            <br>
            <?=$form->field($model, 'default')->checkbox()?>
        </div>
        <?php endif;?>
    </div>
  <?php if (!Yii::$app->request->isAjax){ ?>
      <div class="form-group">
          <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      </div>
  <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php
$this->registerJs(<<<JS
    
$(document).ready(function(){
    var fileCollection = new Array();

    $(document).on('change', '.image_input', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:100px; height:100px; object-fit: cover;"  src="'+e.target.result+'"> ';
                $('#image').html('');
                $('#image').append(template);
            };
        });
    });
});
JS
);
?>