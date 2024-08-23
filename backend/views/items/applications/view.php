<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\items\Applications */
?>
<div class="applications-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'item_id',
                'format' => 'html',
                'value' => function($data){
                    return "<a data-pjax='0' href='/items/items/view?id={$data->item_id}'>{$data->item->title}</a>";
                }
            ],
            'phone',
            [
                'attribute' => 'status',
                'value' => function($data){
                    return $data->status();
                }
            ],
            'fullname',
            'address',
            'comment:ntext',
            'created_at',
        ],
    ]) ?>

</div>
