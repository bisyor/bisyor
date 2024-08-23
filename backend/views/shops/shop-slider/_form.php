<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\shops\ShopSlider;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopSlider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-slider-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        $template = '<div class="row"><div class="col-md-2">
                {label}</div><div class="col-md-9">{input}{error}</div></div>
                ';
    ?>
    <?= $form->field($model, 'title',['template' => $template])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text',['template' => $template])->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'link',['template' => $template])->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => 'www.*{1,30}.*{1,5}',
            ]) ?>
    <?php
        $input = '<label for="avatar" title="Выберите" data-toggle="tooltip" id="image_label" onmousemove="style.cursor=\'pointer\'">'.$model->getImg('200px','200px').'</label>
        <input type="file" name="" id="avatar" style="display: none;" accept="image/*">';
        $template = '<div class="row"><div class="col-md-2">
                {label}</div><div class="col-md-9">{input}'.$input.'{error}</div></div>
                ';
    ?>
    <?= $form->field($model, 'img',['template' => $template])->hiddenInput(['id' => 'temp_address','value' => $model->image]) ?>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

</div>

<?php
$dirname = ShopSlider::DIR_NAME;

$this->registerJs(<<<JS
    $("#avatar").on('change',function(e){
        var file = $( '#avatar' )[0].files[0];
        var data = new FormData();

        var d = new Date();
        var new_name = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate() + '_' +d.getHours() + '-' + d.getMinutes() + '-' + d.getSeconds();
        var filename = file.name;
        name = filename.split('.').shift();
        var ext = filename.split('.').pop();
        new_name = name + '(' + new_name + ")." + ext;
        data.append('file[]', file) ;
        data.append('dir_name', '$dirname') ;
        data.append('names[]', new_name);
        data.append('old_image', $("#temp_address").val());
        $("#temp_address").val(new_name);

        $.ajax({
            url: '/shops/shop-categories/upload-image',
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function(success){
                $("#count_files").val(1);
                $("#image_label img").attr('style','width:200px;height:200px');
                $("#image_label img").attr('src',success);
            },
            error: function(success){
                alert("Error occur uploading image. Try again )");
                $("#image_label img").attr('src','/uploads/noimg.jpg');
            },
            //Do not cache the page
            cache: false,

            //@TODO start here
            xhr: function() {  // custom xhr
                myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    $("#image_label img").attr('src','/uploads/zz.gif');
                    return myXhr;
                }
            }
        });
    });
JS
)
?>
