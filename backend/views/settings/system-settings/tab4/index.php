<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="panel panel-inverse claims-index">
    <div class="panel-body" style="padding: 0px;">
        <div class="tab-content" style="margin:0;">
            <?= $form->field($model, 'internalmail_attachments',[
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}</div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-5">{input}{error}</div>
                                                <div class="col-md-12">{hint}</div>
                                            </div>
                                        </div>
                                    </div>' 
                ])->dropDownLIst($model->getStatus())->hint('разрешить загрузку файлов в соощениях'); ?>

            <?= $form->field($model, 'internalmail_folders',[
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}</div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-3">{input}{error}</div>
                                                <div class="col-md-12">{hint}</div>
                                            </div>
                                        </div>
                                    </div>'
                ])->dropDownLIst($model->getStatus())->hint('возможность закрепления контактов в папках: избранные, игнорирую'); ?>

            <?= $form->field($model, 'internalmail_users_write_form_captcha',[
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}<br>Страница объявления/ магазина</div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-3">{input}{error}</div>
                                                <div class="col-md-12">{hint}</div>
                                            </div>
                                        </div>
                                    </div>'
                ])->dropDownLIst($model->getStatus());?>

            <?= $form->field($model, 'internalmail_users_write_form_logined',[
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}<br>Страница объявления/ магазина</div>
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-3">{input}{error}</div>
                                                <div class="col-md-12">{hint}</div>
                                            </div>
                                        </div>
                                    </div>'
                ])->dropDownLIst($model->getStatus())->hint('отображать поле повторного ввода пароля в форме регистрации'); ?>

            <?= $form->field($model, 'internalmail_contacts_limit', [
                'template' => '<div class="row">
                                        <div class="col-md-3">{label}</div>
                                        <div class="col-md-2">
                                            <div class="input-group">{input}<span class="input-group-addon">в сутки</span></div>{hint}{error}
                                        </div>
                                    </div>'
                ])->textInput(['class' => 'form-control number_input'])?>   

        </div>

        <div class="panel-footer">
            <?= Html::submitButton('Сохранить настройки', ['class' => 'btn btn-success','name' => 'tab-4-submit button']) ?>
        </div>
    </div>
</div>

<?php 
$this->registerJsFile('/js/cookie.js');
$this->registerJs(<<<JS
    // var active_tab = getCookie('tab-settings');
    // if(!active_tab || active_tab == 'undefined'){
    //     active_tab = 'tab-1';
    // }
    
    // for(i = 0; i<4; i++){
    //     $("#default-tab-" + i).removeClass('active');
    //     $("#tab-" + i).removeClass('active');
    // }

    // $("#"+active_tab).addClass('active');
    // $("#default-"+active_tab).addClass('active');

    // $('.nav li').on('click',function(){
    //     value = $(this).attr('id');
    //     setCookie('tab-settings',value);
    //     $("#tab").val(value);
    //     // $.pjax.reload({container:'#crud-datatable-claims-'+value+'-pjax',async:true});
    // });
    

    $(document).ready(function(){
        var active_tab = $("#main-tab").val();
        active_tab = getCookie('tab-settings');
        if(!active_tab || active_tab == 'undefined'){
            active_tab = 'tab-1';
        }
        for(i = 0; i<4; i++){
            $("#default-tab-" + i).removeClass('active');
            $("#tab-" + i).removeClass('active');
        }
        $("#"+active_tab).addClass('active');
        $("#default-"+active_tab).addClass('active');
        $('#main-tab-nav li').on('click',function(){
            value = $(this).attr('id');
            setCookie('tab-settings',value);
            $("#main-tab").val(value);
        });
    })
JS
)
?>