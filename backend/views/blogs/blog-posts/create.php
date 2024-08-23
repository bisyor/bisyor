<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BlogPosts */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => "Посты", 'url' => ['/blogs/blog-posts']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-posts-create">
    <?= $this->render('_form', [
        'model' => $model,
        'translation_name' => $translation_name,
        'translation_short_text' => $translation_short_text,
        'translation_text' => $translation_text,
        'langs' => $langs,
    ]) ?>
</div>
