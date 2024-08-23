<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\items\Items */
$this->params['breadcrumbs'][] = ['label' => 'Объявления', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Объявления № '.$model->id, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="items-update">

    <?= $this->render('_form', [
        'model' => $model,
        'post' => $post,
        'upload_images' => $upload_images,
        'fields' => $fields,
        'category' => $category,
        'itemLink' => $itemLink,
        'searchModelAll' => $searchModelAll,
        'dataProviderAll' => $dataProviderAll,
        'searchModelActive' => $searchModelActive,
        'dataProviderActive' => $dataProviderActive,
        'chats_count' => $chats_count,
    ]) ?>

</div>
