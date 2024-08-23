<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\references\Redirects;
use dosamigos\switchery\Switchery;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Currencies */
/* @var $form yii\widgets\ActiveForm */
$i = 0;
?>

<div class="redirect-form">
    <?php $form = ActiveForm::begin([ 'options' => ['method' => 'post']]); ?>
        <div class="tab-content">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'from_uri')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'to_uri')->textInput() ?>
                </div>  
            </div>
            <div class="row">
                <div class="col-md-6">
                <?= $form->field($model, 'status')->dropDownList(['301' => '301', '302' => '302'])?>
                </div>
                <div class="col-md-6">
                    <p style="margin-top:-5px" >
                        <b>Включен:
                    </p>
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
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'add_extra')->widget(Switchery::className(), [
                        'options' => [
                            'label' => false
                        ],
                        'clientOptions' => [
                            'color' => '#5fbeaa',
                        ]
                    ])->label();?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'add_query')->widget(Switchery::className(), [
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