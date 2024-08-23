<?php
/**
 * Created by PhpStorm.
 * User: Abdulloh Olimov
 * Date: 09.11.2020
 * Time: 11:15
 */

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model app\models\HelpsCategories */
/* @var $form yii\widgets\ActiveForm */
$i = 0;
?>

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills" style="margin-top:2px;">
            <?php foreach($langs as $lang):?>
                <li class="<?= $i == 0 ? 'active' : '' ?>">
                    <a data-toggle="tab" href="#mapregions<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
                </li>
            <?php $i++; endforeach;?>
        </ul>
        <div class="tab-content">
            <?php $i = 0; foreach($langs as $lang): ?>
             <div id="mapregions<?=$lang->url?>" class="tab-pane fade <?=($i == 0) ? 'in active' : '' ?>">
                <div class="row">
                    <div class="col-md-12">
                    	<?php $key = 'site_settings_mapregions_title_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textInput(['value' => $titles[$key] ])->label('Заголовок') ?>
                    </div>

                    <div class="col-md-12">
                        <?php $key = 'site_settings_mapregions_keyword_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textArea(['value' => $titles[$key], 'rows' => 3 ])->label('Ключевые слова') ?>
                    </div>

                    <div class="col-md-12">
                        <?php $key = 'site_settings_mapregions_description_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textArea(['value' => $titles[$key], 'rows' => 3 ])->label('Описание') ?>
                    </div>

                    <div class="col-md-12">
                        <?php $key = 'site_settings_mapregions_crumb_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textInput(['value' => $titles[$key] ])->label('Хлебная крошка') ?>
                    </div>

                    <div class="col-md-12">
                        <?php $key = 'site_settings_mapregions_titleh1_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textInput(['value' => $titles[$key] ])->label('Заголовок H1') ?>
                    </div>

                    <div class="col-md-12">
                        <?php $key = 'site_settings_mapregions_seotext_' . $lang->url;
                        $model->translation_name[$key] = $titles[$key]; ?>
                        <?= $form->field($model, 'translation_name['.$key.']',['template' => '<div class="col-md-12">{label}{input}{error}</div><div class="col-md-4">{hint}</div>'])->widget(TinyMce::className(), [
                            'options' => ['rows' => 10],
                            'language' => 'ru',
                            'clientOptions' => [
                                'height' => '150',
                                'plugins' => [
                                    'advlist autolink lists link charmap hr preview pagebreak',
                                    'searchreplace wordcount textcolor visualblocks visualchars code fullscreen nonbreaking',
                                    'save insertdatetime media table contextmenu template paste image responsivefilemanager filemanager',
                                ],
                                'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager link image media',
                                'external_filemanager_path' => '/plugins/responsivefilemanager/filemanager2/',
                                'filemanager_title' => 'Responsive Filemanager',
                                'external_plugins' => [
                                    //Иконка/кнопка загрузки файла в диалоге вставки изображения.
                                    'filemanager' => '/plugins/responsivefilemanager/filemanager/plugin.min.js',
                                    //Иконка/кнопка загрузки файла в панеле иснструментов.
                                    'responsivefilemanager' => '/plugins/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
                                ],
                                'relative_urls' => false,
                            ]
                        ])->label("SEO текст")?>
                    </div>


                    <div class="">
                        <div class="col-md-1">
                            <label>Макросы </label>
                        </div>
                        <?php
                            $tags = [
                                'site.title' => 'Название сайта - Bisyor.uz',
                            ];
                        ?>
                        <div class="">
                            <?php foreach ($tags as $key => $value): ?>
                                <button type="button" title="<?=$value?>" class="btn btn-xs btn-default tag"><?=$key?></button>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php $i++; endforeach;?>
        </div>
    </div>
</div>

<?php

$this->registerJs(<<<JS
    var prevFocus;

    $("input").on("focus",function() {
        prevFocus = $(this);
    });

    $("textarea").on("focus",function() {
        prevFocus = $(this);
    });

    $(".tag").on("click",function(){
        
        oldValue = prevFocus.val();
        arr = oldValue.split(' ');
        newValue = '{' + $(this).html() + '}';
        if(arr.indexOf(newValue) != -1){
            new_arr = arr.splice(arr.indexOf(newValue),1);
            console.log('deleted');
            console.log(new_arr);
        }else{
            arr.push(newValue);
            console.log('add');
            console.log(arr);
        }
        value = arr.join(' ');
        prevFocus.val(value);
    });

    $("div").each(function( index ) {
       $( this ).removeClass('form-group');
    });

JS
)
?>
