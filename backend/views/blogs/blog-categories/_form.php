<?php
use yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
use dosamigos\switchery\Switchery;

/* @var $this yii\web\View */
/* @var $model backend\models\blogs\BlogCategories */
/* @var $form yii\widgets\ActiveForm */
$i = 0;
?>

<div class="blog-categories-form">
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
                                    <?= $form->field($model, 'name')->textInput() ?>
                                </div>
                            </div>
                            
                            <?php if($model->isNewRecord) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div>
                            <?php } ?>
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
                        <div class="row">
                                <div class="col-md-6">
                                    <?= $form->field($model, 'sorting')->textInput(['type' => 'number']) ?>
                                </div>  
                                <div class="col-md-6">Статус:</div>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'enabled')->widget(Switchery::className(), [
                                            'options' => [
                                            'label' => false
                                        ],
                                            'clientOptions' => [
                                            'color' => '#5fbeaa',
                                        ]
                                    ])->label(false);?>
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