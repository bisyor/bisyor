<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\items\ItemsLimits */
?>
<div class="items-limits-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cat_id',
            'district_id',
            'shop',
            'free',
            'items',
            'settings:ntext',
            'enabled',
            'group_id',
            'title:ntext',
        ],
    ]) ?>

</div>
