<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\items\Categories */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Категория', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-create">
    <?= $this->render('form', [
        'model' => $model,
        'langs' => $langs,
        'title' => $this->title
    ]) ?>
</div>
