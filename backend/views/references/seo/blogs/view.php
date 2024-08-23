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
                    <a data-toggle="tab" href="#view<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
                </li>
            <?php $i++; endforeach;?>
        </ul>
        <div class="tab-content">
            <?php $i = 0; foreach($langs as $lang): ?>
             <div id="view<?=$lang->url?>" class="tab-pane fade <?=($i == 0) ? 'in active' : '' ?>">
                <div class="row">
                    <div class="col-md-12">
                    	<?php $key = 'blog_post_title_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textInput(['value' => $titles[$key] ])->label('Заголовок') ?>
                    </div>
                    
                    <div class="col-md-12">
                        <?php $key = 'blog_post_keyword_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textArea(['value' => $titles[$key], 'rows' => 3 ])->label('Ключевые слова') ?>
                    </div>

                    <div class="col-md-12">
                        <?php $key = 'blog_post_description_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textArea(['value' => $titles[$key], 'rows' => 3 ])->label('Описание') ?>
                    </div>

                    <div class="col-md-12">
                        <?php $key = 'blog_post_social_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textInput(['value' => $titles[$key] ])->label('Заголовок H1') ?>
                    </div> 

                    <div class="col-md-12">
                        <?php $key = 'blog_post_social_description_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textArea(['value' => $titles[$key], 'rows' => 3 ])->label('Описание (поделиться в соц. сетях)') ?>
                    </div>

                    <div class="col-md-12">
                        <?php $key = 'blog_post_site_name_' . $lang->url; ?>
                        <?= $form->field($model, 'translation_name['.$key.']')->textInput(['value' => $titles[$key] ])->label('Название сайта (поделиться в соц. сетях)') ?>
                    </div> 

                    <div class="">
                        <div class="col-md-1">
                            <label>Макросы </label>
                        </div>
                        <?php 
                            $tags = [
                                'meta-base' => 'Базовые настройки',
                                'title' => 'Заголовок поста', 
                                'textshort' => 'Краткое описание (до 150 символов)', 
                                'tags' => 'Список тегов', 
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
