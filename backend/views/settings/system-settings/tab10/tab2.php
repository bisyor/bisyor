<?= $form->field($model, 'other_mail_fromname', [
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-6">{input}{hint}{error}
                            </div>
                        </div>'
    ])->hint('Имя отправителя указываемое при отправке уведомлений, как правило это названия сайта')?> 
<?= $form->field($model, 'other_mail_noreply', [
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-6">{input}{hint}{error}
                            </div>
                        </div>'
    ])->hint('Email для отправки автоматических уведомлений сайта, не требующих ответа пользавателей')?> 
<?= $form->field($model, 'other_mail_admin', [
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-6">{input}{hint}{error}
                            </div>
                        </div>'
    ])->hint('Email для связи с администратором сайта (соощений на форму обратной связи)')?> 
<?= $form->field($model, 'other_mail_method',[
    'template' => '<div class="row">
                            <div class="col-md-3">{label}</div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-3">{input}{error}</div>
                                    <div class="col-md-12">{hint}</div>
                                </div>
                            </div>
                        </div>'
    ])->dropDownLIst($model->getMailMethod())->hint(''); ?>   