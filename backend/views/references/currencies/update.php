<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Currencies */
?>
<div class="currencies-update">

    <?= $this->render('_form', [
        'model' => $model,
        'titles' => $titles,
        'post' => $post,
        'names' => $names,
        'langs' => $langs,
    ]) ?>

</div>
