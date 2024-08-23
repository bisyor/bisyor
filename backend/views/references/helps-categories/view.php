<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\HelpsCategories */
?>
<div class="helps-categories-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'sorting',
        ],
    ]) ?>

</div>
