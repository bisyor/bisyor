<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\items\Items */
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->title = 'Добавить объявления';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-create">
    <?= $this->render('_form', [
        'model' => $model,
        'upload_images' => $upload_images,
        'category' => $category,
        'fields' => $fields,
        'post' => $post
    ]) ?>
</div>
