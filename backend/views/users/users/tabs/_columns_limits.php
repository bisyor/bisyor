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
        'attribute'=>'category_id',
        'content' => function($data){
            return $data->category->title;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'active',
        'content' => function($data){
            return $data->active == true ? 'Активе':'Не активе';
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'shop',
        'content' => function($data){
            return $data->shop ? ' Магазины': 'Объявления';
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'summa'
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'item_count'
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'used_count'
    ],

];   