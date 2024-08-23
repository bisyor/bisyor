<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="panel panel-inverse claims-index">
    <div class="panel-body" style="padding: 0px;">
        <div class="tab-content" style="margin:0;">
            <?= $form->field($model, 'seo_meta_limit_mtitle', [
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}<br>Список</div>
                                        <div class="col-md-2">
                                            <div class="input-group">{input}<span class="input-group-addon">символов</span></div>{hint}{error}
                                        </div>
                                    </div>'
                ])->textInput(['class' => 'form-control input_number'])?>
            <?= $form->field($model, 'seo_meta_limit_mkeywords', [
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}<br>Список</div>
                                        <div class="col-md-2">
                                            <div class="input-group">{input}<span class="input-group-addon">символов</span></div>{hint}{error}
                                        </div>
                                    </div>'
                ])->textInput(['class' => 'form-control input_number'])?>
            <?= $form->field($model, 'seo_meta_limit_mdescription', [
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}<br>Список</div>
                                        <div class="col-md-2">
                                            <div class="input-group">{input}<span class="input-group-addon">символов</span></div>{hint}{error}
                                        </div>
                                    </div>'
                ])->textInput(['class' => 'form-control input_number'])?> 
            <?= $form->field($model, 'seo_landing_pages_enabled',[
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}</div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-3">{input}{error}</div>
                                                <div class="col-md-12">{hint}</div>
                                            </div>
                                        </div>
                                    </div>'
                ])->dropDownLIst($model->getStatus()); ?>
            <?= $form->field($model, 'seo_redirects',[
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}</div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-3">{input}{error}</div>
                                                <div class="col-md-12">{hint}</div>
                                            </div>
                                        </div>
                                    </div>'
                ])->dropDownLIst($model->getStatus()); ?>
            <?= $form->field($model, 'seo_lists_empty_index',[
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}</div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-3">{input}{error}</div>
                                                <div class="col-md-12">{hint}</div>
                                            </div>
                                        </div>
                                    </div>'
                ])->dropDownLIst($model->getStatus())->hint('Для всех страниц списков, независимо от наличия результатов, устанавливается тег индекс'); ?>
            <?= $form->field($model, 'seo_pages_index',[
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}</div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-3">{input}{error}</div>
                                                <div class="col-md-12">{hint}</div>
                                            </div>
                                        </div>
                                    </div>'
                ])->dropDownLIst($model->getStatus())->hint('Все страниц списка помечаются тегом индекс'); ?>
            <?= $form->field($model, 'seo_pages_canonical',[
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}</div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-3">{input}{error}</div>
                                                <div class="col-md-12">{hint}</div>
                                            </div>
                                        </div>
                                    </div>'
                ])->dropDownLIst($model->getStatus())->hint('Для всех страниц начиная со второй канонической будет указана страница списка с номером страницы '); ?>
            <?= $form->field($model, 'seo_site_sitemapXML_langs',[
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}</div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-5">{input}{error}</div>
                                                <div class="col-md-12">{hint}</div>
                                            </div>
                                        </div>
                                    </div>'
                ])->dropDownLIst($model->getSeoSiteLang())->hint('Для всех страниц'); ?>
        </div>

        <div class="panel-footer">
            <?= Html::submitButton('Сохранить настройки', ['class' => 'btn btn-success','name' => 'tab-4-submit button']) ?>
        </div>
    </div>
</div>

<?php 
