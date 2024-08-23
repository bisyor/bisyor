<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\references\Sitemap */

?>
<div class="sitemap-create">
    <?= $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
        'translation_name' => null,
        'menu_name' => $menu_name
    ]) ?>
</div>
