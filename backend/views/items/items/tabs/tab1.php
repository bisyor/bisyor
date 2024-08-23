<?php
use kartik\select2\Select2;
use yii\helpers\Html;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use backend\models\items\Items;
use yii\widgets\Pjax;
use johnitvn\ajaxcrud\CrudAsset;

CrudAsset::register($this);

$i = 0;
$model->title = html_entity_decode($model->title);
?>
<script type="text/javascript" src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=34732a31-453c-414d-b319-d908d1edea51"></script>

<div class="shops-shops-form" style="padding-right: 20px; padding-left: 20px; padding-top: 20px;">
    <?php
        $templateInput = '<div class="row"><div class="col-md-2">
                    {label}{hint}</div><div class="col-md-4">{input}{error}</div></div>
                    ';
        $templateInput2 = '<div class="row"><div class="col-md-2">
                    {label}</div><div class="col-md-8">{input}{hint}{error}</div></div>
                    ';
    ?>
    <?= $form->field($model, 'title',[
                'template' => '<div class="row"><div class="col-md-2">
                    {label}{hint}</div><div class="col-md-8">{input}{error}</div><div class="col-md-2"><label class="btn btn-warning btn-xs" id="title-case" style="margin-top: 7px;"><i class="fa fa-text-height"></i></label></div></div>
                '])->textInput() ?>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <?php
                if($model->old_title) {
                    echo '<a href="#" class="label label-inverse old_title">Старое значения заголовок</a><p></p>';
                }
            ?>
            <p id="old_title_form" style="display: none"><?= $model->old_title?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label>Категория &nbsp;<b style="color: red">*</b></label>
        </div>
        <div class="col-md-10" id="categories" style="padding-left: 0px;">
        </div>
    </div>
     <?= $form->field($model, 'cat_id')->hiddenInput(['id' => 'items-cat_id'])->label(false) ?>
    <hr>
    <div id="additional-fields">
        <?= $this->render('additional_fields',[
            'category' => $category,
            'fields' => $fields,
            'model' => $model
        ])?>
    </div>
    <br>
    <?= $form->field($model, 'description',['template' => '<div class="row"><div class="col-md-2">
                    {label}</div><div class="col-md-8">{input}{hint}{error}</div>
                        <div class="col-md-2">
                            <label class="btn btn-warning btn-xs" id="description-case" style="margin-top: 60px;">
                                <i class="fa fa-text-height"></i>
                            </label>
                        </div>
                    </div>
                    '])->textarea(['rows' => 8]) ?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <?php
            if($model->old_description) {
                echo '<a  class="label label-inverse old_description">Старое значения Описание</a><p></p>';
            }
            ?>
            <p id="old_description_form" style="display: none"><?= $model->old_description?></p>
        </div>
    </div>
    <?= $form->field($model, 'video',['template' => $templateInput2])->textInput([])->hint('Youtube') ?>
    <hr>
    <?= $form->field($model, 'publicated_period',['template' => $templateInput])->dropDownList($model->getPeriodList()) ?>
    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'user_id',['template' => $templateInput])->widget(Select2::classname(), [
                    'data' => $model->getUsersList(),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Выберите'],
                    'pluginOptions' => [
                        'allowClear' => true,
                ],
        ]);?>
    <?php endif ?>
    <?php if (!$model->isNewRecord): ?>

    <div class="row">
            <div class="col-md-2">
                <label>Пользователь</label>
            </div>
            <div class="col-md-8">
                <?= Html::a($model->user->getUserFio(), Url::to(['/items/items/user-info', 'id' => $model->id]), [
                    'role'=>'modal-remote','title'=> '',
                    'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-link'
                ]);
                ?>
            </div>
    </div>
    <br>
    <?= $form->field($model, 'name',['template' => $templateInput])->textInput()?>
    <?php if ($model->shop_id > 0): ?>
        <?= $form->field($model, 'item_owner_type',[
            'template' =>'<div class="row"><div class="col-md-2">
                {label}</div><div class="col-md-3">{input}{error}</div><div class="col-md-4">{hint}</div></div>'
            ])->radioList(
                $model->getOwnerType(),
                [
                    'separator' => "&nbsp;&nbsp;&nbsp;&nbsp;",
                    'onchange' => '
                        changeBusiness();
                    '
                ]
            )->label(false) ?>
    <?php endif ?>
       
    <?= $form->field($model, 'phones',['template' => $templateInput])->widget(MultipleInput::className(), [
                'max'               => 4,
                'min'               => 1,
                'allowEmptyList'    => false,
                'columns' => [
                    [
                        'name' => 'phones',
                        'enableError' => true,
                        'type' => \yii\widgets\MaskedInput::className(),
                        'options' => [
                            'mask' => '+99999-999-99-99',
                            'options' =>[
                                'class' => 'form-control'
                            ],
                        ],
                    ],
                ],
                'addButtonPosition' => MultipleInput::POS_ROW, // show add button in the header
            ])?>
    <?php endif ?>
    <?= $form->field($model, 'verified',['template' => $templateInput])->widget(\dosamigos\switchery\Switchery::className(), [
        'options' => [
            'label' => false
        ],
        'clientOptions' => [
            'color' => '#5fbeaa',
        ]
    ])?>
    <div class="row">
        <div class="col-md-2">
            <p><b>Линк Olx</b></p>
        </div>
        <div class="col-md-10">
            <?= $model->user_id != null ? $model->user->olx_link : ''?>
        </div>
    </div>
    <br>
    <?php if (!$model->isNewRecord): ?>
        <div class="panel-bg">

            <div class="row">
                <div class="col-md-2">
                    <label>Статус</label>
                </div>
                <div class="col-md-10">
                    <?php Pjax::begin(['enablePushState' => false,'id' => 'crud-datatable-pjax'])?>
                        <?=$model->getStatusName();?>
                    <?php Pjax::end()?>
                </div>
            </div>
    <?php endif ?>

    <br>
    <?php if (!$model->isNewRecord): ?>
            <div class="row">
                <div class="col-md-2">
                    <label>Период</label>
                </div>
                <div class="col-md-10">
                    от <?=date('d.m.Y',strtotime($model->publicated))?> до <b><?=date('d.m.Y',strtotime($model->publicated_to))?></b>
                    <br>
                    <br>
                    <?php if ($model->getStatus() == Items::STATUS_PUBLICATIOM): ?>
                        <?=Html::a('снят c публикации', Url::to(['/items/items/change-status', 'id' => $model->id, 'status' => Items::STATUS_INPUBLICATION ]),
                              [
                                'role'=>'modal-remote',
                                'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                'data-request-method'=>'post',
                                'data-toggle'=>'tooltip',
                                'data-confirm-title'=>'Подтвердите действие',
                                'data-confirm-message'=>'Вы уверены что хотите снят c публикации этого элемента?',
                                  'class'=>'btn btn-sm btn-warning'
                              ])?>
                        <?=Html::a('на модерации ', Url::to(['/items/items/change-status', 'id' => $model->id, 'status' => Items::STATUS_MODERATING]),
                            [
                                'role'=>'modal-remote',
                                'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                'data-request-method'=>'post',
                                'data-toggle'=>'tooltip',
                                'data-confirm-title'=>'Подтвердите действие',
                                'data-confirm-message'=>'Вы уверены что хотите на модерации этого элемента?',
                                'class'=>'btn btn-sm btn-primary'
                            ])?>
                        <?=Html::a('заблокировать', Url::to(['/items/items/block-item' , 'id' => $model->id, 'status' => Items::STATUS_BLOCKED]),
                              [
                                'role'=>'modal-remote',
                                'class'=>'btn btn-sm btn-danger'
                              ])?>
                    <?php endif ?>
                    <?php if ($model->getStatus() == Items::STATUS_INPUBLICATION): ?>
                        <?=Html::a('опубликовать', Url::to(['/items/items/change-status', 'id' => $model->id, 'status' => Items::STATUS_PUBLICATIOM ]),
                              [
                                'role'=>'modal-remote',
                                'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                'data-request-method'=>'post',
                                'data-toggle'=>'tooltip',
                                'data-confirm-title'=>'Подтвердите действие',
                                'data-confirm-message'=>'Вы уверены что хотите опубликовать этого элемента?',
                                  'class'=>'btn btn-sm btn-info'
                              ])?>
                        <?=Html::a('заблокировать', Url::to(['/items/items/block-item' , 'id' => $model->id, 'status' => Items::STATUS_BLOCKED]),
                            [
                                'role'=>'modal-remote',
                                'class'=>'btn btn-sm btn-danger'
                            ])?>
                    <?php endif ?>
                    <?php if ($model->getStatus() == Items::STATUS_MODERATING): ?>
                        <?=Html::a('проверено', Url::to(['/items/items/change-status', 'id' => $model->id, 'status' => Items::STATUS_PUBLICATIOM ]),
                              [
                                'role'=>'modal-remote',
                                'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                'data-request-method'=>'post',
                                'data-toggle'=>'tooltip',
                                'data-confirm-title'=>'Подтвердите действие',
                                'data-confirm-message'=>'Вы уверены что хотите стать проверено этого элемента?',
                                  'class'=>'btn btn-sm btn-success'
                              ])?>
                        <?=Html::a('заблокировать', Url::to(['/items/items/block-item' , 'id' => $model->id, 'status' => Items::STATUS_BLOCKED]),
                            [
                                'role'=>'modal-remote',
                                'class'=>'btn btn-sm btn-danger'
                            ])?>
                    <?php endif ?>
                    <?php if ($model->getStatus() == Items::STATUS_BLOCKED): ?>
                        <div class="alert alert-danger">
                          <strong>Причина блокировки</strong>
                          <div id="current-content">
                            <p><span id="result"><?=$model->blocked_reason?></span>
                            - <button type="button" onclick="$('#change-content').show();$('#current-content').hide()" class="btn btn-xs btn-link">изменить</button></p>
                          </div>
                          <div id="change-content" style="display: none;">
                            <br>
                            <select style="width: 50%" class="form-control input-sm" id="blocked_reason">
                              <?php foreach (Items::BLOCKED_REASONS as $key => $value): ?>
                                <option value="<?=$value?>" <?=($model->blocked_reason == $value) ? 'selected' : '' ?>>
                                  <?=$value?>
                                </option>
                              <?php endforeach ?>
                            </select>
                            <br>
                            <button type="button" value="<?=$model->id?>" onclick="$.post('/items/items/change-blocked-reason?value='+$('#blocked_reason').val() + '&id=' +$(this).val(),function(success){$('#result').html(success);$('#cancel-button').trigger('click');})" class="btn btn-sm btn-info">изменить причину</button>
                            <?=Html::a('разблокировать', ['/items/items/change-status', 'id' => $model->id, 'status' => $model->status_prev ],
                              [
                                'role'=>'modal-remote',
                                'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                'data-request-method'=>'post',
                                'data-toggle'=>'tooltip',
                                'data-confirm-title'=>'Подтвердите действие',
                                'data-confirm-message'=>'Вы уверены что хотите разблокировать этого элемента?',
                                  'class'=>'btn btn-sm btn-success'
                              ])?>
                            <button type="button" id="cancel-button" onclick="$('#change-content').hide();$('#current-content').show()" class="btn btn-sm btn-default">отмена</button>
                          </div>
                        </div>
                    <?php endif ?>
                    <?php if ($model->getStatus() == Items::STATUS_DELETED): ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    <?php endif ?>

    <div id="hidden-additional-fields">
        <?php
            $dynamic_fields_based_category = [
                'owner_type',
                'cat_type',
                'coordinate_x',
                'coordinate_y',
                'price',
                'price_search',
                'currency_id',
                'address',
                'price_ex',
                'price_end',
            ];
            $dynamic_fields_based_category_setting_count = 25;
            foreach ($dynamic_fields_based_category as $key => $value) {
                echo '<input type="hidden" data-id="'.$value.'" name="Items['.$value.']" id="hidden-items-'.$value.'" value="'.$model->{$value}.'">';
            }
            $k = 1;
            while ($k < $dynamic_fields_based_category_setting_count) {
                $value = 'f'.$k;
                $k++;
                echo '<input type="hidden" data-id="'.$value.'" name="Items['.$value.']" id="hidden-items-'.$value.'" value="'.$model->{$value}.'">';
            }
         ?>
     </div>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2-rc.1/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.full.min.js"></script>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>

<?php Modal::end(); ?>
<?php
$id = isset($model->id) ? $model->id : -1;
$categories = $model->getCategoriesList();
$this->registerJS(<<<JS

    $('#title-case').on('click',
    function() {
       var title = $('#items-title').val();
        if(title == $('#items-title').val().toUpperCase()){
             $('#items-title').val(title[0].toUpperCase() + title.substring(1).toLowerCase());
        } else {
             $('#items-title').val(title.toUpperCase());
        }
    });

    $('#description-case').on('click',
        function() {
           var description = $('#items-description').val();
            if(description == $('#items-description').val().toUpperCase()){
                  $('#items-description').val(description[0].toUpperCase() + description.substring(1).toLowerCase());
            } else {
                 $('#items-description').val(description.toUpperCase());
            }
    });

    
    $("#items-name").parent('div').parent('div').parent('div').addClass('required');
    data = $categories;
    $("#ru-tab-1").addClass('active');
    arr = [];
    getParents = function(child_id){
        if(child_id == '') {
            return;
        }
        child = data.filter(word => word.id == child_id)[0];
        while(child.parent_id != null){
            arr.unshift(child.id);
            child = data.filter(word => word.id == child.parent_id)[0];
        }
    }
    $('#items-form').submit(function() {
        t = true;
        
        $("#additional-fields [id^='items-']").each(function(index,element)
        {
            id_input = $(this).attr('id');
            id = 'hidden-' + id_input;
            div = $('.field-'+id_input);
            label = div.children('div').children('div').eq(0).children('label').html();
            err_message = 'Необходимо заполнить «' + label +'».';
            if(div.hasClass('required') && $(this).val() == '' && $(this).attr('role') != 'checkboxgroup' && $(this).attr('role') != 'radiogroup'){
                div.children('div').children('div').eq(1).children('div').eq(1).html(err_message);
                div.addClass('has-error');
                t = false;
            }
            if($(this).attr('role') != 'checkboxgroup' && $(this).attr('role') != 'radiogroup')
                $("#" + id).val($(this).val());
        });

        if($('#items-cat_id').val() == ''){
            t = false;
            error_message = 'Необходимо заполнить «Категория».';
            $('#categories div:last-child').children('div.help-block').html(error_message);
            $('#categories div:last-child').addClass('has-error');
        }
        return t;
    });

    validated = function(el){
        id_input = el.attr('id');
        id = 'hidden-' + id_input;
        div = $('.field-'+id_input);
        label = div.children('div').children('div').eq(0).children('label').html();
        if(div.hasClass('required') && $(this).val() == ''){
            div.children('div').children('div').eq(1).children('div').eq(1).html(err_message);
            div.removeClass('has-success');
            div.addClass('has-error');
        }else{
            div.children('div').children('div').eq(1).children('div').eq(1).html('');
            div.removeClass('has-error');
            div.addClass('has-success');
        }
    }

    var c = 1;
    addSelect = function(el){
        val = el.val();
        divs = el.parent('div').nextAll('div');
        for(i=0;i<divs.length;i++){
            divs[i].remove();
        }
        filtered_data = data.filter(word => word.parent_id == val);
        if(el.parent('div').hasClass('has-error')){
            el.parent('div').removeClass('has-error');
            el.parent('div').addClass('has-success');
            el.parent('div').children('div').html('');
        }
        $("#items-cat_id").val('');
        if(filtered_data.length > 0){
            c++;
            template = '<div class="col-md-4" style="margin-bottom:10px;"><input type="" name="" id="child-select-' + c +'" onchange="addSelect($(this))"><div class="help-block"></div></div>';
            $("#categories").append(template);
            $("#child-select-" + c).select2({
                placeholder: 'Вибериты',
                width: "100%",
                data: filtered_data
            });
        }else{
            // $('#submit').prop('disabled',true);
            $("#items-cat_id").val(val);
            $.post('/items/items/show-additional-fields?category_id='+val + '&model_id='+$id,function(data){
                $('#additional-fields').html(data);
                // $('#submit').prop('disabled',false);
                
                $(".float_number_input").inputFilter(function(value) {
                    return /^-?\d*[.]?\d{0,2}$/.test(value); 
                });
                $(".number_input").inputFilter(function(value) {
                  return /^\d*$/.test(value);
                });
            })  
        }
        $('#additional-fields').html('');
    }
    
    $(document).ready(function(){
        $("#ru-tab-1").addClass('active');
        cat_id = $("#items-cat_id").val();
        getParents(cat_id);
        $("#items-cat_id").val('');
        arr.unshift(1);
        for(i =0; i< arr.length; i++){
            filtered_data = data.filter(word => word.parent_id == arr[i]);
            if(filtered_data.length > 0){
                template = '<div class="col-md-4" style="margin-bottom:10px;"><input type="" name="" id="child-select-' + i +'" onchange="addSelect($(this))"><div class="help-block"></div></div>';
                $("#categories").append(template);
                if(i+1<arr.length){
                    label = data.filter(word => word.id == arr[i + 1])[0].text;
                    $("#child-select-" + i).select2({
                        placeholder: {
                            id: arr[i],
                            text: label
                        },
                        width: "100%",
                        data: filtered_data
                    });
                }else{
                    $("#child-select-" + i).select2({
                        placeholder: 'Выберите',
                        width: "100%",
                        data: filtered_data
                    });
                }
            }else{
                $("#items-cat_id").val(arr[i]);
                $.post('/items/items/show-additional-fields?category_id='+arr[i]+ '&model_id='+$id,function(data){
                    $('#additional-fields').html(data);
                    $(".float_number_input").inputFilter(function(value) {
                        return /^-?\d*[.]?\d{0,2}$/.test(value); 
                    });
                    $(".number_input").inputFilter(function(value) {
                      return /^\d*$/.test(value);
                    });

                    //price ni qiymatiga ko'ra update da chiqarish
                    price = parseInt($('#hidden-items-price_ex').val());
                    if(price%2 == 1){
                        $('#price-ex-checkbox').prop('checked',true);
                        price -= 1;
                    }
                    $('#radio-price-'+price).prop('checked',true);

                    //qolgan oddiy additional inputlarni qiymatini chiqarish
                    $("#hidden-additional-fields [id^='hidden-items-']").each(function(index,element)
                    {
                        id_input = $(this).attr('data-id');

                        if($("#items-" + id_input).attr('role') == 'checkboxgroup'){
                            checkboxes = $("#items-" + id_input + ' input:checkbox');
                            value = parseInt($(this).val());
                            for(i=checkboxes.length-1;i>=0;i--){
                                chexkbox = checkboxes.eq(i);
  
                                if(value >= chexkbox.attr('value')){
                                    chexkbox.prop('checked',true);
                                    value -= parseInt(chexkbox.val());
                                }
                            }
                        }else if($("#items-" + id_input).attr('role') == 'radiogroup'){
                            value = parseInt($(this).val());
                            $("#items-" + id_input + " input:radio[value='" +value + "']").prop('checked',true);
                        }else{
                            input = $("#items-" + id_input);
                            input.val($(this).val());
                            if(id_input == 'price'){
                                 formatCurrency($("#items-price"));
                            }
                            
                            if(id_input == 'price_end'){
                                 formatCurrency($("#items-price_end"));
                            }
                        }
                    });
                })  
            }
        }
    });

    
   

JS
)
?>
