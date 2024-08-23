<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
use bajadev\dynamicform\DynamicFormWidget;
use backend\models\shops\ShopsAbonements;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopCategories */
/* @var $form yii\widgets\ActiveForm */

$i = 0;
$titles = $model->translation_title;

$this->title = $title;
$this->params['breadcrumbs'][] = ['label' => 'Абонемент', 'url' => ['/shops/shops-abonements/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title"><?=$this->title?></h4>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'enableClientValidation'=>false,
            'enableAjaxValidation'=>false,
            'options' => [
                'enctype' => 'multipart/form-data',
                'id' => 'create-shop-abonement-form'
            ]
        ]); ?>
        <div class="shops-abonements-form" style="padding-right: 50px; padding-left: 50px;">
            <div class="row">
                <div class="col-md-2" style="margin-top: 73px;">
                    <label for="shopsabonements-title"><?=$model->getAttributeLabel('title') ?></label>
                </div>
                <div class="col-md-8">
                    <ul class="nav nav-tabs" style="margin-top:2px;">
                        <?php foreach($langs as $lang):?>
                            <li class="<?= $i == 0 ? 'active' : '' ?>">
                                <a data-toggle="tab" href="#<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
                            </li>
                        <?php $i++; endforeach;?>
                    </ul>
                    <div class="tab-content" style="height: 60px;">
                        <?php $i = 0; foreach($langs as $lang): ?>
                        <div id="<?=$lang->url?>" class="tab-pane fade <?=($i == 0) ? 'in active' : '' ?>">
                            <p>
                                <?php if($lang->url == 'ru'): ?>
                                    <div class="row">
                                        <?= $form->field($model, 'title')->textInput()->label(false) ?>
                                    </div>
                                <?php else: ?>
                                    <div class="row">
                                        <?= $form->field($model, 'translation_title['.$lang->url.']')->textInput(['value' => isset($titles[$lang->url]) ? $titles[$lang->url] : '' ])->label(false) ?>
                                    </div>
                                <?php endif;?>
                            </p>
                        </div>
                        <?php $i++; endforeach;?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="shopsabonements-title"><?=$model->getAttributeLabel('is_free') ?></label>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'is_free')->radioList(
                                [0=>'Платно',1=>'Бесплатно'],
                                [
                                    'separator' => "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
                                    'onchange' => '
                                        val = $("input:radio[name=\'ShopsAbonements[is_free]\']:checked").val();
                                        changeChargeType(val);
                                    '
                                ]
                                )->label(false); ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row" id="besplatno_items">
                <div class="col-md-2">
                    <label>Срок действия</label>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-2">
                            <?php
                                $templateInput = '{label}{input}{error}{hint}';
                                $templateCheckbox = '{label}&nbsp;&nbsp;&nbsp;{input}{error}{hint}';
                            ?>

                            <?= $form->field($model, 'price_free_period',['template' => $templateCheckbox])->widget(CheckboxX::classname(),
                                    [
                                        'pluginOptions'=>
                                            [
                                                'threeState'=>false
                                            ],
                                        'options' => [
                                            'onchange' => 'changeMountCount();
                                            '
                                        ]
                                ])?>
                        </div>
                        <div class="col-md-1">
                            <b>Или</b>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'num_month',['template' => $templateInput])->textInput(['style' => 'height:27px !important;','id'=>'month_count','class' => 'number_input form-control'])->label(false) ?>
                        </div>
                        <div class="col-md-1">
                            <b>месяцев</b>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="platno_items">
                <div class="col-md-2">
                    <br>
                    <br>
                    <label>Стоимость</label>
                </div>
                <div class="col-md-10">
                    <div>
                        <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-items', // required: css class selector
                            'widgetItem' => '.item', // required: css class
                            'limit' => 10, // the maximum times, an element can be cloned (default 999)
                            'min' => 1, // 0 or 1 (default 1)
                            'insertButton' => '.add-item', // css class
                            'deleteButton' => '.remove-item', // css class
                            'model' => $modelsPeriods[0],
                            'formId' => 'create-shop-abonement-form',
                            'formFields' => [
                                'month',
                                'price_for_month',
                                'total_price'
                            ],
                        ]); ?>
                        <div class="container-items"><!-- widgetContainer -->
                            <div class="row">
                                <div class="col-sm-4">
                                    <labe><?= $modelsPeriods[0]->getAttributeLabel('month') ?></labe>
                                </div>
                                <div class="col-sm-4">
                                    <labe><?= $modelsPeriods[0]->getAttributeLabel('price_for_month') ?></labe>
                                </div>
                                <div class="col-sm-4">
                                    <labe><?= $modelsPeriods[0]->getAttributeLabel('total_price') ?></labe>
                                </div>
                            </div>
                            <br>
                        <?php foreach ($modelsPeriods as $i => $modelPeriod): ?>
                            <div class="item row"><!-- widgetBody -->
                                <!-- <div class="panel-heading">
                                    <h3 class="panel-title pull-left">Address</h3>
                                    <div class="pull-right">
                                        <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div> -->

                                <div class="col-md-10">
                                    <?php
                                        // necessary for update action.
                                        if (! $modelPeriod->isNewRecord) {
                                            echo Html::activeHiddenInput($modelPeriod, "[{$i}]id");
                                        }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?= $form->field($modelPeriod, "[{$i}]month")->textInput(['maxlength' => true,'class' => 'number_input form-control','onkeyup'=>"setTotalValue($(this))"])->label(false) ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($modelPeriod, "[{$i}]price_for_month")->textInput(['maxlength' => true,'class' => 'number_input form-control','onkeyup'=>'setTotalValue($(this))'])->label(false) ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= $form->field($modelPeriod, "[{$i}]total_price")->textInput(['maxlength' => true,'class' => 'number_input form-control'])->label(false) ?>
                                        </div>
                                    </div><!-- .row -->
                                </div>

                                <div class="col-md-2">
                                        <button type="button" class="add-item btn btn-success btn-md"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" class="remove-item btn btn-danger btn-md"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>

                            </div>
                        <?php endforeach; ?>
                        </div>
                        <?php DynamicFormWidget::end(); ?>
                    </div>
                </div>
            </div>

            <hr>
            <?php
                $templateInput = '<div class="row"><div class="col-md-2">
                            {label}</div><div class="col-md-4">{input}{error}</div><div class="col-md-4">{hint}</div></div>
                            ';
                $templateCheckbox = '<div class="row"><div class="col-md-2">
                            {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-6">{hint}</div></div>
                            ';
            ?>
            <div class="row">
                <div class="col-md-2">
                    <label>Условия</label>
                </div>
                <div class="col-md-10 panel-bg">

                    <?= $form->field($model, 'ads_count',[
                            'template' => $templateInput
                        ])->textInput(['class' => 'number_input form-control'])->hint(' - 0 без неорганичений') ?>

                    <?= $form->field($model, 'import',['template' => $templateCheckbox])->widget(CheckboxX::classname(),
                        [
                            'pluginOptions'=>
                                [
                                    'threeState'=>false
                                ],
                    ])->hint(' - доступность импорта'); ?>

                    <?= $form->field($model, 'mark',['template' => $templateCheckbox])->widget(CheckboxX::classname(),
                        [
                            'pluginOptions'=>
                                [
                                    'threeState'=>false
                                ],
                    ])->hint(' - услуга активорована на весь срок действия тарифа'); ?>

                    <?= $form->field($model, 'fix',['template' => $templateCheckbox])->widget(CheckboxX::classname(),
                        [
                            'pluginOptions'=>
                                [
                                    'threeState'=>false
                                ],
                    ])->hint('- услуга активорована на весь срок действия тарифа'); ?>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-md-2">
                    <label>Скидка на платные услуги</label>
                </div>

                <div class="col-md-10 panel-bg">
                    <?php
                        $templateInput = '<div class="row"><div class="col-md-2">
                                    {label}</div><div class="col-md-2">{input}{error}</div><div class="col-md-4">{hint}</div></div>
                                    ';
                    ?>
                    <?php foreach ($modelsDisconts as $i => $modelDiscont): ?>
                        <?= $form->field($modelDiscont, "[{$i}]percent",[
                            'template' => $templateInput,
                            'options' => [
                                // 'tag' => false,
                                'class' => '',
                            ]

                        ])->textInput(['style' => 'height:25px !important;margin-bottom:2px;','maxlength' => true,'class' => 'number_input form-control'])->hint("%")->label($modelDiscont->service->title) ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'img')->hiddenInput(['id' => 'temp_address'])->hint('128x128') ?>
                </div>
                <div class="col-md-10">
                    <label for="avatar" title="Выберите" data-toggle="tooltip" id="image_label" onmousemove="style.cursor='pointer'"><?=$model->getImg(false,'50px','50px')?></label>
                    <input type="file" name="" id="avatar" style="display: none;" accept="image/*">
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'small_img')->hiddenInput(['id' => 'temp_address_small'])->hint('32x32') ?>
                </div>
                <div class="col-md-10">
                    <label for="avatar_small" title="Выберите" data-toggle="tooltip" id="image_label_small" onmousemove="style.cursor='pointer'"><?=$model->getImg(true,'50px','50px')?></label>
                    <input type="file" name="" id="avatar_small" style="display: none;" accept="image/*">

                </div>
            </div>
            <hr>
            <?= $form->field($model, 'one_time',['template' => $templateCheckbox])->widget(CheckboxX::classname(),
                [
                    'pluginOptions'=>
                        [
                            'threeState'=>false
                        ],
            ])->hint(' - после завершения срока действия тарифа повторная его активатсия невозможна'); ?>

            <?= $form->field($model, 'is_default',['template' => $templateCheckbox])->widget(CheckboxX::classname(),
                [
                    'pluginOptions'=>
                        [
                            'threeState'=>false
                        ],
            ])->hint(' - тариф отмеченный по умолчанию'); ?>

            <?= $form->field($model, 'enabled',['template' => $templateCheckbox])->widget(CheckboxX::classname(),
                [
                    'pluginOptions'=>
                        [
                            'threeState'=>false
                        ],
                    'options'=>
                        [
                            'onchange' => "
                                element = $(this).parent('div').parent('div').next().children('div');
                                value = $(this).val();
                                if(value == 1){
                                    element.html('Активно');
                                }else{
                                    element.html('Неактивно');
                                }
                            "
                        ]
            ])->hint(($model->enabled == 1) ? 'Активно' : 'Неактивно'); ?>
        </div>

        <div class="panel-footer row text-right">
            <div class="form-group col-md-10">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    <button class="btn btn-inverse" type="button" onClick="history.back();">Отмена</button>


            </div>

        </div>
    <?php ActiveForm::end(); ?>

    </div>
