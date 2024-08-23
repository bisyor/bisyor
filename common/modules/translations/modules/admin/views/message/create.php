<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use jakharbek\categories\models\Categories;

use common\modules\langs\widgets\LangsWidgets;
use dosamigos\ckeditor\CKEditor;

use kartik\editable\Editable;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model common\modules\translations\models\Message */

$this->title = Yii::t('app','Create Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
