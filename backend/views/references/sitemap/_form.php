<?php

use backend\models\references\Pages;
use backend\models\references\Sitemap;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Sitemap */
/* @var $form yii\widgets\ActiveForm */
$i = 0;
?>

<div class="sitemap-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills" style="margin-top:2px;">
                <?php foreach($langs as $lang):?>
                    <li class="<?= $i == 0 ? 'active' : '' ?>">
                        <a data-toggle="tab" href="#<?=$lang->url?>"><?=$lang->local?></a>
                    </li>
                 <?php $i++; endforeach;?>
            </ul>
            <div class="tab-content">
                            <div class="row">
                                <div class="col-md-2">
                                    Создат в:
                                </div>
                                <div class="col-md-6">
                                    <b><?=$menu_name['name']?></b>
                                </div>
                                <?php if(!$model->isNewRecord):?>
                                <div class="col-md-4">
                                    <p class="pull-right"><?=$model->getType()[$model->type];?></p>
                                </div>
                                <?php endif;?>
                            </div>
                            <br>
                            <?php if($model->isNewRecord):?>
                            <div class="row">
                                <div class="col-md-2">
                                    <?=$model->attributeLabels()['type']?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'type')->radioList([Sitemap::TYPE_THIRD => Sitemap::getType()[Sitemap::TYPE_THIRD],
                                        Sitemap::TYPE_TWO => Sitemap::getType()[Sitemap::TYPE_TWO]])->label(false) ?>
                                </div>
                            </div>
                            <?php endif;?>
                            <?php $i = 0; foreach($langs as $lang): ?>
                                <div id="<?=$lang->url?>" class="tab-pane fade <?=($i == 0) ? 'in active' : '' ?>">
                            <?php if($lang->url == 'ru'): ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <?=$model->attributeLabels()['name']?>
                                </div>
                                <div class="col-md-10">
                                    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <?php else: ?>
                                <div class="row">
                                    <div class="col-md-2">
                                        <?=  Yii::t('app','Nomi', null, $lang->url);?>
                                    </div>
                                    <div class="col-md-10">
                                        <?= $form->field($model, 'translation_name['.$lang->url.']')->textInput(['value' => $translation_name[$lang->url]])
                                            ->label(false) ?>
                                    </div>
                                </div>
                            <?php endif;?>
                                </div>
                                <?php $i++; endforeach;?>
                            <?php if($model->isNewRecord || $model->type == 4):?>
                            <div id="link" class="row <?=($model->type == null || $model->type == 3) ? 'show' : 'hide'?>">
                                <div class="col-md-2">
                                    <?=$model->attributeLabels()['link']?>
                                </div>
                                <div class="col-md-10">
                                    <?= $form->field($model, 'link')->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <div id="pages" class="row <?=($model->type == 2) ? 'show' : 'hide'?>">
                                <div class="col-md-2">
                                    Страница:
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'pages')->widget(Select2::className(), [
                                            'data' => ArrayHelper::map(Pages::find()->asArray()->all(), 'id', 'title'),
                                            'language' => 'ru',
                                            'options' => [
                                                'placeholder' => 'Выберите...'
                                            ],
                                            'pluginOptions' => [
                                                'allowClear' => false,
                                            ],
                                        ]

                                    )->label(false) ?>
                                </div>
                            </div>
                            <?php endif;
                            if($model->isNewRecord || $model->type != 1):?>
                            <div class="row">
                                <div class="col-md-2">
                                    <?=$model->attributeLabels()['target']?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'target')->dropDownList(Sitemap::getTarget())->label(false) ?>
                                </div>
                            </div>
                            <?php endif;
                            if($model->isNewRecord):?>
                            <div class="row">
                                <div class="col-md-2">
                                    <?=$model->attributeLabels()['keyword']?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'keyword')->textInput(['maxlength' => true])->label(false) ?>
                                </div>
                            </div>
                            <?php endif;?>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <?=$form->field($model, 'allow_submenu')->checkbox()?>
                                </div>
                            </div>
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
<?php $this->registerJs(<<<JS
    $(document).ready(function() {
       $('input[type="radio"]').change(function(e) {
           var value = $(this).val();
           if(value == 2){
               $("#pages").removeClass('hide').addClass('show');
               $("#link").removeClass('show').addClass('hide');
           }else{
               $("#link").removeClass('hide').addClass('show');
               $("#pages").removeClass('show').addClass('hide');
           }
       });
    });
JS
);
?>