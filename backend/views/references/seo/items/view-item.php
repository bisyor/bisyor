<?php
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
                    <a data-toggle="tab" href="#view-item_<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
                </li>
            <?php $i++; endforeach;?>
        </ul>
        <div class="tab-content">
            <?php $i = 0; foreach($langs as $lang): ?>
             <div id="view-item_<?=$lang->url?>" class="tab-pane fade <?=($i == 0) ? 'in active' : '' ?>">
                <div class="row">
                    <div class="col-md-12">
                    	<?php $key = 'items_ads_title_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textInput(['value' => $titles[$key] ])->label('Заголовок') ?>
                    </div>
                    
                    <div class="col-md-12">
                        <?php $key = 'items_ads_keyword_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textArea(['value' => $titles[$key], 'rows' => 3 ])->label('Ключевые слова') ?>
                    </div>

                    <div class="col-md-12">
                        <?php $key = 'items_ads_description_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textArea(['value' => $titles[$key], 'rows' => 3 ])->label('Описание') ?>
                    </div>

                    <div class="col-md-12">
                        <?php $key = 'items_ads_title_social_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textInput(['value' => $titles[$key] ])->label('Заголовок (поделиться в соц. сетях)') ?>
                    </div>
                    <div class="col-md-12">
                        <?php $key = 'items_ads_description_social_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textInput(['value' => $titles[$key] ])->label('Описание (поделиться в соц. сетях)') ?>
                    </div>

                    <div class="col-md-12">
                        <?php $key = 'items_ads_site_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textInput(['value' => $titles[$key] ])->label('Название сайта (поделиться в соц. сетях)') ?>
                    </div>

                    <div class="">
                        <div class="col-md-1">
                            <label>Макросы </label>
                        </div>
                        <?php 
                            $tags = [
                                'meta-base' => 'Базовые настройки',
                                'id' => 'ID объявления',
                                'name' => 'Имя пользователя',
                                'title' => 'Заголовок',
                                'description' => 'Описание (до 150 символов)',
                                'price' => 'Стоимость',
                                'address' => 'Адрес',
                                'district' => 'Район города',
                                'city' => 'Город',
                                'region' => 'Область',
                                'country' => 'Страна',
                                'category' => 'Текущая категория объявления',
                                'category+parent' => 'Текущая категория + категория выше',
                                'categories' => 'Название всех категорий',
                                'categories.reverse' => 'Название всех категорий<br />(обратный порядок)',
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
 