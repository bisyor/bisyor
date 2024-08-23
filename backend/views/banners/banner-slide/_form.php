<?php

use backend\models\references\Lang;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\switchery\Switchery;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;

$this->title = "Элементы баннера";
$this->params['breadcrumbs'][] = ['label' => "Элементы баннера", 'url' => ['/banners/banner/view?id=' . $model->banner_id]];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Создать' : 'Изменить';
?>

<div class="panel panel-inverse user-index">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
            <h4 class="panel-title">Элементы баннера</h4>
        </div>
        <div class="panel-body" style="margin: 10px 25px;">
        <?php $form = ActiveForm::begin(); ?> 
            <div class="row">
                 <div class="col-md-4">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'type')->dropDownList($model->getTypeList(),[]) ?>
                </div>
                <div class="col-md-4"  id="url" <?= $model->type == $model::TYPE_GOOGLE_ADS  ? 'style="display:none"' : ''?>>
                    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-4"  id="sort_type" <?= $model->type != $model::TYPE_GOOGLE_ADS  ? 'style="display:none"' : ''?>>
                    <?= $form->field($model, 'sort_type')->dropDownList($model->getSortTypeList(),[]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6" id="description" <?= $model->type == $model::TYPE_GOOGLE_ADS  ? 'style="display:none"' : ''?>>
                    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
                </div> 
                <div class="col-md-6" id="url_match" <?= $model->type == $model::TYPE_GOOGLE_ADS  ? 'style="display:none"' : '' ?>>
                    <?= $form->field($model, 'url_match')->textarea(['rows' => 3]) ?>
                </div> 
            </div> 

            <div class="row">
                <div class="col-md-4">  
                    <?= $form->field($model, 'show_start')->widget(DatePicker::className(), [
                        'language' => 'ru',
                        'clientOptions' => [
                            'format' => 'dd.mm.yyyy',
                            'autoclose' => true
                        ]
                    ])?> 
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'show_finish')->widget(DatePicker::className(), [
                        'language' => 'ru',
                        'clientOptions' => [
                            'format' => 'dd.mm.yyyy',
                            'autoclose' => true
                        ]
                    ])?> 
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'alt')->textInput(['maxlength' => true]) ?>
                </div>
            </div>  
          
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'show_limit')->textInput(['type' => 'number']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'sorting_number')->textInput(['type' => 'number']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'lang_code')->dropDownList(
                        array_column(Lang::getLanguagesForHeader(), 'local', 'url')
                    ); ?>
                </div>
        <!--        <div class="col-md-4">-->
        <!--            --><?//= $form->field($model, 'time')->textInput(['type' => 'number']) ?>
        <!--        </div>-->
            </div>

            <div class="row">
                <div class="col-md-6">

                    <div class="" id="code" <?= ($model->type == $model::TYPE_CODE || $model->type == $model::TYPE_GOOGLE_ADS) ? '' : 'style="display:none;"' ?> >
                        <?= $form->field($model, 'type_data')->textarea(['rows' => 6]) ?>
                    </div>

                    <div id="image" class="col-md-12" <?=$model->type == $model::TYPE_IMAGE ? '' : 'style="display:none;"' ?>>
                        <?=Html::img($model->getImgPath(), [
                            'class'=>'img-thumbnail',
                            'style' => 'object-fit: cover; width:200px; height:145px; ',
                        ])?>
                    </div> 
                    <div class="col-md-12" id="image-button" <?=$model->type == $model::TYPE_IMAGE ? '' : 'style="display:none;"' ?> >
                        <?= $form->field($model, 'images')->fileInput(['class'=>"image_input", 'accept'=> 'image/*', 'style' => ['display' => 'none']])->label("Загрузить", ['class' => 'btn btn-info','style' => ['margin-top' => '30px', 'padding' => '7px 70px']]) ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="col-md-12">
                        <?= $form->field($model, 'keyword')->dropDownList($model->getKeyList(),[]) ?>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($model, 'url_match_exact')->widget(Switchery::className(), [
                                'options' => [
                                'label' => false
                            ],
                                'clientOptions' => [
                                'color' => '#5fbeaa',
                            ]
                        ])->label();?>
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
                    <div class="col-md-12">
                        <?= $form->field($model, 'target_blank')->widget(Switchery::className(), [
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
          
            <?php if (!Yii::$app->request->isAjax){ ?>
                <div class="form-group">
                     <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                       <?= Html::a('<i class="fa fa-angle-double-left"></i> Назад', ['/banners/banner/view' ,'id'=>$model->banner_id], ['data-pjax'=>'0','title'=> 'Назад','class'=>'btn btn-inverse']) ?>
                </div>
            <?php } ?>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php 
$this->registerJs(<<<JS

    $('select#bannersitems-type').on('change', function(){  
        var value = this.value;
        $('#code').hide();
        $('#image').hide();
        $('#image-button').hide();
        
        if(value == 1) {
            $('#image').show();
            $('#image-button').show();
        }
        
        if(value == 4){
             $('#description').hide();
              $('#url_match').hide();
              $('#url').hide();
              $('#sort_type').show();
        } else {
             $('#description').show();
              $('#url_match').show();
              $('#url').show();
              $('#sort_type').hide();
        }
        if(value == 3 || value == 4) $('#code').show();
    });

JS
);
?>

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
