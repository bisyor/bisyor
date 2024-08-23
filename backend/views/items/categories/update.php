<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\items\Categories */

$this->params['breadcrumbs'][] = ['label' => 'Категория', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="categories-update">
    <?= $this->render('form', [
        'model' => $model,
        'langs' => $langs,
        'title' => 'Изменить'
    ]) ?>
</div>
