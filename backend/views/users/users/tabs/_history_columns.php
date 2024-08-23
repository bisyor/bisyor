<?php
use yii\helpers\Url;
use backend\components\StaticFunction;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_cr',
        'content' => function($data){
            return date("H:i d.m.Y", strtotime($data->date_cr));
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'content' => function($data){
            return StaticFunction::getHistoryType($data->type);
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'from_device',
        'content' => function($data){
            return $data->getFromDevice();
        },
    ],
];   