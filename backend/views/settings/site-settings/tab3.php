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
    <ul class="nav nav-pills">
        <?php foreach($langs as $lang):?>
            <li class="<?= $i == 0 ? 'active' : '' ?>">
                <a data-toggle="tab" href="#<?=$lang->url?>-tab-3"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
            </li>
        <?php $i++; endforeach;?>
    </ul>
    <br>
    <div class="tab-content panel-bg" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
        <div id="ru-tab-3" class="tab-pane fade in">
            <?= $form->field($model, 'contacts_form_title',['template' => $templateInput])->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'contacts_form_text',['template' => $templateInput])->widget(TinyMce::className()); ?>
            <?= $form->field($model, 'contacts_form_header',['template' => $templateInput])->textInput(['maxlength' => true]) ?>
        </div>
        <?php foreach($langs as $lang): ?>
            <?php if ($lang->url == 'ru') continue; ?>
            <div id="<?=$lang->url?>-tab-3" class="tab-pane fade in">
                <?= $form->field($model, 'translation_contacts_form_title['.$lang->url.']',['template' => $templateInput])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'translation_contacts_form_text['.$lang->url.']',['template' => $templateInput])->widget(TinyMce::className()); ?>
                <?= $form->field($model, 'translation_contacts_form_header['.$lang->url.']',['template' => $templateInput])->textInput(['maxlength' => true]) ?>
            </div>
        <?php endforeach;?>
    </div>
    
</div>

<?php 
    
$this->registerJS(<<<JS
    $("#ru-tab-3").addClass('active');
    $(document).ready(function(){
        $("#ru-tab-3").addClass('active');
    })
JS
)
?>

