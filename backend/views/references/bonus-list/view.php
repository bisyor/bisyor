<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\references\BonusList */
?>
<div class="bonus-list-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'status',
            'image',
            'bonus',
            'keyword',
        ],
    ]) ?>

</div>
