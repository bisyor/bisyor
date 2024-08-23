<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\blogs\BlogCategories */
?>
<div class="blog-categories-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'key',
            'sorting',
            'date_cr',
            'enabled:boolean',
        ],
    ]) ?>

</div>
