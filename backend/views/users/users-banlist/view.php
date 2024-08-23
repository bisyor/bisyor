<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\users\UsersBanlist */
?>
<div class="users-banlist-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'ip_list',
                'format' => 'raw',
                'value' => function($data){
                    return str_replace('*', '<br>', $data->ip_list);
                },
            ],
            [
                'attribute' => 'date_cr',
                'format' => 'raw',
                'value' => function($data){
                    return date("H:i d.m.Y", strtotime($data->date_cr));
                },
            ],
            [
                'attribute' => 'finished',
                'format' => 'raw',
                'value' => function($data){
                    return $data->finished != null ? date("H:i d.m.Y", strtotime($data->finished)) : 'Бесконечный';
                },
            ],
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => $model->TypeLabel(),
            ],
            // 'selected',
            'description:ntext',
            'reason:ntext',
            'exclude:boolean',
            // 'status:boolean',
        ],
    ]) ?>

</div>
