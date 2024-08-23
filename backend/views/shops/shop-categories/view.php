<?php

use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset; 
use kartik\checkbox\CheckboxX;
use yii\widgets\Pjax;
use dosamigos\tinymce\TinyMce;


/* @var $this yii\web\View */
 /* @var $model backend\models\shops\ShopCategories */
/* @var $form yii\widgets\ActiveForm */

$i = 0;
$titles = $model->translation_title;
CrudAsset::register($this);

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Категория', 'url' => ['/shops/shop-categories/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['enablePushState' => false,'id' => 'crud-datatable-pjax'])?>

<ul class="nav nav-tabs">
    <li class="active"><a href="#default-tab-1" data-toggle="tab">Основные</a></li>
    <li class=""><a href="#default-tab-2" data-toggle="tab">SEO</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade active in" id="default-tab-1">
        <?=DetailView::widget([
                    'model' => $model,
                    'attributes' => [ 
                        'title',
                        [
                            'attribute'=>'icon_b',
                            'format'=>'raw',
                            'value' => function($data){
                                return $data->getImg(false,'50px','50px');
                            }
                        ],
                        [
                            'attribute'=>'icon_s',
                            'format'=>'raw',
                            'value' => function($data){
                                return $data->getImg(true,'50px','50px');
                            }
                        ],
                        [
                            'attribute'=>'enabled',
                            'format'=>'html',
                            'label' => 'Статус',
                            'value'=> function($data){
                                return $data->getStatusName($data->enabled);
                            },
                        ],
                        [
                            'attribute'=>'date_cr',
                            'value'=> function($data){
                                return $data->getDate($data->date_cr);
                            },
                        ],
            ],
        ]) ?>
        <p class="text-right m-b-0">
            <button class="btn btn-inverse" type="button" onClick="history.back();">Назад</button>

            <?=\yii\helpers\Html::a('Изменить <span class="glyphicon glyphicon-pencil"></span>', ['/shops/shop-categories/updatee','id' => $model->id],['role' => 'modal-remote','title'=> 'Изменить','data-toggle'=>'tooltip','class'=>'btn btn-primary'])
            ?>
        </p>
    </div>
    <div class="tab-pane fade" id="default-tab-2">
        <?php $form = ActiveForm::begin([
            'options' => [
                'id' => 'create-seo-category-form',
            ]
        ]); ?>
        <?php 
            $templateInput = '<div class="row"><div class="col-md-2">
                        {label}</div><div class="col-md-10">{input}{hint}{error}</div></div>
                        ';
        ?>
        <?= $form->field($modelSeo, "title",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;'])->hint("<div class='panel-bg-hint'>{category} {page} - магазины {site.title} {region.in}</div>")?>
        <?= $form->field($modelSeo, "keywords",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{category} , {region.in} , {site.title}</div>")?>
        <?= $form->field($modelSeo, "description",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{meta-base}</div>")?>
        <?= $form->field($modelSeo, "breadcumb",['template' => $templateInput])->textInput(['maxlength' => true])->hint("<div class='panel-bg-hint'>{category} {region.in}</div>")?>
        <?= $form->field($modelSeo, "h1_title",['template' => $templateInput])->textInput(['maxlength' => true])->hint("<div class='panel-bg-hint'>{category} {region.in}</div>")?>
        <?= $form->field($modelSeo, 'seo_text',['template' => $templateInput])->widget(TinyMce::className(), [
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
                                    ])->hint("<div class='panel-bg-hint'>{categories}  - магазины {page} {region.in}</div>"); ?>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <label>Макросы</label>
            </div>
            <?php 
                $tags = [
                    'category',
                    'category+parent',
                    'categories',
                    'categories.reverse',
                    'total',
                    'total.text',
                    'region',
                    'page',
                    'site.title'
                ];
            ?>
            <div class="col-md-7">
                <?php foreach ($tags as $key => $value): ?>
                    <button type="button" class="btn btn-xs btn-default tag"><?=$value?></button>
                <?php endforeach ?>
                
            </div>

            <div class="col-md-3">
                <?php echo CheckboxX::widget([
                    'name' => 'kv-adv-2',
                    'value' => 1,
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

        <p class="text-right m-b-0">

            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name' => 'save_buuton']) ?>
            <button class="btn btn-inverse" type="button" onClick="history.back();">Назад</button>
            
        </p>
        <?php ActiveForm::end(); ?>

    </div>
</div>
<?php Pjax::end()?>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>

<?php Modal::end(); ?>


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