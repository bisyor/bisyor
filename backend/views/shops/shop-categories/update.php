<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopCategories */
?>
<div class="shop-categories-update">

    <?= $this->render('_form', [
        'langs' => $langs,
        'model' => $model,
    ]) ?>

</div>
