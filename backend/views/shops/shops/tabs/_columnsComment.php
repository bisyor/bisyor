<?php

use backend\models\shops\ShopsComment;
use yii\helpers\Html;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'enabled',
        'format' => 'raw',
        'value' => function($data){
            return ShopsComment::getStatusName($data->enabled);
        },
        'filter' => ShopsComment::getStatus()
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'text',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fio',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_ip',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'width' => '12%',
        'vAlign'=>'middle',
        'template' => '{leadView} {leadEdit} {leadDelete}',
        'buttons'  => [
            'leadView' => function ($url, $model) {
                $url = Url::to(['/shops/shops-comment/view', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'role'=>'modal-remote','title'=> 'Просмотр',
                    'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-success'
                ]);
            },
            'leadEdit' => function ($url, $model) {
                $url = Url::to(['/shops/shops-comment/update', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                    'role'=>'modal-remote','title'=> 'Изменить',
                    'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-warning'
                ]);
            },
            'leadDelete' => function ($url, $model) {
                $url = Url::to(['/shops/shops-comment/delete', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'role'=>'modal-remote','title'=>'Удалить',
                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                    'data-request-method'=>'post',
                    'data-toggle'=>'tooltip',
                    'data-confirm-title'=>'Подтвердите действие',
                    'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?','class'=>'btn btn-xs btn-danger'
                ]);
            },
        ]
    ],

];   