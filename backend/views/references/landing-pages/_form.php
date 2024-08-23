<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use dosamigos\switchery\Switchery;

/**
 * @var $model
 * @var $langs
 */
$i = 0;
$this->params['breadcrumbs'][] = ['label' => "SEO"];
$this->params['breadcrumbs'][] = ['label' => "Посадочные страницы", 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Создать' : 'Изменить';
$templateInput = '<div class="col-md-12">{label}{input}{error}</div><div class="col-md-4">{hint}</div>';

?>

<div class="panel panel-inverse" data-sortable-id="ui-widget-1">
    <div class="panel-heading">
        <h4 class="panel-title">Посадочные страницы</h4>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" style="margin-top:2px;">
                        <?php foreach($langs as $lang):?>
                            <li class="<?= $i == 0 ? 'active' : '' ?>">
                                <a data-toggle="tab" href="#category<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
                            </li>
                        <?php $i++; endforeach;?>
                    </ul>
                    <div class="tab-content">
                        <?php $i = 0; foreach($langs as $lang): ?>
                         <div id="category<?=$lang->url?>" class="tab-pane fade <?=($i == 0) ? 'in active' : '' ?>">
                            <?php if($lang->url == 'ru'): ?>
                                <div class="row">
                                    <div class="col-md-2">
                                        <b><?=$model->attributeLabels()['landing_uri'];?></b>
                                    </div>
                                    <div class="col-md-8">
                                        <?= $form->field($model, 'landing_uri')->textInput(['maxlength' => true])->label(false); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                         <b><?=$model->attributeLabels()['original_uri'];?></b>
                                    </div>
                                    <div class="col-md-8">
                                        <?= $form->field($model, 'original_uri')->textInput(['maxlength' => true])->label(false); ?>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-2">
                                    <b><?=$model->attributeLabels()['title'];?></b>
                                </div>
                                <div class="col-md-8">
                                    <?= $form->field($model, 'mkeywords')->textInput([])->label(false) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <b><?=$model->attributeLabels()['mkeywords'];?></b>
                                </div>
                                <div class="col-md-8">
                                    <?= $form->field($model, 'mkeywords')->textArea(['rows'=>3])->label(false) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <b><?=$model->attributeLabels()['mdescription'];?></b>
                                </div>
                                <div class="col-md-8">
                                    <?= $form->field($model, 'mdescription')->textArea(['rows'=>3])->label(false) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <b><?=$model->attributeLabels()['mtitle'];?></b>
                                </div>
                                <div class="col-md-8">
                                    <?= $form->field($model, 'mtitle')->textInput([])->label(false) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <b><?=$model->attributeLabels()['titleh1'];?></b>
                                </div>
                                <div class="col-md-8">
                                    <?= $form->field($model, 'titleh1')->textInput([])->label(false) ?>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-2">
                                        <b><?=$model->attributeLabels()['seotext'];?></b>
                                    </div>
                                    <div class="col-md-8">
                                        <?= $form->field($model, 'seotext',['template' => $templateInput])->widget(\dosamigos\tinymce\TinyMce::className(), [
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
                                        ])->label(false)?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <div class="col-md-2">
                                        <b><?= Yii::t('app','Sarlavha', null, $lang->url)?></b>
                                    </div>
                                    <div class="col-md-8">
                                        <?= $form->field($model, 'translation_title['.$lang->url.']')->textInput(['value' => $trans_title[$lang->url]])->label(false) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <b><?= Yii::t('app','Kalit so\'zlar', null, $lang->url)?></b>
                                    </div>
                                    <div class="col-md-8">
                                        <?= $form->field($model, 'translation_mkeywords['.$lang->url.']')->textArea(['value' => $trans_mkeywords[$lang->url] ,'rows'=>3])->label(false) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <b><?= Yii::t('app','Matn', null, $lang->url)?></b>
                                    </div>
                                    <div class="col-md-8">
                                        <?= $form->field($model, 'translation_mdescription['.$lang->url.']')->textArea(['value' => $trans_mdescription[$lang->url] ,'rows'=>3])->label(false) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <b><?= Yii::t('app','Bread crumbs', null, $lang->url)?></b>
                                    </div>
                                    <div class="col-md-8">
                                        <?= $form->field($model, 'translation_mtitle['.$lang->url.']')->textInput(['value' => $trans_mtitle[$lang->url]])->label(false) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <b><?= Yii::t('app','Sarlavha H1', null, $lang->url)?></b>
                                    </div>
                                    <div class="col-md-8">
                                        <?= $form->field($model, 'translation_titleh1['.$lang->url.']')->textInput(['value' => $trans_titleh1[$lang->url]])->label(false) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <b><?= Yii::t('app','SEO matn', null, $lang->url)?></b>
                                    </div>
                                    <div class="col-md-8">
                                        <?= $form->field($model, 'translation_seotext['.$lang->url.']',['template' => $templateInput])->widget(\dosamigos\tinymce\TinyMce::className(), [
                                            'options' => [
                                                'rows' => 10,
                                                'value' => isset($trans_seotext[$lang->url]) ? $trans_seotext[$lang->url] : '',
                                            ],
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
                                        ])->label(false)?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <div class="">
                                    <div class="col-md-1">
                                        <b>Макросы</b>
                                    </div>
                                    <?php 
                                        $tags = [
                                            'site.title'
                                        ];
                                    ?>
                                    <div class="">
                                        <?php foreach ($tags as $key => $value): ?>
                                            <button type="button" class="btn btn-xs btn-default tag"><?=$value?></button>
                                        <?php endforeach ?>
                                    </div>                        
                                </div>
                            </div>
                        </div>
                        <?php $i++; endforeach;?>
                        
                    </div>
                </div>
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
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <a href="/references/landing-pages" title="" class="btn btn-inverse">Назад</a>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>