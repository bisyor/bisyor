<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\references\BlackList */
?>
<div class="black-list-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'enabled:boolean',
        ],
    ]) ?>

</div>
