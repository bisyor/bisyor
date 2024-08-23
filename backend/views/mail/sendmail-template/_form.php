<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\mail\SendmailTemplate */
/* @var $translation_title backend\models\mail\SendmailTemplate */
/* @var $translation_content backend\models\mail\SendmailTemplate */
/* @var $form yii\widgets\ActiveForm */
$i = 0;
?>

<div class="sendmail-template-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills" style="margin-top:2px;">
                <?php foreach($langs as $lang):?>
                    <li class="<?= $i == 0 ? 'active' : '' ?>">
                        <a data-toggle="tab" href="#<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
                    </li>
                    <?php $i++; endforeach;?>
            </ul>
        </div>
        <div class="tab-content">
            <?php $i = 0; foreach($langs as $lang): ?>
            <div id="<?=$lang->url?>" class="tab-pane fade <?=($i == 0) ? 'in active' : '' ?>">
                <?php if($lang->url == 'ru'): ?>
                    <div class="col-md-12">
                        <?= $form->field($model, 'title')->textInput()?>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($model, 'content')->textarea(['rows' => 6])->label('Текст шаблона <a class="subject" href="javascript:;">{subject}</a>
                        <a class="message" href="javascript:;">{message}</a>')?>
                    </div>
                <?php else: ?>
                    <div class="col-md-12">
                        <?= $form->field($model, 'translation_title['.$lang->url.']')->textInput(['value' => isset($translation_title[$lang->url]) ? $translation_title[$lang->url] : ''])->label(Yii::t('app','Sarlavha', null, $lang->url)) ?>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($model, 'translation_content['.$lang->url.']')->textarea(['value' => isset($translation_content[$lang->url]) ? $translation_content[$lang->url] : '', 'rows' => 6])->label(Yii::t('app','Qolip matni', null, $lang->url).' <a class="subject" href="javascript:;">{subject}</a>
                        <a class="message" href="javascript:;">{message}</a>') ?>
                    </div>
                <?php endif;?>
            </div>
             <?php $i++; endforeach;?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'is_html')->checkbox(['label' => Html::encode('Текст содержит HTML теги <div>, <br>, <table>, <body>, <html>')]) ?>
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
$(document).ready(function() {
  $('.subject').click(function(e) {
      var text = $(this).closest('label').next().val();
      text += '{subject}';
      $(this).closest('label').next().val(text);
  });
  $('.message').click(function(e) {
      var text = $(this).closest('label').next().val();
      text += '{message}';
      $(this).closest('label').next().val(text);
  });
});
JS);
?>