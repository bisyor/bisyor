<?= $form->field($model, 'other_date_timezone',[
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">{input}{error}</div>
                                    <div class="col-md-12">{hint}</div>
                                </div>
                            </div>
                        </div>'
    ])->dropDownLIst($model->getTimeZones())->hint(''); ?>   
<?= $form->field($model, 'other_https_only',[
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-3">{input}{error}</div>
                                    <div class="col-md-12">{hint}</div>
                                </div>
                            </div>
                        </div>'
    ])->dropDownLIst($model->getStatus())->hint(''); ?>   
<?= $form->field($model, 'other_https_redirect',[
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-3">{input}{error}</div>
                                    <div class="col-md-12">{hint}</div>
                                </div>
                            </div>
                        </div>'
    ])->dropDownLIst($model->getStatus())->hint(''); ?>   
<?= $form->field($model, 'other_hh_mailcheck_enabled',[
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-3">{input}{error}</div>
                                    <div class="col-md-12">{hint}</div>
                                </div>
                            </div>
                        </div>'
    ])->dropDownLIst($model->getStatus())->hint('При тестировании состаяния системы проверять доставляемость почты'); ?>  
<?= $form->field($model, 'other_hh_stat_allowed',[
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-3">{input}{error}</div>
                                    <div class="col-md-12">{hint}</div>
                                </div>
                            </div>
                        </div>'
    ])->dropDownLIst($model->getStatus())->hint('Разрешать сбор и последующий анализ статистики работы системы'); ?>   

