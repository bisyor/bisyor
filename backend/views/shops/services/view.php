<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\Services */
?>
<div class="services-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'changed_id',
            'keyword',
            'module',
            'module_title',
            'title',
            'price',
            'short_description:ntext',
            'description:ntext',
            'day',
            'sorting',
            'icon_b',
            'icon_s',
            'enabled:boolean',
            'color',
            'date_cr',
            'date_up',
        ],
    ]) ?>

</div>