</div>

<?php
$val = $model->is_free;
$dirname = ShopsAbonements::DIR_NAME;

$this->registerJs(<<<JS

    $(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
        if (! confirm("Вы уверены что хотите удалить этого элемента?")) {
            return false;
        }
        return true;
    });

    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        $(".number_input").inputFilter(function(value) {
          return /^\d*$/.test(value);
        });
    });

    changeMountCount = function(){
        val = $("#shopsabonements-price_free_period").val();
        if(val == 1){
            $("#month_count").val(0);
            $("#month_count").prop("disabled",true);
        }else{
            // $("#month_count").val("");
            $("#month_count").prop("disabled",false);
        }
    }
    changeChargeType('$val');
    changeMountCount();

    $(".number_input").inputFilter(function(value) {
      return /^\d*$/.test(value);
    });

    $("#avatar").on('change',function(e){
        var file = $( '#avatar' )[0].files[0];
        var data = new FormData();

        var d = new Date();
        var new_name = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate() + '_' +d.getHours() + '-' + d.getMinutes() + '-' + d.getSeconds();
        var filename = file.name;
        name = filename.split('.').shift();
        var ext = filename.split('.').pop();
        new_name = name + '(' + new_name + ")." + ext;
        data.append('file[]', file) ;
        data.append('dir_name', '$dirname');
        data.append('names[]', new_name);
        data.append('old_image', $("#temp_address").val());
        $("#temp_address").val(new_name);

        $.ajax({
            url: '/shops/shop-categories/upload-image',
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function(success){
                $("#count_files").val(1);
                $("#image_label img").attr('style','width:50px;height:50px');
                $("#image_label img").attr('src',success);
            },
            error: function(success){
                alert("Error occur uploading image. Try again )");
                $("#image_label img").attr('src','/uploads/noimg.jpg');
            },
            //Do not cache the page
            cache: false,

            //@TODO start here
            xhr: function() {  // custom xhr
                myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    $("#image_label img").attr('src','/uploads/zz.gif');
                    return myXhr;
                }
            }
        });
    });

    $("#avatar_small").on('change',function(e){
        var file = $( '#avatar_small' )[0].files[0];
        var data = new FormData();

        var d = new Date();
        var new_name = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate() + '_' +d.getHours() + '-' + d.getMinutes() + '-' + d.getSeconds();
        var filename = file.name;
        name = filename.split('.').shift();
        var ext = filename.split('.').pop();
        new_name = name + '(' + new_name + ")." + ext;
        data.append('file[]', file) ;
        data.append('dir_name', '$dirname');
        data.append('names[]', new_name);
        data.append('old_image', $("#temp_address_small").val());
        $("#temp_address_small").val(new_name);

        $.ajax({
            url: '/shops/shop-categories/upload-image',
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function(success){
                $("#count_files").val(1);
                $("#image_label_small img").attr('style','width:50px;height:50px');
                $("#image_label_small img").attr('src',success);
            },
            error: function(success){
                alert("Error occur uploading image. Try again )");
                $("#image_label_small img").attr('src','/uploads/noimg.jpg');
            },
            //Do not cache the page
            cache: false,

            //@TODO start here
            xhr: function() {  // custom xhr
                myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    $("#image_label_small img").attr('src','/uploads/zz.gif');
                    return myXhr;
                }
            }
        });
    });
JS
);

$this->registerJs(<<<JS
    function setTotalValue(item){
        id = (item.attr('id')).split('-')[1];

        value1 = $("#shopsabonementperiod-" + id + "-month").val();
        value2 = $("#shopsabonementperiod-" + id + "-price_for_month").val();

        $("#shopsabonementperiod-" + id + "-total_price").val(value1*value2);
    }
JS
,$this::POS_END)
?>