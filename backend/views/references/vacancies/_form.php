<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model */
$i = 0;
?>

<div class="categories-form">
    <?php $form = ActiveForm::begin([ 'options' => ['method' => 'post', 'enctype' => 'multipart/form-data']]); ?>
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
                                        <?= $form->field($model, 'title')->textInput() ?>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                                            'data' => $model->getCategoriesList(),
                                            'options' => ['placeholder' => 'Выберите'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]);?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'vacancy_count')->textInput() ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'price')->textInput(['type'=>'number']) ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'currency_id')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\references\Currencies::find()->where(['enabled' => 1])->all(), 'id', 'short_name')) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
                                    </div>
                                </div>
                                <?php else: ?>
                                    <div class="row">
                                        <?= $form->field($model, 'translation_title['.$lang->url.']')->textInput(['value' => isset($titles[$lang->url]) ? $titles[$lang->url] : '' ])->label(Yii::t('app','Nomi', null, $lang->url)) ?>
                                    </div>
                                    <div class="row">
                                        <?= $form->field($model, 'translation_description['.$lang->url.']')->textarea(['rows'=>4,'value' => isset($description[$lang->url]) ? $description[$lang->url] : '' ])->label(Yii::t('app','Matni', null, $lang->url)) ?>
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
