<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\alerts\Alerts */

$this->params['breadcrumbs'][] = ['label' => 'Уведомления', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->key_title];
?>
<div class="alerts-update">
    <?= $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
        'title' => 'Редактирование'
    ]) ?>
</div>
