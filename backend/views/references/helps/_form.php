<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\Helps */
/* @var $form yii\widgets\ActiveForm */
$i = 0;

$templateInput = '<div class="col-md-12">{label}{input}{error}</div><div class="col-md-4">{hint}</div>';
?>

<div class="helps-form">
    <?php $form = ActiveForm::begin([ 'options' => ['method' => 'post',]]); ?>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <?php foreach($langs as $lang):?>
                    <li class="<?= $i == 0 ? 'active' : '' ?>">
                        <a data-toggle="tab" href="#<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
                    </li>
                <?php $i++; endforeach;?>
            </ul>
            <div class="tab-content">
                <div class="row">
                    <div class="col-md-8">
                        <?= $form->field($model, 'helps_categories_id')->widget(Select2::classname(), [
                            'data' => $model->getHelpsCategoriesList(),
                            'language' => 'ru',
                            'options' => ['placeholder' => 'Выберите категорию ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]) ?>

                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'sorting')->textInput(['type' => 'number']) ?>
                    </div>
                </div> 
                <?php $i = 0; foreach($langs as $lang): ?>
                 <div id="<?=$lang->url?>" class="tab-pane fade <?=($i == 0) ? 'in active' : '' ?>">
                    <p>
                        <?php if($lang->url == 'ru'): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
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
                                    ])->label('Описание')?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'translation_name['.$lang->url.']')->textInput(['value' => isset($names[$lang->url]) ? $names[$lang->url] : null ])->label(Yii::t('app','Nomi', null, $lang->url)) ?>
                                </div>
                                <?php if(!$model->isNewRecord) $model->translation_text[$lang->url] = isset($textes[$lang->url]) ? $textes[$lang->url] : null; ?>
                                <div class="col-md-12">
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
                                    ])->label(Yii::t('app','Text'))?>
                                </div>
                            </div>
                        <?php endif;?>    
                    </p>
                 </div>
                <?php $i++; endforeach;?>
        	<?php if (!Yii::$app->request->isAjax){ ?>
        	  	<div class="form-group">
        	        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    <?= Html::a('Назад', ['/references/helps/index', 'help_id' => $model->helps_categories_id],
                            ['dat-pjax'=>'0','title'=> 'Назад','class'=>'btn btn-inverse']) ?>
        	    </div>
        	<?php } ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>
    
</div>