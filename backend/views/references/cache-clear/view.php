<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\references\CacheClear */
?>
<div class="cache-clear-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'minutes',
            'key',
        ],
    ]) ?>

</div>
