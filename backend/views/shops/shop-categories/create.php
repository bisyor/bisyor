<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopCategories */

?>
<div class="shop-categories-create">
    <?= $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>
</div>
