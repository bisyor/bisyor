<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\items\Categories */

$this->title = 'Изменить';
$this->params['breadcrumbs'][] = ['label' => 'Категория', 'url' => ['/items/categories/index']];
$this->params['breadcrumbs'][] = ['label' => $name, 'url' => ['/items/categories/settings', 'id' => $model->category_id, 'name' => $name]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-create">
    <?= $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
        'variants' => $variants,
        'title' => $this->title
    ]) ?>
</div>
