<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Brands */
?>
<div class="brands-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'sorting',
            'image',
            'enabled:boolean',
        ],
    ]) ?>

</div>
