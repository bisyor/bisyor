<?php

use backend\models\items\Items;
use backend\models\references\Districts;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/**
 * @var $this yii\web\View
 * @var $file
 * @var $attention
 * @var $title
 */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);
?>
<style>
    .blinking{
        animation:blinkingText 1.2s infinite;
    }
    @keyframes blinkingText{
        0%{     color: #fff;    }
        49%{    color: #fff; }
        60%{    color: transparent; }
        99%{    color:transparent;  }
        100%{   color: #fff;    }
    }
</style>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default"
               data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success"
               data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i
                    class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i
                    class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title blinking"><?= $this->title ?></h4>
    </div>
    <div class="panel-body">
        <?php $form = \yii\widgets\ActiveForm::begin(['options' => ['method' => 'post', 'enctype' => 'multipart/form-data']]); ?>
        <div class="col-md-4">
            <div class="form-group">
                <label>Фио пользователя </label>
                <input type="text" name="fio" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <label> Область *</label>
            <?= Select2::widget([
                'name' => 'district_id',
                'data' => ArrayHelper::map(Districts::find()->asArray()->all(), 'id', 'name'),
                'language' => 'ru',
                'value' => 181,
                'options' => [
                    'placeholder' => 'Выберите область ...',
                ],
                'pluginOptions' => [
                    'initialize' => false,
                    'allowClear' => false,
                ],
            ]) ?>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> Ссылка *
                </label>
                <input type="text" name="link" required class="form-control">
                <strong class="text-danger"><?=$attention?></strong>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> Телефон номер </label>
                <?= MaskedInput::widget([
                    'mask' => '+\9\9899-999-99-99',
                    'name' => 'phone',
                    'options' => [
                        'placeholder' => '+998-99-999-99-99',
                        'class' => 'form-control',
                    ]
                ]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <label for="">Срок публикации</label>
            <?= Select2::widget([
                'name' => 'publicated_period',
                'data' => (new Items)->getPeriodList(),
                'language' => 'ru',
                'pluginOptions' => [
                    'allowClear' => false,
                ],
            ]) ?>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-info m-t-20 submit">Начать разбор</button>
        </div>
        <?php \yii\widgets\ActiveForm::end(); ?>
    </div>
</div>