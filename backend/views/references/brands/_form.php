<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\switchery\Switchery;

/* @var $this yii\web\View */
/* @var $model app\models\Brands */
/* @var $form yii\widgets\ActiveForm */
if (!file_exists('uploads/brands/' . $model->image) || $model->image == null) {
    $path = '/backend/web/uploads/noimg.jpg';
} else {
    $path = '/backend/web/uploads/brands/'.$model->image;
}
?>

<div class="brands-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-5">
            <div id="image" class="col-md-12">
                <?=Html::img($path, [
                    'class'=>'img-thumbnail',
                    'style' => 'object-fit: cover; width:200px; height:145px; ',
                ])?>
            </div> 
            <div class="col-md-12">
                <?= $form->field($model, 'images')->fileInput(['class'=>"image_input", 'accept'=> 'image/*', 'style' => ['display' => 'none']])->label("Загрузить", ['class' => 'btn btn-info','style' => ['margin-top' => '22px', 'padding' => '6px 60px']]) ?>
            </div>
        </div>
        <div class="col-md-7">
            <div class="col-md-12">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'sorting')->textInput(['type' => 'number']) ?>
            </div>
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
    </div>

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
                var template = '<img style="width:200px; height:145px; object-fit: cover;" class="img-thumbnail"  src="'+e.target.result+'"> ';
                $('#image').html('');
                $('#image').append(template);
            };
        });
    });   
});
JS
);
?>
