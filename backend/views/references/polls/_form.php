<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;


$this->title = "Опросы";
$this->params['breadcrumbs'][] = ['label' => "Опросы", 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Создать' : 'Изменить';
$x=1;
?>
<style type="text/css" media="screen">
    .panel {
        margin-bottom: 0 !important;
    }
</style>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Опросы</h4>
    </div>
    <div class="panel-body" style="margin: 10px 25px;">
        <?php $form = ActiveForm::begin([]); ?>
            <div class="row">
                <div class="col-md-2">
                    <b><?=$model->attributeLabels()['name'];?></b>
                </div>
                <div class="col-md-9" >
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <b><?=$model->attributeLabels()['start'];?></b>
                </div>
                <div class="col-md-3" >
                    <?= $form->field($model, 'start')->widget(
                        DatePicker::className(), [
                            'language' => 'ru',
                            'options' => ['autocomplete'=>'off'],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd.mm.yyyy',
                            ]
                        ])->label(false)
                    ?> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <b><?=$model->attributeLabels()['finish'];?></b>
                </div>
                <div class="col-md-3"  id="finishType" <?=$model->finish_type != 2 ? 'style="display:none"' : ''?> >
                    <?= $form->field($model, 'finish')->widget(
                        DatePicker::className(), [
                            'language' => 'ru',
                            'options' => ['autocomplete'=>'off'],
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd.mm.yyyy',
                            ]
                        ])->label(false)
                    ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'finish_type')->dropDownList($model->geFinishType(),[])->label(false)?>
                </div>
            </div>
            <!-- variant otveta -->
            <hr style="border-top: 1px solid gray;">
            <div class="row" >
                <div class="col-md-2">
                    <b><?=$model->attributeLabels()['varinat_otver'];?></b>
                </div>
                <div class="col-md-10 ui-sortable" id="sortList">
                    <?php foreach ($values as $key => $value): $x=1;?>
                        <div class="panel" data-id='<?=$x?>' data-sortable-id="ui-general-<?=$x?>">
                            <div class="panel-heading row">
                                <div class="col-md-10">
                                    <input style="margin-left: -15px;" type="text" value="<?=$value?>" name="names[<?= $key?>]" class="form-control ">
                                </div>
                                <div class="col-md-2">
                                    <p  class="btn btn-md btn-icon btn-inverse "><i class="fa fa-list"></i></p>&nbsp&nbsp&nbsp
                                    <button type="button" class="btn btn-md btn-icon btn-danger remove_field"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    <?php $x++; endforeach ?>
                </div>
                 
            </div>
            <div class="row">
                <div class="col-md-2">
                   
                </div>
                <div class="col-md-8">
                    <button class="add_field_button btn btn-xs  btn-primary" type="button">
                        <i class="fa fa-plus"></i>Добавить
                    </button>
                </div>
            </div>
            <hr style="border-top: 1px solid gray;">
            <!-- variant otveta -->
            <div class="row">
                <div class="col-md-2">
                    <b><?=$model->attributeLabels()['ownoption'];?></b>
                </div>
                <div class="col-md-9">
                    <?= $form->field($model, 'ownoption')->checkbox(['id'=>'own','label'=>'Прелагадь для последнего варианта ответа область с восможностью ввода текста']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2" id="ownoptionLabel" <?=$model->ownoption != 1 ? 'style="display:none"' : ''?>>
                    <b><?=$model->attributeLabels()['ownoption_text'];?></b>
                </div>
                <div class="col-md-9" id="ownoptionType" <?=$model->ownoption != 1 ? 'style="display:none"' : ''?>>
                    <?= $form->field($model, 'ownoption_text')->textarea(['rows' => 2])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <b><?=$model->attributeLabels()['choice'];?></b>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'choice')->dropDownList($model->getChoice(), ['prompt' => 'Выберите'])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <b><?=$model->attributeLabels()['view_result'];?></b>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'view_result')->dropDownList($model->getViewResult(), ['prompt' => 'Выберите'])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'resultvotes')->checkbox([]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                   
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'showfinishing')->checkbox([]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <b><?=$model->attributeLabels()['audience'];?></b>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'audience')->dropDownList($model->getAudience(), [])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <b><?=$model->attributeLabels()['status'];?></b>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'status')->dropDownList($model->getStaus(), ['value'=>2])->label(false) ?>
                </div>
            </div>
    	<?php if (!Yii::$app->request->isAjax){ ?>
    	  	<div class="form-group">
    	        <?= Html::submitButton( 'Сохранить', ['class' => 'btn btn-primary']) ?>
                <?= Html::a( 'Отмена', ['index'],['class' => 'btn btn-inverse']) ?>
    	    </div>
    	<?php } ?>
        <?php ActiveForm::end(); ?>
    
    </div>
</div>

<?php 
$this->registerJs(<<<JS

    $('select#polls-finish_type').on('change', function(){  
        var value = this.value;
        $('#finishType').hide();
        if(value == 2) $('#finishType').show(200);
    });

    $("#own").on('click', function(e){ 
        if(e.target.checked) $('#ownoptionType').show(200);
        else $('#ownoptionType').hide();
    });

    $("#own").on('click', function(e){ 
        if(e.target.checked) $('#ownoptionLabel').show(200);
        else $('#ownoptionLabel').hide();
    });

JS
);
?>

<?php 
$this->registerJs(<<<JS

$("#create-test-form").on('submit',function(){
    mouseDown();
});

$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".ui-sortable"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = parseInt('$x'); //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            var template = '<div class="panel" data-id="'+ x +'" data-sortable-id="ui-general-1">' +
                '<div class="panel-heading row">' +
                    '<div class="col-md-10">' +
                        '<input style="margin-left: -15px;" type="text" name="names[]" class="form-control col-md-8">' +
                    '</div>' +
                    '<div class="col-md-2">' +
                    '<p class="btn btn-md btn-icon  btn-inverse "><i class="fa fa-list"></i></p>&nbsp&nbsp&nbsp '+
                        '<button type="button" class="btn btn-md btn-icon  btn-danger remove_field"><i class="fa fa-times"></i></button>' +
                    '</div>' +
                '</div>' +
            '</div>';
            $(wrapper).append(template); //add input box
        }
    });
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('div').parent('div').remove(); x--;
    })

});
JS
)
?>
