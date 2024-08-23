<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\switchery\Switchery;

/**
 * @var $model backend\models\banners\Banners
 */
$this->title = "Баннеры";
$this->params['breadcrumbs'][] = ['label' => "Баннеры", 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->isNewRecord ? 'Создать' : 'Изменить';
?>

<div class="panel panel-inverse user-index">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
            <h4 class="panel-title">Баннеры</h4>
        </div>
        <div class="panel-body" style="margin: 10px 25px;">
            <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?> 
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($model, 'keyword')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'width')->textInput(['type' => 'number']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'height')->textInput(['type' => 'number']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">Скрывать для авторизованных пользователей:</div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'filter_auth_users')->widget(Switchery::className(), [
                                'options' => [
                                'label' => false
                            ],
                                'clientOptions' => [
                                'color' => '#5fbeaa',
                            ]
                        ])->label(false);?>
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
                <?php if (!Yii::$app->request->isAjax){ ?>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fa fa-angle-double-left"></i> Назад', ['/banners/banner/index'], ['data-pjax'=>'0','title'=> 'Назад','class'=>'btn btn-inverse']) ?>
                    </div>
                <?php } ?>

                <?php ActiveForm::end(); ?>
    
        </div>
    </div>


