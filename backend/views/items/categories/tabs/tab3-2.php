<?php

use kartik\checkbox\CheckboxX;
use dosamigos\tinymce\TinyMce;
$i = 0;
$templateInput = '<div class="row"><div class="col-md-2">
            {label}</div><div class="col-md-8">{input}{hint}{error}</div></div>
            ';
?>
<ul class="nav nav-pills" id="tab-3-2-nav">
    <?php foreach($langs as $lang):?>
        <li class="<?= $i == 0 ? 'active' : '' ?>">
            <a data-toggle="tab" href="#<?=$lang->url?>-tab-3-2"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
        </li>
    <?php $i++; endforeach;?>
</ul>
<br>
<div class="tab-content" id="tab-3-2-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
    <div id="ru-tab-3-2" class="tab-pane active in">
        <?= $form->field($model, "view_mtitle",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;'])->hint("<div class='panel-bg-hint'>{title} {price}: {categories.reverse}, {address}, {city}, {country} - № {id}</div>")?>
        <?= $form->field($model, "view_mkeywords",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{title}, {price}, {categories}</div>")?>
        <?= $form->field($model, "view_mdescription",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{meta-base} {title}: {address}, {categories}, {region.in}, {country} - № {id}</div>")?>

        <?= $form->field($model, "view_share_title",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;'])->hint("<div class='panel-bg-hint'>{meta-base}</div>")?>
        <?= $form->field($model, "view_share_description",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{meta-base}</div>")?>

        <?= $form->field($model, "view_share_sitename",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;'])->hint("<div class='panel-bg-hint'>{meta-base}</div>")?>
    </div>
    <?php $i = 0; foreach($langs as $lang): ?>
        <?php if ($lang->url == 'ru') continue; ?>
        <div id="<?=$lang->url?>-tab-3-2" class="tab-pane fade in">
            <?= $form->field($model, "translation_view_mtitle[".$lang->url."]",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;'])->hint("<div class='panel-bg-hint'>{title} {price}: {categories.reverse}, {address}, {city}, {country} - № {id}</div>")?>
            <?= $form->field($model, "translation_view_mkeywords[".$lang->url."]",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{title}, {price}, {categories}</div>")?>
            <?= $form->field($model, "translation_view_mdescription",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{meta-base} {title}: {address}, {categories}, {region.in}, {country} - № {id}</div>")?>

            <?= $form->field($model, "translation_view_share_title[".$lang->url."]",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;'])->hint("<div class='panel-bg-hint'>{meta-base}</div>")?>
            <?= $form->field($model, "translation_view_share_description[".$lang->url."]",['template' => $templateInput])->textarea(['rows' => 4])->hint("<div class='panel-bg-hint'>{meta-base}</div>")?>

            <?= $form->field($model, "translation_view_share_sitename[".$lang->url."]",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;'])->hint("<div class='panel-bg-hint'>{meta-base}</div>")?>
        </div>
    <?php $i++; endforeach;?>
</div>


<hr>

<div class="row">
    <div class="col-md-2">
        <label>Макросы</label>
    </div>
    <?php 
        $tags = [
            '{id}',
            '{name}',
            '{title}',
            '{description}',
            '{price}',
            '{address}',
            '{district}',
            '{city}',
            '{region}',
            '{country}',
            '{category}',
            '{category+parent}',
            '{parent.category}',
            '{categories}',
            '{categories.reverse}',
            '{site.title}',
            '{491}',
            '{112}',
            '{113}',
            '{114}'
        ];
    ?>
    <div class="col-md-6">
        <?php foreach ($tags as $key => $value): ?>
            <button type="button" style="margin-bottom: 10px;" class="btn btn-xs btn-default tag"><?=$value?></button>
        <?php endforeach ?>
        <div class='panel-bg-hint'><p>Используйте символ-разделитель | для выделение отрезков текста с необязятельными параметрами, таким образом они будет удалены из итогового текста в случае если значения параметров не были заплнены пользавателем.</p></div>
    </div>

    <div class="col-md-3">
        <?php echo CheckboxX::widget([
            'name' => 'Categories[view_mtemplate]',
            'value' => $model->view_mtemplate,
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