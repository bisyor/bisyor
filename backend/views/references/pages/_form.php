<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\switchery\Switchery;

use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Pages */
/* @var $form yii\widgets\ActiveForm */
$i = 0;
$templateInput = '<div class="col-md-12">{label}{input}{error}</div><div class="col-md-4">{hint}</div>';
?>

<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Страницы</h4>
    </div>
    <div class="panel-body" style="padding: 0 !important; ">
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
                                    <div class="col-md-8">
                                        <div class="panel-inverse">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Информация</h4>
                                            </div>
                                            <div class="panel-body bg-silver">
                                                <div class="col-md-12"> 
                                                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                                                </div>
                                                <div class="col-md-12">
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
                                                    ])?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="panel-inverse">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Seo</h4>
                                            </div>
                                            <div class="panel-body  bg-silver"><?php 
                                                $templateInput = '<div class="row"><div class="col-md-12">
                                                            {label}</div><div class="col-md-12">{input}{hint}{error}</div></div>
                                                            ';
                                            ?>
                                            <div class="col-md-12"> 
                                                <?= $form->field($model, "mtitle",['template' => $templateInput])->textInput(['rows' => 4])->hint("<div class='panel-bg-hint'>{title},{site.title}</div>")?>
                                            </div>
                                            <div class="col-md-12">  
                                                <?= $form->field($model, "mkeywords",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{meta-base}</div>")?>
                                            </div>
                                            <div class="col-md-12"> 
                                                <?= $form->field($model, "mdescription",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{meta-base}</div>")?>
                                            </div>
                                                <hr>
                                                    <div class="">
                                                        <div class="col-md-3">
                                                            <label>Макросы </label>
                                                        </div>
                                                        <?php 
                                                            $tags = [
                                                                'title',
                                                                'site.title'
                                                            ];
                                                        ?>
                                                        <div class="col-md-5">
                                                            <?php foreach ($tags as $key => $value): ?>
                                                                <button type="button" class="btn btn-xs btn-default tag"><?=$value?></button>
                                                            <?php endforeach ?>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <br>
                                                            <?php echo CheckboxX::widget([
                                                                'name' => 'kv-adv-2',
                                                                'value' => 1,
                                                                // 'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                                                // 'autoLabel' => true,
                                                                'labelSettings' => [
                                                                    'label' => 'Использовать общий шаблон',
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="panel-inverse">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Информация</h4>
                                            </div>
                                            <div class="panel-body bg-silver">
                                                <div class="col-md-12"> 
                                                    <?= $form->field($model, 'translation_title['.$lang->url.']')->textInput(['value' => isset($title[$lang->url]) ? $title[$lang->url] : null])->label(Yii::t('app', 'Sarlavhasi', null, $lang->url)) ?>
                                                </div>
                                                <div class="col-md-12">
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
                                                    ])->label(Yii::t('app', 'Qisqacha mazmuni', null, $lang->url))?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="panel-inverse">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Seo</h4>
                                            </div>
                                            <div class="panel-body bg-silver">
                                            <?php 
                                                $templateInput = '<div class="row"><div class="col-md-12">
                                                            {label}</div><div class="col-md-12">{input}{hint}{error}</div></div>
                                                            ';
                                            ?>
                                                <div class="col-md-12">
                                                    <?= $form->field($model, 'translation_mtitle['.$lang->url.']',['template' => $templateInput])->textInput(['rows' => 4, 'value' => isset($mtitle[$lang->url]) ? $mtitle[$lang->url] : null  ])->hint("<div class='panel-bg-hint'>{title}{site.title}</div>")->label(Yii::t('app','Meta title', null, $lang->url)) ?>
                                                </div>
                                                <div class="col-md-12">
                                                    <?= $form->field($model, 'translation_mkeywords['.$lang->url.']',['template' => $templateInput])->textarea(['rows' => 4, 'value' => isset($mkeywords[$lang->url]) ? $mkeywords[$lang->url] : null ])->hint("<div class='panel-bg-hint'>{meta-base}</div>")->label(Yii::t('app','Meta Keyword', null, $lang->url)) ?>
                                                </div>
                                                <div class="col-md-12"> 
                                                    <?= $form->field($model, 'translation_mdescription['.$lang->url.']',['template' => $templateInput])->textarea(['rows' => 4, 'value' => isset($mdescription[$lang->url]) ? $mdescription[$lang->url] : null ])->hint("<div class='panel-bg-hint'>{meta-base}</div>")->label(Yii::t('app','Meta desctiption', null, $lang->url)) ?>
                                                </div>
                                            <hr>
                                                <div class="">
                                                    <div class="col-md-3">
                                                        <label>Макросы </label>
                                                    </div>
                                                    <?php 
                                                         $tags = [
                                                            'title',
                                                            'site.title'
                                                        ];
                                                    ?>
                                                    <div class="col-md-5">
                                                        <?php foreach ($tags as $key => $value): ?>
                                                            <button type="button" class="btn btn-xs btn-default tag"><?=$value?></button>
                                                        <?php endforeach ?>
                                                    </div>
                                                        <div class="col-md-12">
                                                            <br>
                                                            <?php echo CheckboxX::widget([
                                                                'name' => 'kv-adv-2',
                                                                'value' => 1,
                                                                // 'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                                                // 'autoLabel' => true,
                                                                'labelSettings' => [
                                                                    'label' => 'Использовать общий шаблон',
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;?>    
                            </p>
                         </div>
                        <?php $i++; endforeach;?>
                        <?php if($model->isNewRecord) { ?>
                            <div class="row">
                                <div class="col-md-4">     
                                    <?= $form->field($model, 'filename')->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-md-4">
                                    <h5>
                                        <p style="color:red;margin-top:30px;" >
                                            .html допустимые символи a-z, 0-9,- 
                                        </p>
                                    </h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <?= $form->field($model, 'noindex')->widget(Switchery::className(), [
                                        'options' => [
                                            'label' => false
                                        ],
                                        'clientOptions' => [
                                            'color' => '#5fbeaa',
                                        ]
                                    ])->label();?>
                                </div>
                            </div>  
                                <?php 
                                    }else
                                        { 
                                ?>
                                <h5>
                                    <p style="color:red;margin-top:30px;" ><?=$model->filename?></p>
                                </h5>
                                    <?php 
                                        }
                                ?>
                            <br>
                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                            <?= Html::a('<i class="fa fa-angle-double-left"></i> Назад', ['/references/pages/index'], ['data-pjax'=>'0','title'=> 'Назад','class'=>'btn btn-inverse']) ?>
                        </div> 
                    </div>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
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
 