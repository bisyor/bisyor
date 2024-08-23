<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Helps */
?>
<div class="helps-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'helps_categories_id',
            'sorting',
            'text:ntext',
            'usefull_count',
            'nousefull_count',
        ],
    ]) ?>

</div>
