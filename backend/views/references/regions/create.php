<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Regions */

?>
<div class="regions-create">
    <?= $this->render('_form', [
        'model' => $model,
        'titles' => $titles,
        'declination' => $declination,
        // 'post' => $post,
        'langs' => $langs,
    ]) ?>
</div>
