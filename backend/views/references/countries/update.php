<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Countries */
?>
<div class="countries-update">

    <?= $this->render('_form', [
        'model' => $model,
        'titles' => $titles,
        'post' => $post,
        'langs' => $langs,
        'declination' => $declination,
    ]) ?>

</div>
