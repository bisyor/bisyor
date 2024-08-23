<?php
use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\switchery\Switchery;

/* @var $this yii\web\View */
/* @var $model backend\models\blogs\BlogPosts */
/* @var $form yii\widgets\ActiveForm */

$i = 0;
$templateInput = '<div class="col-md-12">{label}{input}{error}</div><div class="col-md-4">{hint}</div>';

$templateInput_2 = '<div class="row"><div class="col-md-1">
                            {label}</div><div class="col-md-8">{input}{error}</div></div>
                            ';
?>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Пост</h4>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin([ 'options' => ['method' => 'post', 'enctype' => 'multipart/form-data']]); ?>
            <div class="row">
                <div class="col-md-12">
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
                                        <div class="col-md-4">
                                            <div id="image" class="col-md-12">
                                                <?=Html::img($model->getAvatar(), [
                                                    'class'=>'img-thumbnail',
                                                    'style' => 'object-fit: cover; width:300px; height:220px; ',
                                                ])?>
                                            </div> 
                                            <div class="col-md-12">
                                            <?= $form->field($model, 'images')->fileInput(['class'=>"image_input", 'accept'=> 'image/*', 'style' => ['display' => 'none']])->label("Загрузить", ['class' => 'btn btn-info','style' => ['margin-top' => '22px', 'width' => '300px', 'padding' => '6px 65px']]) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <?= $form->field($model, 'blog_categories_id')->widget(Select2::classname(), [
                                                'data' => $model->getCategoriesList(),
                                                'language' => 'ru',
                                                'options' => ['placeholder' => 'Выберите категорию ...'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ]) ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                                        </div>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'short_text')->textarea(['rows' => 4]) ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?= $form->field($model, 'status')->widget(Switchery::className(), [
                                                    'options' => [
                                                    'label' => false
                                                ],
                                                    'clientOptions' => [
                                                        'color' => '#5fbeaa',
                                                    ]
                                                ])->label();?>
                                            </div>
                                            <div class="col-md-6">
                                                <?= $form->field($model, 'tags',['template' => $templateInput_2])->widget(Select2::classname(), [
									                'data' => $model->getTagsList(),
									                'options' => ['placeholder' => 'Выберите теги'],
									                'pluginOptions' => [
                                                        'tags' => true,
									                    'allowClear' => true,
									                    'multiple' => true
									                ],
									            ]);?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?= $form->field($model, 'text',['template' => $templateInput])->widget(TinyMce::className(), [
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
                                            ])->label("Описание") ?>
                                        </div>
                                    </div>
         
                                <?php else: ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?= $form->field($model, 'translation_name['.$lang->url.']')->textInput(['value' => isset($translation_name[$lang->url]) ? $translation_name[$lang->url] : null])->label(Yii::t('app','Nomi', null, $lang->url)) ?>                                    
                                        </div>
                                        <div class="col-md-12">
                                            <?= $form->field($model, 'translation_short_text['.$lang->url.']')->textArea([ 'rows' => '4', 'value' => isset($translation_short_text[$lang->url]) ? $translation_short_text[$lang->url] : null])->label(Yii::t('app','Qisqacha mazmuni', null, $lang->url)) ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?php //if(!$model->isNewRecord) $model->translation_text[$lang->url] = $translation_text[$lang->url]; ?>
                                            <?= $form->field($model, 'translation_text['.$lang->url.']',['template' => $templateInput])->widget(TinyMce::className(), [
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
                                            ])->label("Описание") ?>
                                        </div>
                                    </div>
                                <?php endif;?>    
                            </p>
                         </div>
                        <?php $i++; endforeach;?>
                        <?php if (!Yii::$app->request->isAjax){ ?>
                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                <?= Html::a('<i class="fa fa-angle-double-left"></i> Назад', ['/blogs/blog-posts/index'], ['data-pjax'=>'0','title'=> 'Назад','class'=>'btn btn-inverse']) ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
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
                var template = '<img style="width:300px; height:220px; object-fit: cover;" class="img-thumbnail"  src="'+e.target.result+'"> ';
                $('#image').html('');
                $('#image').append(template);
            };
        });
    });   
});
JS
);
?>