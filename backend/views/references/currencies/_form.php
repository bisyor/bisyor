<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\switchery\Switchery;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Currencies */
/* @var $form yii\widgets\ActiveForm */
$i = 0;
?>

<div class="currencies-form">
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
                                <div class="col-md-6">
                                    <?= $form->field($model, 'name')->textInput() ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <?php else: ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'translation_name['.$lang->url.']')->textInput(['value' => isset($titles[$lang->url]) ? $titles[$lang->url] : null])->label(Yii::t('app','Nomi', null, $lang->url)) ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'translation_short_name['.$lang->url.']')->textInput(['value' => isset($names[$lang->url]) ? $names[$lang->url] : null])->label(Yii::t('app','Qisqacha nomi', null, $lang->url)) ?>
                                    </div>
                                </div>
                        <?php endif;?>
                        </p>
                    </div>
                <?php $i++; endforeach;?>
                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>    
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'rate')->textInput(['type' => 'number']) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'sorting')->textInput(['type' => 'number']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'enabled')->widget(Switchery::className(), [
                            'options' => [
                                'label' => false
                            ],
                            'clientOptions' => [
                                'color' => '#5fbeaa',
                            ]
                        ])->label();?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'default')->widget(Switchery::className(), [
                            'options' => [
                                'label' => false
                            ],
                            'clientOptions' => [
                                'color' => '#5fbeaa',
                            ]
                        ])->label();?>
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