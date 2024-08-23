<?php 
use dosamigos\tinymce\TinyMce;
$i = 0;
?>
<div class="shops-shops-form" style="padding-right: 20px; padding-left: 20px; padding-top: 20px;">
    <?php 
        $templateInput = '<div class="row"><div class="col-md-2">
                    {label}{hint}</div><div class="col-md-8">{input}{error}</div></div>
                    ';
        Yii::$container->set('dosamigos\tinymce\TinyMce', [
            'language' => 'ru',
            'options' => ['rows' => 20],
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
                    'filemanager' => '/plugins/responsivefilemanager/filemanager/plugin.min.js',
                    'responsivefilemanager' => '/plugins/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js',
                ],
                'relative_urls' => false,
            ]
        ]);
    ?>

    <ul class="nav nav-pills" id="tab-1-nav">
        <?php foreach($langs as $lang):?>
            <li class="<?= $i == 0 ? 'active' : '' ?>">
                <a data-toggle="tab" href="#<?=$lang->url?>-tab-1"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
            </li>
        <?php $i++; endforeach;?>
    </ul>
    <br>
    <div class="tab-content panel-bg" id="tab-1-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
        <div id="ru-tab-1" class="tab-pane fade in">
            <?= $form->field($model, 'site_name',['template' => $templateInput])->textInput() ?>
            <?= $form->field($model, 'adminka',['template' => $templateInput])->textInput(['maxlength' => true])->hint('(Панель администратора)') ?>
            <?= $form->field($model, 'seo_site_name',['template' => $templateInput])->textInput(['maxlength' => true])->hint('(SEO)') ?>
            <?= $form->field($model, 'alert_site_name',['template' => $templateInput])->textInput(['maxlength' => true])->hint('(Уведомления)') ?>
            <?= $form->field($model, 'address',['template' => $templateInput])->textInput(['maxlength' => true])->hint('(Адрес)') ?>
            <hr>
            
            <?= $form->field($model, 'copyright',['template' => $templateInput])->widget(TinyMce::className()); ?>
            <?= $form->field($model, 'footer_text',['template' => $templateInput])->widget(TinyMce::className()); ?>
        </div>
        <?php $i = 0; foreach($langs as $lang): ?>
            <?php if ($lang->url == 'ru') continue; ?>
            <div id="<?=$lang->url?>-tab-1" class="tab-pane fade in">

                <?= $form->field($model, 'translation_site_name['.$lang->url.']',['template' => $templateInput])
                    ->textInput(['value' => isset($model->translation_site_name[$lang->url]) ? $model->translation_site_name[$lang->url] : null ]) ?>

                <?= $form->field($model, 'translation_adminka['.$lang->url.']',['template' => $templateInput])
                    ->textInput(['value' => isset($model->translation_adminka[$lang->url]) ? $model->translation_adminka[$lang->url] : null ])
                    ->hint('(Панель администратора)') ?>

                <?= $form->field($model, 'translation_seo_site_name['.$lang->url.']',['template' => $templateInput])
                    ->textInput(['value' => isset($model->translation_seo_site_name[$lang->url]) ? $model->translation_seo_site_name[$lang->url] : null ])
                    ->hint('(SEO)') ?>

                <?= $form->field($model, 'translation_alert_site_name['.$lang->url.']',['template' => $templateInput])
                    ->textInput(['value' => isset($model->translation_alert_site_name[$lang->url]) ? $model->translation_alert_site_name[$lang->url] : null])
                    ->hint('(Уведомления)') ?>

                <?= $form->field($model, 'translation_address['.$lang->url.']',['template' => $templateInput])
                    ->textInput(['value' => isset($model->translation_address[$lang->url]) ? $model->translation_address[$lang->url] : null])
                    ->hint('(Адрес)') ?>

                <hr>
                <?= $form->field($model, 'translation_copyright['.$lang->url.']',['template' => $templateInput])->widget(TinyMce::className()); ?>
                <?= $form->field($model, 'translation_footer_text['.$lang->url.']',['template' => $templateInput])->widget(TinyMce::className()); ?>
            </div>
        <?php $i++; endforeach;?>
    </div>
</div>

<?php 
    
$this->registerJS(<<<JS
    $("#ru-tab-1").addClass('active');
    $(document).ready(function(){
        $("#ru-tab-1").addClass('active');
    })
JS
)
?>