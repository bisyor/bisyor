<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use dosamigos\switchery\Switchery;
// use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model backend\models\users\UsersBanlist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-banlist-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row m-10">
        <div class="col-md-8 pull-right">
            Вводите каждый IP-адрес или имя узла на новой строке. Для указания диапазон IP-адресов отделите его начало и конец дефисом (-), или используйте звёздочку (*) ва качестве подстановочного знака. 
            <br>
            Проверка IP-адреса производится:
            <br>
            - при регистрации пользвотателей <br>
            - при авторизации администраторов в админ панель <br>
            - при авторизации пользователей <br>

        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            IP-адреса или хосты:
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'ip_list')->textarea(['rows' => 4])->label(false) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            Продолжителность блокировки:
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'type')->widget(Select2::classname(), [
                'data' => $model->getType(),
                'language' => 'ru',
                'hideSearch' => false,
                'options' => ['placeholder' => 'Выберите тип ...'],
                'pluginOptions' => [
                    'allowClear' => false,
                ],
            ])->label(false) ?>
        </div>
    </div>
    <div id="finished" <?= $model->type != 9 ? 'class="row hide"' : 'class="row show"'?>>
        <div class="col-md-4">Дата окончание</div>
        <dic class="col-md-8">
            <?= $form->field($model, 'finished')->widget(
                DatePicker::className(), [
                    'language' => 'ru',
                    'clientOptions' => [
                        'format' => 'dd.mm.yyyy',
                        'autoclose' => true,
                    ]
            ])->label(false)
         ?>
        </dic>
    </div>
    <div class="row">
        <div class="col-md-4">Добавить в белый список:</div>
        <div class="col-md-8">
            <?= $form->field($model, 'exclude')->widget(Switchery::className(), [
              'options' => [
                  'label' => false
              ],
              'clientOptions' => [
                  'color' => '#5fbeaa',
              ]
         ])->label(false);?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            Причина блокировки дост:
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'description')->textarea(['rows' => 4])->label(false) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            Причина, показываемая пользователю:
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'reason')->textarea(['rows' => 4])->label(false) ?>
        </div>
    </div>

          
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php 
$this->registerJs(<<<JS
    
$(document).ready(function(){

    $(document).on('change', 'select', function(e){
        
        var type = $('select').val();
        if(type == 9){
            $('#finished').removeClass("hide").addClass("show");
        }else{
            $('#finished').removeClass("show").addClass("hide");
        }
    });
});
JS
);
?>