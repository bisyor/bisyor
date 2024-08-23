<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Regions */
?>
<div class="regions-update">

    <?= $this->render('_form', [
        'model' => $model,
        'titles' => $titles,
        'post' => $post,
        'langs' => $langs,
    ]) ?>

</div>
