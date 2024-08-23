<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SocialNetworks */
/* @var $form yii\widgets\ActiveForm */
if (!file_exists('uploads/social_icons/' . $model->icon) || $model->icon == null) {
    $path = '/backend/web/img/nouser.png';
} else {
    $path = '/backend/web/uploads/social_icons/'.$model->icon;
}
?>

<div class="social-networks-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
    	<div class="col-md-6">
    		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    	</div>
    	<div class="col-md-6">
		    <?= $form->field($model, 'image')->fileInput(['class'=>"image_input", 'accept'=> 'image/*', 'style' => ['display' => 'none']])->label("Загрузить иконка", ['class' => 'btn btn-info', 'style' => ['margin-top' => '22px', 'padding' => '6px 60px']]) ?>
    	</div>
    </div>
    <div class="row">
    	<div id="image" class="col-md-2">
	            <?=Html::img($path, [
	                'class'=>'img-thumbnail',
	                'style' => 'object-fit: cover; width:60px; height:60px; ',
	            ])?>
	    </div>
	    <div class="col-md-6"></div>
    	<div class="col-md-4">
    		<?= $form->field($model, 'status')->checkbox()->label('',['style' => ['margin-top' => '25px']]) ?>
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

    $(document).on('change', '.image_input', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:60px; height:60px; object-fit: cover;" class="img-thumbnail"  src="'+e.target.result+'"> ';
                $('#image').html('');
                $('#image').append(template);
            };
        });
    });   
});
JS
);
?>
