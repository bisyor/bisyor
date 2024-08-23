<?php

use kartik\checkbox\CheckboxX;
use dosamigos\tinymce\TinyMce;
$i = 0;
$templateInput = '<div class="row"><div class="col-md-2">
            {label}</div><div class="col-md-8">{input}{hint}{error}</div></div>
            ';
?>

<ul class="nav nav-pills" id="tab-3-1-nav">
    <?php foreach($langs as $lang):?>
        <li class="<?= $i == 0 ? 'active' : '' ?>">
            <a data-toggle="tab" href="#<?=$lang->url?>-tab-3-1"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
        </li>
    <?php $i++; endforeach;?>
</ul>
<br>
<div class="tab-content" id="tab-3-1-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
    <div id="ru-tab-3-1" class="tab-pane active in">
        <?= $form->field($model, "mtitle",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;'])->hint("<div class='panel-bg-hint'>{category} {page} {region.in} на доске объявлений {site.title} </div>")?>
        <?= $form->field($model, "mkeywords",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{category} {page} , {region} , {site.title}</div>")?>
        <?= $form->field($model, "mdescription",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{meta-base}</div>")?>
        <?= $form->field($model, "breadcrumb",['template' => $templateInput])->textInput(['maxlength' => true])->hint("<div class='panel-bg-hint'>{category} {region.in}</div>")?>
        <?= $form->field($model, "titleh1",['template' => $templateInput])->textInput(['maxlength' => true])->hint("<div class='panel-bg-hint'>{category} {region.in}</div>")?>
        <?= $form->field($model, 'seotext',['template' => $templateInput])->widget(TinyMce::className(), [
                                        'options' => ['rows' => 10],
                                        'language' => 'ru',
                                        'clientOptions' => [
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
                                    ])->hint("<div class='panel-bg-hint'>Доска объявлений {site.title} {page} - ,бесплатные частные объявления {region.in} по темам: {categories}, куплю/продажа товаров, услуги и многое другое!</div>"); ?>
    </div>
    <?php $i = 0; foreach($langs as $lang): ?>
        <?php if ($lang->url == 'ru') continue; ?>
        <div id="<?=$lang->url?>-tab-3-1" class="tab-pane fade in">
            <?= $form->field($model, "translation_mtitle[".$lang->url."]",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;'])->hint("<div class='panel-bg-hint'>{category} {page} {region.in} на доске объявлений {site.title} </div>")?>
        
            <?= $form->field($model, "translation_mkeywords[".$lang->url."]",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{category} {page} , {region} , {site.title}</div>")?>
            <?= $form->field($model, "translation_mdescription[".$lang->url."]",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{meta-base}</div>")?>
            <?= $form->field($model, "translation_breadcrumb[".$lang->url."]",['template' => $templateInput])->textInput(['maxlength' => true])->hint("<div class='panel-bg-hint'>{category} {region.in}</div>")?>
            <?= $form->field($model, "translation_titleh1[".$lang->url."]",['template' => $templateInput])->textInput(['maxlength' => true])->hint("<div class='panel-bg-hint'>{category} {region.in}</div>")?>
            <?= $form->field($model, "translation_seotext[".$lang->url."]",['template' => $templateInput])->widget(TinyMce::className(), [
                                            'options' => ['rows' => 10],
                                            'language' => 'ru',
                                            'clientOptions' => [
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
                                        ])->hint("<div class='panel-bg-hint'>Доска объявлений {site.title} {page} - ,бесплатные частные объявления {region.in} по темам: {categories}, куплю/продажа товаров, услуги и многое другое!</div>"); ?>
        </div>
    <?php $i++; endforeach;?>
</div>

<hr>
<?= $form->field($model, "landing_url",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;'])?>

<div class="row">
    <div class="col-md-2">
        <label>Макросы</label>
    </div>
    <?php 
        $tags = [
            '{category}',
            '{category+parent}',
            '{parent.category}',
            '{categories}',
            '{categories.reverse}',
            '{total}',
            '{total.text}',
            '{region}',
            '{page}',
            '{site.title}'
        ];
    ?>
    <div class="col-md-6">
        <?php foreach ($tags as $key => $value): ?>
            <button type="button" style="margin-bottom: 10px;" class="btn btn-xs btn-default tag"><?=$value?></button>
        <?php endforeach ?>
        
    </div>

    <div class="col-md-3">
        <?php echo CheckboxX::widget([
            'name' => 'Categories[mtemplate]',
            'value' => $model->mtemplate,
            'labelSettings' => [
                'label' => 'использовать общий шаблон',
                'position' => CheckboxX::LABEL_RIGHT
            ],
           'pluginOptions'=>['threeState'=>false],
           'options' => [
                'onchange' => "
                    val = $(this).val();
                    if(val == 1){
                        $('.hint-block').show(100);
                    }else{
                        $('.hint-block').hide(100);
                    }
                "
           ]
        ]);
        ?>
    </div>
</div>
<hr>
