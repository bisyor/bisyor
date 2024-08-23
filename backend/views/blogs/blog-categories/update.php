<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BlogCategories */
?>
<div class="blog-categories-update">

    <?= $this->render('_form', [
        'model' => $model,
        'titles' => $titles,
        'post' => $post,
        'langs' => $langs,
    ]) ?>

</div>
