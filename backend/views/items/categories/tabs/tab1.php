<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
use kartik\color\ColorInput;
use kartik\select2\Select2;
use bajadev\dynamicform\DynamicFormWidget;
use dosamigos\tinymce\TinyMce;
use backend\models\items\Categories;

$i = 0;
?>
<?php $form = ActiveForm::begin([
    // 'enableClientValidation'=>false,
    // 'enableAjaxValidation'=>false,
    'options' => [
        'enctype' => 'multipart/form-data',
        'id' => 'categories-base-form'
    ],
    // 'enableAjaxValidation'      => true,
    // 'enableClientValidation'    => false,
    // 'validateOnChange'          => true,
    // 'validateOnSubmit'          => true,
    // 'validateOnBlur'            => false,
]); ?>

<?= $form->field($model, 'type')->hiddenInput(['value' => \backend\models\items\Categories::TYPE_BASE ])->label(false) ?>

<div>

    <div class="row">
        <div class="col-md-2 offset-md-2">
        </div>
        <div class="col-md-8">
            <ul class="nav nav-pills" id="tab-1-nav">
                <?php foreach($langs as $lang):?>
                    <li class="<?= $i == 0 ? 'active' : '' ?>" onclick="changeTab($(this))" data-id="<?=$lang->url?>">
                        <a data-toggle="tab" href="#<?=$lang->url?>-tab-1"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
                    </li>
                <?php $i++; endforeach;?>
            </ul>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-2">
            <label>Категория</label>
        </div>
        <div class="col-md-8">
            <select id="mySelect" name="Categories[parent_id]" onchange="changeDivImage()"></select>
        </div>
    </div>
    <br>
    <?php
        $templateInput = '<div class="row"><div class="col-md-2">
            {label}</div><div class="col-md-10">{input}{error}</div><div class="col-md-4">{hint}</div></div>';
    ?>
    <div class="row">
        <div class="col-md-2">
            <label><?=$model->getAttributeLabel('title')?></label>
        </div>
        <div class="col-md-8">
            <div class="tab-content" id="tab-1-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
                <div id="ru-tab-1" data-id="ru"  class="tab-pane fade in tab-1">
                    <?= $form->field($model, 'title')->textInput()->label(false) ?>
                </div>
                <?php $i = 0; foreach($langs as $lang): ?>
                    <?php if ($lang->url == 'ru') continue; ?>
                    <div id="<?=$lang->url?>-tab-1" data-id="<?=$lang->url?>" class="tab-pane fade in tab-1">
                        <?= $form->field($model, 'translation_title['.$lang->url.']')->textInput(['value' => isset($model->translation_title[$lang->url]) ? $model->translation_title[$lang->url] : null ])->label(false) ?>
                    </div>
                <?php $i++; endforeach;?>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-2">
            <label>Тип размещения</label>
        </div>
        <div class="col-md-8 panel-bg">
            <div class="row">
                <div class="col-md-2"><label>Предлагаю</label></div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="tab-content" id="tab-1-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
                            <div id="ru-tab-1" data-id="ru"  class="tab-pane fade in tab-1 active">
                                <div class="col-md-4">
                                    <?= $form->field($model, 'type_offer_form')->textInput([])->label(false)?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'type_offer_search')->textInput([])->label(false)?>
                                </div>
                            </div>
                            <?php $i = 0; foreach($langs as $lang): ?>
                                <?php if ($lang->url == 'ru') continue; ?>
                                <div id="<?=$lang->url?>-tab-1" data-id="<?=$lang->url?>" class="tab-pane fade in tab-1">
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'translation_type_offer_form['.$lang->url.']')->textInput(['value' => isset($model->translation_type_offer_form[$lang->url]) ? $model->translation_type_offer_form[$lang->url] : null ])->label(false) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'translation_type_offer_search['.$lang->url.']')->textInput(['value' => isset($model->translation_type_offer_search[$lang->url]) ? $model->translation_type_offer_search[$lang->url] : null ])->label(false) ?>

                                    </div>
                                </div>
                                <?php $i++; endforeach;?>
                        </div>
                        <div class="col-md-12" style="margin-top:0px;">примери: Предлагаю, Продам, Сдам, Предложение, Предлогаю работу, ...</div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2"><label>Ищу</label></div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="tab-content" id="tab-1-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
                            <div id="ru-tab-1" data-id="ru"  class="tab-pane fade in tab-1 active">
                                <div class="col-md-4">
                                    <?= $form->field($model, 'type_seek_form')->textInput([])->label(false)?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'type_seek_search')->textInput([])->label(false)?>
                                </div>
                            </div>
                            <?php $i = 0; foreach($langs as $lang): ?>
                                <?php if ($lang->url == 'ru') continue; ?>
                                <div id="<?=$lang->url?>-tab-1" data-id="<?=$lang->url?>" class="tab-pane fade in tab-1">
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'translation_type_seek_form['.$lang->url.']')->textInput(['value' => isset($model->translation_type_seek_form[$lang->url]) ? $model->translation_type_seek_form[$lang->url] : null ])->label(false) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'translation_type_seek_search['.$lang->url.']')->textInput(['value' => isset($model->translation_type_seek_search[$lang->url]) ? $model->translation_type_seek_search[$lang->url] : null ])->label(false) ?>

                                    </div>
                                </div>
                                <?php $i++; endforeach;?>
                        </div>
                        <div class="col-md-4">
                            <?=$form->field($model, 'seek')->widget(CheckboxX::classname(), [
                                'autoLabel' => true,
                                'labelSettings' => [
                                    'position' => CheckboxX::LABEL_RIGHT,
                                ],
                                'pluginOptions'=>[
                                    'threeState'=>false
                                ],
                                'options'=>[
                                    'onchange' => '
                                        setSeek($(this).val());
                                    '
                                ]
                            ])->label(false);?>
                        </div>
                        <div class="col-md-12" style="margin-top:0px;">примери: Ищу, Куплю, Сниму, Ищу работу, ...</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <br>
     
    <?= $form->field($model, 'price',[
        'template' =>'<div class="row"><div class="col-md-2">
            {label}</div><div class="col-md-3">{input}{error}</div><div class="col-md-4">{hint}</div></div>'
        ])->radioList(
            $model->getPrice(),
            [
                'separator' => "&nbsp;&nbsp;&nbsp;&nbsp;",
                'onchange' => '
                    changePrice();
                '
            ]
        ) ?>

    <div class="row">
        <div class="col-md-2 offset-md-2">
        </div>
        <div class="col-md-8 panel-bg" id="div-price">
            <?php
                $templateInput = '<div class="row">
                                    <div class="col-md-2">
                                        <label>Заголовок цены</label>
                                    </div>
                                    <div class="col-md-4">{input}{error}</div>
                                    <div class="col-md-5">{hint}</div>
                                </div>';
            ?>
            <div class="tab-content panel-bg" style="padding-left: 0px;padding-right: 0px;padding-top: 0px !important;padding-bottom: 0px; margin-bottom: -30px;">
                    <div id="ru-tab-1" data-id="ru" class="tab-pane active in tab-1">
                        <?= $form->field($model, 'price_title[ru]',['template' => $templateInput])->textInput(['value' => isset($model->price_title['ru']) ? $model->price_title['ru'] : null, 'style'=>'height:28px;' ])->hint('примеры: Цена, Стоимость, Зарплата от, ...') ?>
                    </div>
                <?php $i = 0; foreach($langs as $lang): ?>
                    <?php if ($lang->url == 'ru') continue; ?>
                    <div id="<?=$lang->url?>-tab-1" data-id="<?=$lang->url?>" class="tab-pane fade in tab-1">
                        <?= $form->field($model, 'price_title['.$lang->url.']',['template' => $templateInput])->textInput(['value' => isset($model->price_title[$lang->url]) ? $model->price_title[$lang->url] : null,'style'=>'height:28px;' ])->hint('примеры: Цена, Стоимость, Зарплата от, ...') ?>
                    </div>
                <?php $i++; endforeach;?>
            </div>
            <br>
            <div class="tab-content panel-bg">
                <?= $form->field($model, 'curr',[
                    'template' => '<div class="row">
                                        <div class="col-md-2">{label}</div>
                                        <div class="col-md-2">
                                            {input}
                                        </div>
                                        <div class="col-md-8">
                                            {hint}
                                        </div>
                                    </div>'
                    ])->dropDownList($model->getCurrencyList(),['style'=>'height:30px;']); ?>
                <br>
                <?= $form->field($model, 'price_diapazone',['template' => '<div class="row"><div class="col-md-2">
                        {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-6">{hint}</div></div>'])->widget(CheckboxX::classname(),
                        ['pluginOptions'=>[
                            'threeState'=>false
                        ]
                    ]) ?>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <label><?=$model->getAttributeLabel('ranges')?></label>
                        <br>(для поиска)
                    </div>
                    <div class="col-md-8">
                        <div id="diapozon_sen">
                            <div id="example" style="display: none;">
                                <div>
                                    <div class="row">
                                        <div class="col-md-1">
                                            от
                                        </div>
                                        <div class="col-md-3">
                                            <input type="" name="from[]" class="form-control" style="height:28px;">
                                        </div>
                                        <div class="col-md-1 offset-md-1">
                                        </div>
                                        <div class="col-md-1">
                                            до
                                        </div>
                                        <div class="col-md-3">
                                            <input type="" name="to[]" class="form-control" style="height:28px;">
                                        </div>
                                        <div class="col-md-2">
                                            <!-- <button class="btn btn-xs"></button> -->
                                            <button type="button" onclick="$(this).parent().parent().parent().remove();" class="remove-item btn btn-danger btn-xs">
                                                <i class="glyphicon glyphicon-minus" ></i></button>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <?php if ($model->ranges): ?>
                                <?php foreach ($model->ranges as $key => $value): ?>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-1">
                                                от
                                            </div>
                                            <div class="col-md-3">
                                                <input type="" name="from[]" class="form-control" style="height:28px;" value="<?=$value['from']?>">
                                            </div>
                                            <div class="col-md-1 offset-md-1">
                                            </div>
                                            <div class="col-md-1">
                                                до
                                            </div>
                                            <div class="col-md-3">
                                                <input type="" name="to[]" class="form-control" style="height:28px;" value="<?=$value['to']?>">
                                            </div>
                                            <div class="col-md-2">
                                                <!-- <button class="btn btn-xs"></button> -->
                                                <button type="button" onclick="$(this).parent().parent().parent().remove();" class="remove-item btn btn-danger btn-xs">
                                                    <i class="glyphicon glyphicon-minus" ></i></button>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" style="padding-left: 0px;margin-top:10px;" class="btn btn-xs btn-link add_diapazon">добавить диапазон цен.</button><br>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <label>Модифакатор</label>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-1">
                                <?=$form->field($model, 'mod_check')->widget(CheckboxX::classname(), [
                                        'labelSettings' => [
                                            'label' => '',
                                            'position' => CheckboxX::LABEL_RIGHT,
                                        ],
                                        'pluginOptions'=>[
                                            'threeState'=>false
                                        ],
                                        'options'=>[
                                            'style'=>'height:28px;',
                                            'onchange' => '
                                                setCheck($(this).val());CalculateEx(1,$(this).val());
                                            '
                                        ]
                                    ])->label(false);?>
                            </div>
                            <div class="col-md-6">
                                <div class="tab-content panel-bg" id="tab-3-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px !important;padding-bottom: 0px; margin-bottom: -30px;">
                                        <div id="ru-tab-3" data-id="ru" class="tab-pane active in tab-1">
                                            <?= $form->field($model, 'mod_title[ru]')->textInput(['value' => isset($model->mod_title['ru']) ? $model->mod_title['ru'] : null,'style'=>'height:26px;' ])->label(false)?>
                                        </div>
                                    <?php $i = 0; foreach($langs as $lang): ?>
                                        <?php if ($lang->url == 'ru') continue; ?>
                                        <div id="<?=$lang->url?>-tab-3" data-id="<?=$lang->url?>" class="tab-pane fade in tab-1">
                                            <?= $form->field($model, 'mod_title['.$lang->url.']')->textInput(['value' => isset($model->mod_title[$lang->url]) ? $model->mod_title[$lang->url] : null,'style'=>'height:26px;' ])->label(false) ?>
                                        </div>
                                    <?php $i++; endforeach;?>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:0px;">примери: Торг возможен, По результатам собесодования, ...</div>
                        </div>


                    </div>
                </div>
                <br>
                <?= $form->field($model, 'is_exchange',['template' => '<div class="row"><div class="col-md-2">
                    {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-6">{hint}</div></div>'])->widget(CheckboxX::classname(),
                    ['pluginOptions'=>[
                        'threeState'=>false
                    ],
                    'options' => [
                        'onchange' => 'CalculateEx(2,$(this).val());'
                    ]
                ]) ?>
                <?= $form->field($model, 'is_free',['template' => '<div class="row"><div class="col-md-2">
                    {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-6">{hint}</div></div>'])->widget(CheckboxX::classname(),
                    ['pluginOptions'=>[
                        'threeState'=>false
                    ],
                    'options' => [
                        'onchange' => 'CalculateEx(4,$(this).val());'
                    ]
                ]) ?>
                <?= $form->field($model, 'is_deal',['template' => '<div class="row"><div class="col-md-2">
                    {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-6">{hint}</div></div>'])->widget(CheckboxX::classname(),
                    ['pluginOptions'=>[
                        'threeState'=>false
                    ],
                    'options' => [
                        'onchange' => 'CalculateEx(8,$(this).val());'
                    ]
                ]) ?>
            </div>
        </div>
    </div>
    <br>
    <?= $form->field($model, 'ex')->hiddenInput(['id' => 'ex-value']) ?>

    <?= $form->field($model, 'photos',['template' => '<div class="row"><div class="col-md-2">
            {label}</div><div class="col-md-2">{input}{error}</div><div class="col-md-6">{hint}</div></div>'])->textInput(['class' => 'number_input form-control'])->hint(' - максимально доступное кол-во фотографий в объявлении(4-20)'); ?>

    <?= $form->field($model, 'owner_business',[
        'template' =>'<div class="row"><div class="col-md-2">
            {label}</div><div class="col-md-3">{input}{error}</div><div class="col-md-4">{hint}</div></div>'
        ])->radioList(
            $model->getPrice(),
            [
                'separator' => "&nbsp;&nbsp;&nbsp;&nbsp;",
                'onchange' => '
                    changeBusiness();
                '
            ]
        ) ?>
    <div class="row">
        <div class="col-md-2 offset-md-2">
        </div>
        <div class="col-md-8 panel-bg" id="div-business">
            <div class="row">
                <div class="col-md-2"><label>Частное лицо</label></div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="tab-content" id="tab-1-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
                            <div id="ru-tab-1" data-id="ru"  class="tab-pane fade in tab-1 active">
                                <div class="col-md-4">
                                    <?= $form->field($model, 'owner_private_form')->textInput([])->label(false)?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'owner_private_search')->textInput([])->label(false)?>
                                </div>
                            </div>
                            <?php $i = 0; foreach($langs as $lang): ?>
                                <?php if ($lang->url == 'ru') continue; ?>
                                <div id="<?=$lang->url?>-tab-1" data-id="<?=$lang->url?>" class="tab-pane fade in tab-1">
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'tarnslation_owner_private_form['.$lang->url.']')->textInput(['value' => isset($model->tarnslation_owner_private_form[$lang->url]) ? $model->tarnslation_owner_private_form[$lang->url] : null ])->label(false) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'translation_owner_private_search['.$lang->url.']')->textInput(['value' => isset($model->translation_owner_private_search[$lang->url]) ? $model->translation_owner_private_search[$lang->url] : null ])->label(false) ?>

                                    </div>
                                </div>
                                <?php $i++; endforeach;?>
                        </div>
                        <div class="col-md-4">
                            <?=$form->field($model, 'owner_search')->widget(CheckboxX::classname(), [
                                'autoLabel' => true,
                                'labelSettings' => [
                                    'position' => CheckboxX::LABEL_RIGHT,
                                ],
                                'pluginOptions'=>[
                                    'threeState'=>false
                                ],
                                'options'=>[
                                    'onchange' => '
                                        setSeek($(this).val());;
                                    '
                                ]
                            ])->label(false);?>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2"><label>Бизнес</label></div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="tab-content" id="tab-1-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
                            <div id="ru-tab-1" data-id="ru"  class="tab-pane fade in tab-1 active">
                                <div class="col-md-4">
                                    <?= $form->field($model, 'owner_business_form')->textInput([])->label(false)?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($model, 'owner_business_search')->textInput([])->label(false)?>
                                </div>
                            </div>
                            <?php $i = 0; foreach($langs as $lang): ?>
                                <?php if ($lang->url == 'ru') continue; ?>
                                <div id="<?=$lang->url?>-tab-1" data-id="<?=$lang->url?>" class="tab-pane fade in tab-1">
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'translation_owner_business_form['.$lang->url.']')->textInput(['value' => isset($model->translation_owner_business_form[$lang->url]) ? $model->translation_owner_business_form[$lang->url] : null ])->label(false) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $form->field($model, 'translation_owner_business_search['.$lang->url.']')->textInput(['value' => isset($model->translation_owner_business_search[$lang->url]) ? $model->translation_owner_business_search[$lang->url] : null ])->label(false) ?>

                                    </div>
                                </div>
                                <?php $i++; endforeach;?>
                        </div>

                        <div class="col-md-4">
                            <?=$form->field($model, 'owner_search_business')->widget(CheckboxX::classname(), [
                                'autoLabel' => true,
                                'labelSettings' => [
                                    'position' => CheckboxX::LABEL_RIGHT,
                                ],
                                'pluginOptions'=>[
                                    'threeState'=>false
                                ],
                                'options'=>[
                                    'onchange' => '
                                        setSeek($(this).val());;
                                    '
                                ]
                            ])->label(false);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?= $form->field($model, 'address',['template' => '<div class="row"><div class="col-md-2">
        {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-6">{hint}</div></div>'])->widget(CheckboxX::classname(),
        ['pluginOptions'=>[
            'threeState'=>false
        ]
    ])->hint('подробный адрес и карта') ?>
    <?= $form->field($model, 'metro',['template' => '<div class="row"><div class="col-md-2">
        {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-6">{hint}</div></div>'])->widget(CheckboxX::classname(),
        ['pluginOptions'=>[
            'threeState'=>false
        ]
    ])->hint('поиск по станции метро') ?>
    <?= $form->field($model, 'regions_delivery',['template' => '<div class="row"><div class="col-md-2">
        {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-6">{hint}</div></div>'])->widget(CheckboxX::classname(),
        ['pluginOptions'=>[
            'threeState'=>false
        ]
    ])->hint('доступна возможность указать доставку в регионы') ?>
        <?= $form->field($model, 'enabled',['template' => '<div class="row"><div class="col-md-2">
        {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-6">{hint}</div></div>'])->widget(CheckboxX::classname(),
        ['pluginOptions'=>[
            'threeState'=>false
        ]
    ])->hint('статус категории') ?>
    <br>
    <?= $form->field($model, 'list_type',['template' => '<div class="row">
                            <div class="col-md-2">{label}</div>
                            <div class="col-md-2">
                                {input}{error}
                            </div>
                            <div class="col-md-2">{hint}</div>
                        </div>'])->dropDownLIst($model->getListType());?>
    <?php $hint_url = '
        <button type="button" class="btn btn-xs btn-link" style="padding-left:0px;padding-top:0px;margin-top:-5px;" onclick="
            val = $(\'#categories-title\').val();
            $(\'#categories-keyword_edit\').val(generateSlug(val))">
            сгенерировать
        </button>';
    ?>
    <br>

    <?= $form->field($model, 'keyword_edit',['template' => '<div class="row"><div class="col-md-2">
            {label}<br>{hint}</div><div class="col-md-8">{input}{error}</div></div>'])->textInput(['class' => 'form-control'])->hint($hint_url); ?>
    <br>
    <?php if(!$model->isNewRecord): ?>
        <?= $form->field($model, 'keyword',['template' => '<div class="row"><div class="col-md-2">
            {label}<br>{hint}</div><div class="col-md-8">{input}{error}</div></div>'])->textInput(['class' => 'form-control']); ?>
    <?php endif;?>
    <br>
    <?= $form->field($model, 'search_exrta_keywords',['template' => '<div class="row"><div class="col-md-2">
            {label}<br>{hint}</div><div class="col-md-8">{input}{error}</div></div>'])->textarea(['placeholder' => 'Перечислите ключевые слова и фразы через запятаю','rows'=>6]); ?>
    <?= $form->field($model, 'telegram_chanel',['template' => '<div class="row"><div class="col-md-2">
            {label}<br>{hint}</div><div class="col-md-8">{input}{error}</div></div>'])->textInput(['class' => 'form-control']) ?>
    <br>
    <div id="div-image" style="display: none;">
        <div class="row">
            <div class="col-md-2">
                <?= $form->field($model, 'img')->hiddenInput(['id' => 'temp_address'])->hint('128x128') ?>
            </div>
            <div class="col-md-10">
                <label for="avatar" title="Выберите" data-toggle="tooltip" id="image_label" onmousemove="style.cursor='pointer'"><?=$model->getImg(false,'128px','128px')?></label>
                <input type="file" name="" id="avatar" style="display: none;" accept="image/*">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-2">
                <?= $form->field($model, 'small_img')->hiddenInput(['id' => 'temp_address_small'])->hint('32x32') ?>
            </div>
            <div class="col-md-10">
                <label for="avatar_small" title="Выберите" data-toggle="tooltip" id="image_label_small" onmousemove="style.cursor='pointer'"><?=$model->getImg(true,'32px','32px')?></label>
                <input type="file" name="" id="avatar_small" style="display: none;" accept="image/*">

            </div>
        </div>
    </div>
</div>

<div class="panel-footer row text-right">
    <div class="form-group col-md-10">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name' => 'submit-button', 'value' => \backend\models\items\Categories::TYPE_BASE]) ?>
            <button class="btn btn-inverse" type="button" onClick="history.back();">Отмена</button>
    </div>
</div>
<?php ActiveForm::end(); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2-rc.1/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.full.min.js"></script>
<?php
$seek = $model->seek;
$price = $model->price;
$mode_check = $model->mod_check;
$categories = $model->getCategoriesList();
$category = $model->parent_id;
$dirname = Categories::DIR_NAME;

$this->registerJS(<<<JS


    $(".number_input").inputFilter(function(value) {
      return /^\d*$/.test(value);
    });

    $(".add_diapazon").on('click',function(){
        template = $("#example").html();
        $("#diapozon_sen").append(template);
    })

    changeTab = function(obj){
        val = obj.attr('data-id');
        $('#tab-1-nav li').removeClass('active');
        $(".tab-1").removeClass('active');
        $("[data-id^='"+val+"']").addClass('active');
        obj.addClass('active');
    }

    changeDivImage = function(){
        if($("#mySelect").val() == null || $("#mySelect").val() == 1){
            $("#div-image").show(100);
        }else{
            $("#div-image").hide(100);
        }
    }

    changeBusiness = function(){
        val = $("input:radio[name=\'Categories[owner_business]\']:checked").val();
        if(val == 1){
            $("#div-business").show(200);
        }else{
            $("#div-business").hide(200);
        }
    }

    changePrice = function(){
        val = $("input:radio[name=\'Categories[price]\']:checked").val();
        if(val == 1){
            $("#div-price").show(200);
        }else{
            $("#div-price").hide(200);
        }
    }
    CalculateEx = function(val,check){
        old_value = parseInt($("#ex-value").val());
        if(old_value == 'NaN') {
            old_value = 0;
            $("#ex-value").val(0);
        }
        if(check == 1)
            new_value = old_value + parseInt(val);
        else
            new_value = old_value - parseInt(val);
        $("#ex-value").val(new_value);
    }

    setSeek = function(val){
        if(val != 1){
            $("#categories-type_seek_form").prop('readonly',true);
            $("#categories-type_seek_search").prop('readonly',true);
            
            $("#categories-translation_type_seek_form").prop('readonly',true);
            $("#categories-translation_type_seek_search").prop('readonly',true);
        }else{
            $("#categories-type_seek_form").prop('readonly',false);
            $("#categories-type_seek_search").prop('readonly',false);
            
            $("#categories-translation_type_seek_form").prop('readonly',false);
            $("#categories-translation_type_seek_search").prop('readonly',false);
        }
    }

    setCheck = function(val){
        if(val != 1){
            $("[id^='categories-mod_title']").prop('readonly',true);
        }else{
            $("[id^='categories-mod_title']").prop('readonly',false);
        }
    }

    $("#ru-tab-1").addClass('active');

    $(document).ready(function(){
        changeBusiness();
        setCheck('$mode_check');
        changePrice();
        setSeek('$seek')
        $("#ru-tab-1").addClass('active');
        changeDivImage();
        var data = $categories;
        function formatResult(node) {
            var result = $('<span style="padding-left:' + (20 * node.level) + 'px;">' + node.text + '</span>');
            return result;
        };

        $("#mySelect").select2({
            placeholder: 'Select an option',
            width: "600px",
            data: data,
            formatSelection: function(item) {
              return item.text
            },
            formatResult: function(item) {
              return item.text
            },
            templateResult: formatResult,
        });
        $('#mySelect').val($category).trigger('change');
    })

    $(".form-group").css("margin-bottom","0px");

    generateSlug = function(str){
        str = String(str).toString();
        str = str.replace(/^\s+|\s+$/g, ""); // trim
        str = str.toLowerCase();

        // remove accents, swap ñ for n, etc
        const swaps = {
            '0': ['°', '₀', '۰', '０'],
            '1': ['¹', '₁', '۱', '１'],
            '2': ['²', '₂', '۲', '２'],
            '3': ['³', '₃', '۳', '３'],
            '4': ['⁴', '₄', '۴', '٤', '４'],
            '5': ['⁵', '₅', '۵', '٥', '５'],
            '6': ['⁶', '₆', '۶', '٦', '６'],
            '7': ['⁷', '₇', '۷', '７'],
            '8': ['⁸', '₈', '۸', '８'],
            '9': ['⁹', '₉', '۹', '９'],
            'a': ['à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'ā', 'ą', 'å', 'α', 'ά', 'ἀ', 'ἁ', 'ἂ', 'ἃ', 'ἄ', 'ἅ', 'ἆ', 'ἇ', 'ᾀ', 'ᾁ', 'ᾂ', 'ᾃ', 'ᾄ', 'ᾅ', 'ᾆ', 'ᾇ', 'ὰ', 'ά', 'ᾰ', 'ᾱ', 'ᾲ', 'ᾳ', 'ᾴ', 'ᾶ', 'ᾷ', 'а', 'أ', 'အ', 'ာ', 'ါ', 'ǻ', 'ǎ', 'ª', 'ა', 'अ', 'ا', 'ａ', 'ä'],
            'b': ['б', 'β', 'ب', 'ဗ', 'ბ', 'ｂ'],
            'c': ['ç', 'ć', 'č', 'ĉ', 'ċ', 'ｃ'],
            'd': ['ď', 'ð', 'đ', 'ƌ', 'ȡ', 'ɖ', 'ɗ', 'ᵭ', 'ᶁ', 'ᶑ', 'д', 'δ', 'د', 'ض', 'ဍ', 'ဒ', 'დ', 'ｄ'],
            'e': ['é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'ë', 'ē', 'ę', 'ě', 'ĕ', 'ė', 'ε', 'έ', 'ἐ', 'ἑ', 'ἒ', 'ἓ', 'ἔ', 'ἕ', 'ὲ', 'έ', 'е', 'ё', 'э', 'є', 'ə', 'ဧ', 'ေ', 'ဲ', 'ე', 'ए', 'إ', 'ئ', 'ｅ'],
            'f': ['ф', 'φ', 'ف', 'ƒ', 'ფ', 'ｆ'],
            'g': ['ĝ', 'ğ', 'ġ', 'ģ', 'г', 'ґ', 'γ', 'ဂ', 'გ', 'گ', 'ｇ'],
            'h': ['ĥ', 'ħ', 'η', 'ή', 'ح', 'ه', 'ဟ', 'ှ', 'ჰ', 'ｈ'],
            'i': ['í', 'ì', 'ỉ', 'ĩ', 'ị', 'î', 'ï', 'ī', 'ĭ', 'į', 'ı', 'ι', 'ί', 'ϊ', 'ΐ', 'ἰ', 'ἱ', 'ἲ', 'ἳ', 'ἴ', 'ἵ', 'ἶ', 'ἷ', 'ὶ', 'ί', 'ῐ', 'ῑ', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'і', 'ї', 'и', 'ဣ', 'ိ', 'ီ', 'ည်', 'ǐ', 'ი', 'इ', 'ی', 'ｉ'],
            'j': ['ĵ', 'ј', 'Ј', 'ჯ', 'ج', 'ｊ'],
            'k': ['ķ', 'ĸ', 'к', 'κ', 'Ķ', 'ق', 'ك', 'က', 'კ', 'ქ', 'ک', 'ｋ'],
            'l': ['ł', 'ľ', 'ĺ', 'ļ', 'ŀ', 'л', 'λ', 'ل', 'လ', 'ლ', 'ｌ'],
            'm': ['м', 'μ', 'م', 'မ', 'მ', 'ｍ'],
            'n': ['ñ', 'ń', 'ň', 'ņ', 'ŉ', 'ŋ', 'ν', 'н', 'ن', 'န', 'ნ', 'ｎ'],
            'o': ['ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ø', 'ō', 'ő', 'ŏ', 'ο', 'ὀ', 'ὁ', 'ὂ', 'ὃ', 'ὄ', 'ὅ', 'ὸ', 'ό', 'о', 'و', 'θ', 'ို', 'ǒ', 'ǿ', 'º', 'ო', 'ओ', 'ｏ', 'ö'],
            'p': ['п', 'π', 'ပ', 'პ', 'پ', 'ｐ'],
            'q': ['ყ', 'ｑ'],
            'r': ['ŕ', 'ř', 'ŗ', 'р', 'ρ', 'ر', 'რ', 'ｒ'],
            's': ['ś', 'š', 'ş', 'с', 'σ', 'ș', 'ς', 'س', 'ص', 'စ', 'ſ', 'ს', 'ｓ'],
            't': ['ť', 'ţ', 'т', 'τ', 'ț', 'ت', 'ط', 'ဋ', 'တ', 'ŧ', 'თ', 'ტ', 'ｔ'],
            'u': ['ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'û', 'ū', 'ů', 'ű', 'ŭ', 'ų', 'µ', 'у', 'ဉ', 'ု', 'ူ', 'ǔ', 'ǖ', 'ǘ', 'ǚ', 'ǜ', 'უ', 'उ', 'ｕ', 'ў', 'ü'],
            'v': ['в', 'ვ', 'ϐ', 'ｖ'],
            'w': ['ŵ', 'ω', 'ώ', 'ဝ', 'ွ', 'ｗ'],
            'x': ['χ', 'ξ', 'ｘ'],
            'y': ['ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'ÿ', 'ŷ', 'й', 'ы', 'υ', 'ϋ', 'ύ', 'ΰ', 'ي', 'ယ', 'ｙ'],
            'z': ['ź', 'ž', 'ż', 'з', 'ζ', 'ز', 'ဇ', 'ზ', 'ｚ'],
            'aa': ['ع', 'आ', 'آ'],
            'ae': ['æ', 'ǽ'],
            'ai': ['ऐ'],
            'ch': ['ч', 'ჩ', 'ჭ', 'چ'],
            'dj': ['ђ', 'đ'],
            'dz': ['џ', 'ძ'],
            'ei': ['ऍ'],
            'gh': ['غ', 'ღ'],
            'ii': ['ई'],
            'ij': ['ĳ'],
            'kh': ['х', 'خ', 'ხ'],
            'lj': ['љ'],
            'nj': ['њ'],
            'oe': ['ö', 'œ', 'ؤ'],
            'oi': ['ऑ'],
            'oii': ['ऒ'],
            'ps': ['ψ'],
            'sh': ['ш', 'შ', 'ش'],
            'shch': ['щ'],
            'ss': ['ß'],
            'sx': ['ŝ'],
            'th': ['þ', 'ϑ', 'ث', 'ذ', 'ظ'],
            'ts': ['ц', 'ც', 'წ'],
            'ue': ['ü'],
            'uu': ['ऊ'],
            'ya': ['я'],
            'yu': ['ю'],
            'zh': ['ж', 'ჟ', 'ژ'],
            '(c)': ['©'],
            'A': ['Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'Å', 'Ā', 'Ą', 'Α', 'Ά', 'Ἀ', 'Ἁ', 'Ἂ', 'Ἃ', 'Ἄ', 'Ἅ', 'Ἆ', 'Ἇ', 'ᾈ', 'ᾉ', 'ᾊ', 'ᾋ', 'ᾌ', 'ᾍ', 'ᾎ', 'ᾏ', 'Ᾰ', 'Ᾱ', 'Ὰ', 'Ά', 'ᾼ', 'А', 'Ǻ', 'Ǎ', 'Ａ', 'Ä'],
            'B': ['Б', 'Β', 'ब', 'Ｂ'],
            'C': ['Ç', 'Ć', 'Č', 'Ĉ', 'Ċ', 'Ｃ'],
            'D': ['Ď', 'Ð', 'Đ', 'Ɖ', 'Ɗ', 'Ƌ', 'ᴅ', 'ᴆ', 'Д', 'Δ', 'Ｄ'],
            'E': ['É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'Ë', 'Ē', 'Ę', 'Ě', 'Ĕ', 'Ė', 'Ε', 'Έ', 'Ἐ', 'Ἑ', 'Ἒ', 'Ἓ', 'Ἔ', 'Ἕ', 'Έ', 'Ὲ', 'Е', 'Ё', 'Э', 'Є', 'Ə', 'Ｅ'],
            'F': ['Ф', 'Φ', 'Ｆ'],
            'G': ['Ğ', 'Ġ', 'Ģ', 'Г', 'Ґ', 'Γ', 'Ｇ'],
            'H': ['Η', 'Ή', 'Ħ', 'Ｈ'],
            'I': ['Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị', 'Î', 'Ï', 'Ī', 'Ĭ', 'Į', 'İ', 'Ι', 'Ί', 'Ϊ', 'Ἰ', 'Ἱ', 'Ἳ', 'Ἴ', 'Ἵ', 'Ἶ', 'Ἷ', 'Ῐ', 'Ῑ', 'Ὶ', 'Ί', 'И', 'І', 'Ї', 'Ǐ', 'ϒ', 'Ｉ'],
            'J': ['Ｊ'],
            'K': ['К', 'Κ', 'Ｋ'],
            'L': ['Ĺ', 'Ł', 'Л', 'Λ', 'Ļ', 'Ľ', 'Ŀ', 'ल', 'Ｌ'],
            'M': ['М', 'Μ', 'Ｍ'],
            'N': ['Ń', 'Ñ', 'Ň', 'Ņ', 'Ŋ', 'Н', 'Ν', 'Ｎ'],
            'O': ['Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'Ø', 'Ō', 'Ő', 'Ŏ', 'Ο', 'Ό', 'Ὀ', 'Ὁ', 'Ὂ', 'Ὃ', 'Ὄ', 'Ὅ', 'Ὸ', 'Ό', 'О', 'Θ', 'Ө', 'Ǒ', 'Ǿ', 'Ｏ', 'Ö'],
            'P': ['П', 'Π', 'Ｐ'],
            'Q': ['Ｑ'],
            'R': ['Ř', 'Ŕ', 'Р', 'Ρ', 'Ŗ', 'Ｒ'],
            'S': ['Ş', 'Ŝ', 'Ș', 'Š', 'Ś', 'С', 'Σ', 'Ｓ'],
            'T': ['Ť', 'Ţ', 'Ŧ', 'Ț', 'Т', 'Τ', 'Ｔ'],
            'U': ['Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'Û', 'Ū', 'Ů', 'Ű', 'Ŭ', 'Ų', 'У', 'Ǔ', 'Ǖ', 'Ǘ', 'Ǚ', 'Ǜ', 'Ｕ', 'Ў', 'Ü'],
            'V': ['В', 'Ｖ'],
            'W': ['Ω', 'Ώ', 'Ŵ', 'Ｗ'],
            'X': ['Χ', 'Ξ', 'Ｘ'],
            'Y': ['Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ', 'Ÿ', 'Ῠ', 'Ῡ', 'Ὺ', 'Ύ', 'Ы', 'Й', 'Υ', 'Ϋ', 'Ŷ', 'Ｙ'],
            'Z': ['Ź', 'Ž', 'Ż', 'З', 'Ζ', 'Ｚ'],
            'AE': ['Æ', 'Ǽ'],
            'Ch': ['Ч'],
            'Dj': ['Ђ'],
            'Dz': ['Џ'],
            'Gx': ['Ĝ'],
            'Hx': ['Ĥ'],
            'Ij': ['Ĳ'],
            'Jx': ['Ĵ'],
            'Kh': ['Х'],
            'Lj': ['Љ'],
            'Nj': ['Њ'],
            'Oe': ['Œ'],
            'Ps': ['Ψ'],
            'Sh': ['Ш'],
            'Shch': ['Щ'],
            'Ss': ['ẞ'],
            'Th': ['Þ'],
            'Ts': ['Ц'],
            'Ya': ['Я'],
            'Yu': ['Ю'],
            'Zh': ['Ж'],
        };

        Object.keys(swaps).forEach((swap) => {
            swaps[swap].forEach(s => {
                str = str.replace(new RegExp(s, "g"), swap);
            })
        });
        result = str
            .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
            .replace(/\s+/g, "-") // collapse whitespace and replace by -
            .replace(/-+/g, "-") // collapse dashes
            .replace(/^-+/, "") // trim - from start of text
            .replace(/-+$/, "");
        return result;
    }

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
        data.append('dir_name', '$dirname') ;
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
                // dir = '/uploads/trash/' + new_name;
                $("#image_label img").attr('style','width:150px;height:150px');
                $("#image_label img").attr('src',success);
            },
            error: function(success){
                alert(success);
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
        data.append('dir_name', '$dirname') ;
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
                // dir = '/uploads/trash/' + new_name;
                $("#image_label_small img").attr('style','width:50px;height:50px');
                $("#image_label_small img").attr('src',success);
            },
            error: function(success){
                alert(success);
                alert("Error occur uploading image. Try again ((");
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
)
?>