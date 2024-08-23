<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BlogTags */
?>
<div class="blog-tags-update">

    <?= $this->render('_form', [
        'model' => $model,
        'titles' => $titles,
        'post' => $post,
        'langs' => $langs,
    ]) ?>

</div>
