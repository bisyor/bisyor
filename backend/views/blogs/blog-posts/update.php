<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\blogs\BlogPosts */

$this->title = 'Изменить';
$this->params['breadcrumbs'][] = ['label' => "Посты", 'url' => ['/blogs/blog-posts']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="blog-posts-update">

    <?= $this->render('_form', [
        'model' => $model,
        'translation_name' => $translation_name,
        'translation_short_text' => $translation_short_text,
        'translation_text' => $translation_text,
        'post' => $post,
        'langs' => $langs,
    ]) ?>

</div>
