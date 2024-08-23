<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Regions */
?>
<div class="regions-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
