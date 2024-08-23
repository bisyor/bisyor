<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
use kartik\color\ColorInput;
use kartik\select2\Select2;
use bajadev\dynamicform\DynamicFormWidget;
use dosamigos\tinymce\TinyMce;
use backend\models\shops\Services;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopCategories */
/* @var $form yii\widgets\ActiveForm */

$i = 0;
$titles = $model->translation_title;
$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'Услуги', 'url' => ['/shops/services/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title"><?=$this->title?></h4>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'enableClientValidation'=>false,
            'enableAjaxValidation'=>false,
            'options' => [
                'enctype' => 'multipart/form-data',
                'id' => 'create-shop-services-form'
            ],
            'enableAjaxValidation'      => true,
            'enableClientValidation'    => false,
            'validateOnChange'          => true,
            'validateOnSubmit'          => true,
            'validateOnBlur'            => false,
        ]); ?>
        <div class="shops-abonements-form" style="padding-right: 20px; padding-left: 20px;">
            <div class="row">
                <?php
                    $templateInput = '<div class="row"><div class="col-md-2">
                        {label}</div><div class="col-md-10">{input}{error}</div><div class="col-md-4">{hint}</div></div>';
                ?>
                <ul class="nav nav-tabs" style="margin-top:2px;">
                    <?php foreach($langs as $lang):?>
                        <li class="<?= $i == 0 ? 'active' : '' ?>">
                            <a data-toggle="tab" href="#<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
                        </li>
                    <?php $i++; endforeach;?>
                </ul>
                <div class="tab-content" style="height: 60px;">
                    <?php $i = 0; foreach($langs as $lang): ?>
                    <div id="<?=$lang->url?>" class="tab-pane fade <?=($i == 0) ? 'in active' : '' ?>">
                        <p>
                            <?php if($lang->url == 'ru'): ?>
                                    <?= $form->field($model, 'title',['template' => $templateInput])->textInput() ?>
                                    <?= $form->field($model, 'short_description',['template' => $templateInput])->textarea(['rows' => 6]) ?>
                                    <?= $form->field($model, 'description',['template' => $templateInput])->widget(TinyMce::className(), [
                                        'options' => ['rows' => 10],
                                        'language' => 'ru',
                                        'clientOptions' => [
                                            'height' => '300',
                                            'plugins' => [
                                                'advlist autolink lists link charmap hr preview pagebreak',
                                                'searchreplace wordcount textcolor visualblocks visualchars code fullscreen nonbreaking',
                                                'save insertdatetime media table contextmenu template paste image responsivefilemanager filemanager',
                                            ],
                                            'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager link image media',
                                            'external_filemanager_path' => '/plugins/responsivefilemanager/filemanager/',
                                            'filemanager_title' => 'Responsive Filemanager',
                                            'external_plugins' => [
                                                //Иконка/кнопка загрузки файла в диалоге вставки изображения.
                                                'filemanager' => '/plugins/responsivefilemanager/filemanager/plugin.min.js',
                                                //Иконка/кнопка загрузки файла в панеле иснструментов.
                                                'responsivefilemanager' => '/plugins/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
                                            ],
                                            'relative_urls' => false,
                                        ]
                                    ]); ?>
                            <?php else: ?>
                                    <?= $form->field($model, 'translation_title['.$lang->url.']',['template' => $templateInput])->textInput(['value' => isset($titles[$lang->url]) ? $titles[$lang->url] : '' ]) ?>
                                    <?= $form->field($model, 'translation_short_description['.$lang->url.']',['template' => $templateInput])->textarea(['rows' => 6]) ?>
                                    <?= $form->field($model, 'translation_description['.$lang->url.']',['template' => $templateInput])->widget(TinyMce::className(), [
                                        'options' => ['rows' => 10],
                                        'language' => 'ru',
                                        'clientOptions' => [
                                            'height' => '300',
                                            'plugins' => [
                                                'advlist autolink lists link charmap hr preview pagebreak',
                                                'searchreplace wordcount textcolor visualblocks visualchars code fullscreen nonbreaking',
                                                'save insertdatetime media table contextmenu template paste image responsivefilemanager filemanager',
                                            ],
                                            'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager link image media',
                                            'external_filemanager_path' => '/plugins/responsivefilemanager/filemanager/',
                                            'filemanager_title' => 'Responsive Filemanager',
                                            'external_plugins' => [
                                                //Иконка/кнопка загрузки файла в диалоге вставки изображения.
                                                'filemanager' => '/plugins/responsivefilemanager/filemanager/plugin.min.js',
                                                //Иконка/кнопка загрузки файла в панеле иснструментов.
                                                'responsivefilemanager' => '/plugins/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
                                            ],
                                            'relative_urls' => false,
                                        ]
                                    ]); ?>
                            <?php endif;?>
                        </p>
                    </div>
                    <?php $i++; endforeach;?>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    <label><?= $model->getAttributeLabel('price') ?></label>
                </div>
                <div class="col-md-10">
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 10, // the maximum times, an element can be cloned (default 999)
                        'min' => 0, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelsRegionalPrices[0],
                        'formId' => 'create-shop-services-form',
                        'formFields' => [
                            'price',
                            'regions',
                            'sections'
                        ],
                    ]); ?>


                        <div class="row">
                            <div class="col-md-2">
                                <?= $form->field($model, 'price')->textInput(['class' => 'float_number_input form-control','placeholder' => 'сум'])->label(false)?>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="add-item btn btn-success btn-md"><i class="glyphicon glyphicon-plus"></i> добавить региональную стоимость</button>
                            </div>
                        </div>
                        <div class="container-items col-md-12">
                        <?php foreach ($modelsRegionalPrices as $i => $modelRegionalPrice): ?>
                            <div class="item row panel-bg-new">
                                <div class="col-md-11">
                                    <?php
                                        // necessary for update action.
                                        if (! $modelRegionalPrice->isNewRecord) {
                                            echo Html::activeHiddenInput($modelRegionalPrice, "[{$i}]id");
                                        }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <?= $form->field($modelRegionalPrice, "[{$i}]price")->textInput(['maxlength' => true,'class' => 'float_number_input form-control','placeholder' => 'сум']) ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?= $form->field($modelRegionalPrice, "[{$i}]regions")->widget(Select2::classname(), [
                                                'data' => $model->getRegionsList(),
                                                'options' => ['placeholder' => 'Выберите регионы'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'multiple' => true
                                                ],
                                            ]);?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                        <button type="button" style="position:absolute;top:-26px;right:-5px;" class="remove-item btn btn-danger btn-md btn-circle"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    <?php DynamicFormWidget::end(); ?>
                </div>
            </div>
            <br>
            <?php
                $templateInput = '<div class="row"><div class="col-md-2">
                    {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-4">{hint}</div></div>';
            ?>
            <?= $form->field($model, 'day',['template' => $templateInput])->textInput(['class' => 'number_input form-control'])->hint('дней') ?>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'img')->hiddenInput(['id' => 'temp_address'])->hint('128x128') ?>
                </div>
                <div class="col-md-10">
                    <label for="avatar" title="Выберите" data-toggle="tooltip" id="image_label" onmousemove="style.cursor='pointer'"><?=$model->getImg(false,'128px','128px')?></label>
                    <input type="file" name="" id="avatar" style="display: none;" accept="image/*">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'small_img')->hiddenInput(['id' => 'temp_address_small'])->hint('32x32') ?>
                </div>
                <div class="col-md-10">
                    <label for="avatar_small" title="Выберите" data-toggle="tooltip" id="image_label_small" onmousemove="style.cursor='pointer'"><?=$model->getImg(true,'32px','32px')?></label>
                    <input type="file" name="" id="avatar_small" style="display: none;" accept="image/*">

                </div>
            </div>
            <?php
                $templateInput = '<div class="row"><div class="col-md-2">
                            {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-4">{hint}</div></div>';
                $templateCheckbox = '<div class="row"><div class="col-md-2">
                            {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-6">{hint}</div></div>';
            ?>

            <?= $form->field($model, 'color',['template' => $templateInput])->widget(ColorInput::classname(), [
                    'value' => 'red',
                    'options' => ['placeholder' => 'Выберите'],
                    'pluginOptions' => [
                        'allowEmpty' => false,
                    ]
                ]);?>

            <?= $form->field($model, 'enabled',['template' => $templateCheckbox])->widget(CheckboxX::classname(),
                [
                    'pluginOptions'=>
                        [
                            'threeState'=>false
                        ],
                    'options'=>
                        [
                            'onchange' => "
                                element = $(this).parent('div').parent('div').next().children('div');
                                value = $(this).val();
                                if(value == 1){
                                    element.html('<span class=\'text text-success\'>Активно</span>');
                                }else{
                                    element.html('<span class=\'text text-danger\'>Неактивно</span>');
                                }
                            "
                        ]
            ])->hint(($model->enabled == 1) ? '<span class=\'text text-success\'>Активно</span>' : '<span class=\'text text-danger\'>Неактивно</span>'); ?>
        </div>

        <div class="panel-footer row text-right">
            <div class="form-group col-md-10">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    <button class="btn btn-inverse" type="button" onClick="history.back();">Отмена</button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php
$dirname = Services::DIR_NAME;
$this->registerJS(<<<JS

    $(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
        if (! confirm("Вы уверены что хотите удалить этого элемента?")) {
            return false;
        }
        return true;
    });

    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        $(".float_number_input").inputFilter(function(value) {
            return /^-?\d*[.]?\d{0,2}$/.test(value);
        });
    });

    $("#services-color").hide();

    $(".float_number_input").inputFilter(function(value) {
        return /^-?\d*[.]?\d{0,2}$/.test(value);
    });

    $(".number_input").inputFilter(function(value) {
      return /^\d*$/.test(value);
    });

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
                // dir = '/uploads/trash/' + new_name;
                $("#image_label img").attr('style','width:128px;height:128px');
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
        data.append('dir_name', '$dirname') ;
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
                $("#count_files").val(1);
                // dir = '/uploads/trash/' + new_name;
                $("#image_label_small img").attr('style','width:32px;height:32px');
                $("#image_label_small img").attr('src',success);
            },
            error: function(success){
                alert("Error occur uploading image. Try again )");
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