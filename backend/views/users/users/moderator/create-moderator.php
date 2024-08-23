<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Users */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="users-form">

    <?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>
    <div class="row">
        <div class="col-md-4">
            <div id="image" class="col-md-12">
                <?=Html::img($model->getAvatar(), [
                    'style' => 'width:200px; height:200px;object-fit: cover;',
                    'class'=>'img-circle',
                ])?>
            </div>
            <br>
            <div class="col-md-12">
               <?= $form->field($model, 'image')->fileInput(['class'=>"image_input", 'accept'=> 'image/*']); ?>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>  
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'autocomplete' => false]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $model->isNewRecord ? $form->field($model, 'password')->passwordInput(['maxlength' => true, 'class' => 'form-control']) : $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
                      'mask' => '+\9\9899-999-99-99',
                     'options' => [
                          'placeholder' => '+998-99-999-99-99',
                         'class'=>'form-control',
                     ]
                    ]) ?>
                </div>            
            </div>
            <div class="row">                 
                <div class="col-md-12">
                    <label for="roles">Выберите роли</label>
                    <?= Select2::widget([
                        'name' => 'roles',
                        'data' => $model->getRoles('moderator'),
                        'language' => 'ru',
                        'options' => [
                            'multiple'=> true,
                            'placeholder' => 'Выберите роль ...',
                            'autocomplete' => 'off',
                            'aria-required' => true
                        ],
                        'pluginOptions' => [
                            'initialize' => true,
                            'allowClear' => false,
                        ],
                    ]) ?>                            
                </div>
            </div>
        </div>
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php 
$this->registerJs(<<<JS
    
$(document).ready(function(){
    var fileCollection = new Array();
    $("#roles").attr("aria-required", true);

    $(document).on('change', '.image_input', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:200px; height:200px; object-fit: cover;" class="img-circle"  src="'+e.target.result+'"> ';
                $('#image').html('');
                $('#image').append(template);
            };
        });
    });
});
JS
);
?>