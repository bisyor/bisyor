<?php
use dosamigos\switchery\Switchery;
use dosamigos\tinymce\TinyMce;
$i=0;
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
    <?= $form->field($model, 'enabled',['template' => $templateInput])->widget(Switchery::className(), [
              'options' => [
                  'label' => false,
                  // 'onchange' => '
                  //   console.log(($(this).parent()).html())
                  //   '
              ],
              'clientOptions' => [
                  'color' => '#5fbeaa',
              ]
         ]);?>
    
    <div class="row">
        <div class="col-md-2">
            <br>
            <br>
            <br>
            <label><?=$model->getAttributeLabel('reason_block')?></label>
        </div>
        <div class="col-md-8">
            <ul class="nav nav-pills">
                <?php foreach($langs as $lang):?>
                    <li class="<?= $i == 0 ? 'active' : '' ?>">
                        <a data-toggle="tab" href="#<?=$lang->url?>-tab-2"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
                    </li>
                <?php $i++; endforeach;?>
            </ul>
            <div class="tab-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
                <div id="ru-tab-2" class="tab-pane fade in">
                    <?= $form->field($model, 'reason_block')->widget(TinyMce::className())->label(false); ?>
                </div>
                <?php $i = 0; foreach($langs as $lang): ?>
                    <?php if ($lang->url == 'ru') continue; ?>
                    <div id="<?=$lang->url?>-tab-2" class="tab-pane fade in">
                        <?= $form->field($model, 'translation_reason_block['.$lang->url.']')->widget(TinyMce::className())->label(false); ?>
                    </div>
                <?php $i++; endforeach;?>
            </div>
        </div>
    </div>
</div>
<?php 
    
$this->registerJS(<<<JS
    $("#ru-tab-2").addClass('active');
    $(document).ready(function(){
        $("#ru-tab-2").addClass('active');
    })
JS
)
?>

