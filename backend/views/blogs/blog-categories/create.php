<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\blogs\BlogCategories */

?>
<div class="blog-categories-create">
    <?= $this->render('_form', [
        'model' => $model,
        'titles' => $titles,
        'langs' => $langs,
    ]) ?>
</div>
