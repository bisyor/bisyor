<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Sitemap */
?>
<div class="sitemap-update">

    <?= $this->render('_form', [
        'model' => $model,
        'translation_name' => $translation_name,
        'post' => $post,
        'langs' => $langs,
        'menu_name' => $menu_name
    ]) ?>

</div>
