<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\switchery\Switchery;

/* @var $this yii\web\View */
/* @var $model common\models\Regions */
/* @var $form yii\widgets\ActiveForm */
$i = 0;
?>

<div class="regions-form">
    <?php $form = ActiveForm::begin([ 'options' => ['method' => 'post']]); ?>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills" style="margin-top:2px;">
                <?php foreach($langs as $lang):?>
                    <li class="<?= $i == 0 ? 'active' : '' ?>">
                        <a data-toggle="tab" href="#<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
                    </li>
                <?php $i++; endforeach;?>
            </ul>
            <div class="tab-content">
                <?php $i = 0; foreach($langs as $lang): ?>
                 <div id="<?=$lang->url?>" class="tab-pane fade <?=($i == 0) ? 'in active' : '' ?>">
                    <p>
                        <?php if($lang->url == 'ru'): ?>
                            <div class="row">
                                <?= $form->field($model, 'name')->textInput(['type'=>'name']) ?>
                            </div>
                            <div class="row">
                                <?= $form->field($model, 'declination')->textInput() ?>
                            </div>
                            <div class="row">
                                <?= $form->field($model, 'keyword')->textInput() ?>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <?= $form->field($model, 'translation_name['.$lang->url.']')->textInput(['value' => isset($titles[$lang->url]) ? $titles[$lang->url] : ''])->label(Yii::t('app','Nomi', null, $lang->url)) ?>
                            </div>
                            <div class="row">
                                <?= $form->field($model, 'translation_declination['.$lang->url.']')->textInput(['value' => isset($declination[$lang->url]) ? $declination[$lang->url] : ''])->label('Склонение(где)') ?>  
                            </div>
                        <?php endif;?>    
                    </p>
                 </div>
                <?php $i++; endforeach;?>
            </div>
        </div>
    </div>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>