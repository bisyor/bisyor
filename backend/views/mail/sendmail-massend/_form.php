<?php

use backend\models\mail\SendmailMassend;
use backend\models\mail\SendmailTemplate;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\mail\SendmailMassend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sendmail-massend-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-3">
                <?= $form->field($model, 'to_phone')->radioList([0 => 'На почту', 1 => 'На телефону'], ['id'=>'own'])->label(false) ?>
        </div>
        <div class="col-md-4" id="serviceId" <?=$model->to_phone != 1 ? 'style="display:none"' : ''?>>
            <?= $form->field($model, 'service_id')->dropDownList([1 => 'смс сервис эскиз', 2 => 'наш смс сервис'], [])->label(false) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" id="mail-from" <?=$model->to_phone != 0 ? 'style="display:none"' : ''?>>
            <?= $form->field($model, 'from')->textInput(['maxlength' => true])->label('От') ?>
        </div>
        <div class="col-md-6" id="mail-name" <?=$model->to_phone != 0 ? 'style="display:none"' : ''?>>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('<br>') ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'text')->textarea(['rows' => 4])->label('<a href="#" class="myPopover" 
            data-placement="top" title="Доступние макрос"
            data-html="true" data-popover-content="#popover_item">Сообщение</a><br>') ?>
            <div id="popover_item" style="display: none">
                <a onclick="var text_fio = $('textarea').val(); text_fio += '{fio}'; $('textarea').val(text_fio);">{fio}</a> - ФИО<br>
                <a onclick="var text = $('textarea').val(); text += '{unsubscribe}'; $('textarea').val(text);">{unsubscribe}</a> - Отписаться (URL)
            </div>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'shop_only')->widget(Select2::className(), [
                'data' => SendmailMassend::getUsers(),
                'language' => 'ru',
                'options' => [
                    'placeholder' => '-Выберите-'
                ],
                'pluginOptions' => [
                    'allowClear' => false,
                ],
            ])->label('Для кому')    ?>

        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'template_id')->widget(Select2::className(), [
                'data' => ArrayHelper::map(SendmailTemplate::find()->asArray()->all(), 'id', 'title'),
                'language' => 'ru',
                'options' => [
                    'placeholder' => '-Без шанлона-'
                ],
                'pluginOptions' => [
                    'allowClear' => false,
                ],
            ]) ?>
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
        $('.myPopover').popover({
             html : true,
             content: function() {
              var elementId = $(this).attr("data-popover-content");
              return $(elementId).html();
             }
             });
    });

    $("input[name='SendmailMassend[to_phone]']").on('click', function(e){ 
         var value = $(this).val();
        if(value == 1) $('#serviceId').show(200);
        else $('#serviceId').hide();
    });
    
    $("input[name='SendmailMassend[to_phone]']").on('click', function(e){ 
         var value = $(this).val();
        if(value == 0) $('#mail-from').show(200);
        else $('#mail-from').hide();
    });
    
    $("input[name='SendmailMassend[to_phone]']").on('click', function(e){ 
         var value = $(this).val();
        if(value == 0) $('#mail-name').show(200);
        else $('#mail-name').hide();
    });
    
JS);
?>