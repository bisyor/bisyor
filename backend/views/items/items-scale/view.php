<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\items\ItemsScale */
?>
<div class="items-scale-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            'key',
            'status',
            'ball',
            'minimum_value',
        ],
    ]) ?>

</div>
