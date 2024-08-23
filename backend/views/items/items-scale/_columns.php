<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'key',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'content' => function($model){
            if($model->status = \backend\models\items\ItemsScale::STATUS_INACTIVE) return '<span class="btn btn-danger btn-xs ">Не активно</span>';
            if($model->status = \backend\models\items\ItemsScale::STATUS_ACTIVE) return '<span class="btn btn-primary  btn-xs">Активно</span>';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ball',
    ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'minimum_value',
     ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{leadUpdate} {leadDelete}',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
        },
        'buttons'=>[
            'leadUpdate' => function ($url, $model) {
                $url = Url::to(['/items/items-scale/update', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'role'=>'modal-remote', 'data-toggle'=>'tooltip', 'title'=>'Редактировать','class'=>'btn btn-success btn-xs']);
            },
        ],
    ],

];   