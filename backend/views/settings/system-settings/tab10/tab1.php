<?= $form->field($model, 'other_currency_default',[
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-2">{input}{error}</div>
                                    <div class="col-md-12">{hint}</div>
                                </div>
                            </div>
                        </div>'
    ])->dropDownLIst($model->getCurrencyList()); ?>   
<?= $form->field($model, 'other_currency_rate_auto',[
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
<?= $form->field($model, 'other_locale_accepted_languages',[
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-3">{input}{error}</div>
                                    <div class="col-md-12">{hint}</div>
                                </div>
                            </div>
                        </div>'
    ])->dropDownLIst($model->getStatus())->hint('Выполнять автоопределение лщкализации при первом заходе пользавателя сайт'); ?>
<?= $form->field($model, 'other_site_static_minify',[
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
<?= $form->field($model, 'other_site_static_minify_bundle',[
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-3">{input}{error}</div>
                                    <div class="col-md-12">{hint}</div>
                                </div>
                            </div>
                        </div>'
    ])->dropDownLIst($model->getStatus())->hint('все файлы стилей подключаться одним файлом, для ускорения загрузки страницы'); ?>
<?= $form->field($model, 'other_sphinx_enabled',[
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
<?= $form->field($model, 'other_sphinx_host', [
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-6">{input}{hint}{error}
                            </div>
                        </div>'
    ])?> 
<?= $form->field($model, 'other_sphinx_port', [
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-2">{input}{hint}{error}
                            </div>
                        </div>'
    ])->textInput(['class' => 'form-control number_input'])?> 
<?= $form->field($model, 'other_sphinx_path', [
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-6">{input}{hint}{error}
                            </div>
                        </div>'
    ])?> 
<?= $form->field($model, 'other_sphinx_version', [
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-6">{input}{hint}{error}
                            </div>
                        </div>'
    ])?> 
