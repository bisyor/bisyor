<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\references\Redirects;
use dosamigos\switchery\Switchery;


$this->params['breadcrumbs'][] = ['label' => "Настройки сайта"];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Создать' : 'Изменить';
?>

    

<div class="panel panel-inverse" data-sortable-id="ui-typography-9">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Настройки сайта</h4>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin([ 'options' => ['method' => 'post']]); ?>
            <div class="row">
                <div class="col-md-2">
                    <b><?=$model->attributeLabels()['title'];?></b>
                </div> 
                <div class="col-md-9">
                    <?= $form->field($model, 'title')->textInput()->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <b><?=$model->attributeLabels()['code'];?></b>
                </div> 
                <div class="col-md-9">
                    <?= $form->field($model, 'code')->textarea(['rows'=>6])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <b><?=$model->attributeLabels()['code_position'];?></b>
                </div> 
                <div class="col-md-9">
                    <?= $form->field($model, 'code_position')->dropDownList($model->getStaus(), ['value'=>0])->label(false) ?>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-2">
                    <b><?=$model->attributeLabels()['enabled'];?></b>
                </div>
                <div class="col-md-9">
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
            <br>
            <div class="form-group">
                <?= Html::submitButton( 'Сохранить', ['class' => 'btn btn-success']) ?>
                <?= Html::a( 'Назад', ['index'],['class' => 'btn btn-inverse']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>