<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\blogs\BlogPosts;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        /*'filter' => BlogPosts::getCategoriesList(),*/
        'content' => function($data){
            return $data->getStatusname();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'content' => function($data){
            return $data->user->fio;
        }
    ],
];   