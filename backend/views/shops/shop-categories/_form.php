<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\shops\ShopCategories;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopCategories */
/* @var $form yii\widgets\ActiveForm */

$i = 0;
$titles = $model->translation_title;
?>

<div class="shop-categories-form">

    <?php $form = ActiveForm::begin([
        'options' =>
            [
                'enctype' => 'multipart/form-data',
                'id' => 'create-shop-categories-form'
            ]
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <label for="avatar" id="image_label" onmousemove="style.cursor='pointer'"><?=$model->getImg(false,'150px','150px')?></label>
            <input type="file" name="" id="avatar" style="display: none;" accept="image/*">
            <?= $form->field($model, 'img')->hiddenInput(['id' => 'temp_address']) ?>

            <br>

           <label for="avatar_small" id="image_label_small" onmousemove="style.cursor='pointer'"><?=$model->getImg(true,'70px','70px')?></label>
            <label><?= $model->getAttributeLabel('small_img')?></label>
            <input type="file" name="" id="avatar_small" style="display: none;" accept="image/*">
            <?= $form->field($model, 'small_img')->hiddenInput(['id' => 'temp_address_small'])->label(false) ?>
        </div>
        <div class="col-md-8">
            <ul class="nav nav-tabs" style="margin-top:2px;">
                <?php foreach($langs as $lang):?>
                    <li class="<?= $i == 0 ? 'active' : '' ?>">
                        <a data-toggle="tab" href="#<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
                    </li>
                <?php $i++; endforeach;?>
            </ul>
            <div class="tab-content">
                <?php $i = 0; foreach($langs as $lang): ?>
                 <div id="<?=$lang->url?>" class="tab-pane fade <?=($i == 0) ? 'in active' : '' ?>">
                    <p>
                        <?php if($lang->url == 'ru'): ?>
                            <div class="row">
                                <?= $form->field($model, 'title')->textInput(['required'=>true]) ?>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <?= $form->field($model, 'translation_title['.$lang->url.']')->textInput(['value' => isset($titles[$lang->url]) ? $titles[$lang->url] : null,'required'=>true ]) ?>
                            </div>
                        <?php endif;?>
                    </p>
                 </div>
                <?php $i++; endforeach;?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'enabled')->hiddenInput(['id' => 'status'])->label(false) ?>
                    <label>Статус</label>
                    <br>
                    <div id="checked">
                        <span class="switchery" style="background-color: rgb(0, 172, 172); border-color: rgb(0, 172, 172); box-shadow: rgb(0, 172, 172) 0px 0px 0px 16px inset; transition: border 0.5s ease 0s, box-shadow 0.5s ease 0s, background-color 1.5s ease 0s;"><small style="left: 20px; transition: left 0.25s ease 0s;"></small></span>
                        <span class="text-muted m-l-5 m-r-20">Активно</span>
                    </div>
                    <div id="unchecked">
                        <span class="switchery" onclick="" style="background-color: rgb(255, 255, 255); border-color: rgb(223, 223, 223); box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; transition: border 0.5s ease 0s, box-shadow 0.5s ease 0s;"><small style="left: 0px; transition: left 0.25s ease 0s;"></small></span>
                        <span class="text-muted m-l-5 m-r-20">Не Активно</span>
                    </div>
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
$dirname = ShopCategories::DIR_NAME;

$this->registerJs(<<<JS
    setStatus = function(){
        val = $("#status").val();
        if(val == 1){
            $("#checked").show();
            $("#unchecked").hide();
        }else{
            $("#unchecked").show();
            $("#checked").hide();
        }
    }
    setStatus();
    $("#status").on('change',setStatus());
    $("#checked").on('click',function(){
        $("#status").val(0);
        setStatus();
    })
    $("#unchecked").on('click',function(){
        $("#status").val(1);
        setStatus();
    })
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
        data.append('dir_name', '$dirname');
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
                // dir = '/uploads/trash/' + new_name;
                $("#image_label img").attr('style','width:150px;height:150px');
                $("#image_label img").attr('src',success);
            },
            error: function(success){
                alert(success);
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

    $("#avatar_small").on('change',function(e){
        var file = $( '#avatar_small' )[0].files[0];
        var data = new FormData();
        var d = new Date();
        var new_name = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate() + '_' +d.getHours() + '-' + d.getMinutes() + '-' + d.getSeconds();
        var filename = file.name;
        name = filename.split('.').shift();
        var ext = filename.split('.').pop();
        new_name = name + '(' + new_name + ")." + ext;
        data.append('file[]', file) ;
        data.append('dir_name', '$dirname');
        data.append('names[]', new_name);
        data.append('old_image', $("#temp_address_small").val());
        $("#temp_address_small").val(new_name);
        $.ajax({
            url: '/shops/shop-categories/upload-image',
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function(success){
                // dir = '/uploads/trash/' + new_name;
                $("#image_label_small img").attr('style','width:50px;height:50px');
                $("#image_label_small img").attr('src',success);
            },
            error: function(success){
                alert(success);
                alert("Error occur uploading image. Try again ((");
                $("#image_label_small img").attr('src','/uploads/noimg.jpg');
            },
            //Do not cache the page
            cache: false,

            //@TODO start here
            xhr: function() {  // custom xhr
                myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    $("#image_label_small img").attr('src','/uploads/zz.gif');
                    return myXhr;
                }
            }
        });
    });
JS
)
?>