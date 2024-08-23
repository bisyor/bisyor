<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BlogTags */
/* @var $form yii\widgets\ActiveForm */
$i = 0;
?>

<div class="blog-tags-form">
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

    			<div class="tab-content">
	                <?php $i = 0; foreach($langs as $lang): ?>
	                    <div id="<?=$lang->url?>" class="tab-pane fade <?=($i == 0) ? 'in active' : '' ?>">
	                        <p>
	                        <?php if($lang->url == 'ru'): ?>
	                            <div class="row">
	                                <div class="col-md-12">
	                                    <?= $form->field($model, 'name')->textInput() ?>
	                                </div>
	                            </div>
	                        <?php else: ?>
	                            <div class="row">
	                                <div class="col-md-12">
	                                    <?= $form->field($model, 'translation_name['.$lang->url.']')->textInput(['value' => isset($titles[$lang->url]) ? $titles[$lang->url] : null])->label(Yii::t('app','Nomi', null, $lang->url)) ?>
	                                </div>
	                            </div>
	                        <?php endif;?>
	                        </p>
	                    </div>
	                <?php $i++; endforeach;?>           
	            </div>
	        </div>
		</div>
    <?php ActiveForm::end(); ?>
</div>