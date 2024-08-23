<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HelpsCategories */
?>
<div class="helps-categories-update">

    <?= $this->render('_form', [
        'model' => $model,
        'titles' => $titles,
        'post' => $post,
        'langs' => $langs,
    ]) ?>

</div>
