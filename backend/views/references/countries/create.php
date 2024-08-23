<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Countries */

?>
<div class="countries-create">
    <?= $this->render('_form', [
        'model' => $model,
        'titles' => $titles,
        'declination' => $declination,
        // 'post' => $post,
        'langs' => $langs,
    ]) ?>
</div>
