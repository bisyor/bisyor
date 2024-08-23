<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Countries */
?>
<div class="countries-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
