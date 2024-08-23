<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Currencies */
?>
<div class="currencies-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'short_name',
            'name',
            'rate',
            'sorting',
            'enabled:boolean',
            'default:boolean',
        ],
    ]) ?>

</div>
