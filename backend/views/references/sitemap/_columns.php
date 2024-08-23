<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

return [
//    [
//        'class' => 'kartik\grid\CheckboxColumn',
//        'width' => '20px',
//    ],
//    [
//        'class' => 'kartik\grid\SerialColumn',
//        'width' => '30px',
//    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'kartik\grid\ExpandRowColumn',
        'width'=>'50px',
        'value'=>function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
        },
        'detail'=>function ($model, $key, $index, $column) {
            return Yii::$app->controller->renderPartial('_sub_menu', ['model'=>$model]);
        },
        'headerOptions'=>['class'=>'kartik-sheet-style'],
        'expandOneOnly'=>true
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'sitemap_id',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'type',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'keyword',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'link',
//    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'target',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'is_system',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'allow_submenu',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'numlevel',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'enabled',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'date_cr',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{update} {delete} {leadCreate}',
        'width' => '150px',
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons' => [
            'leadCreate' => function ($url, $model) {
                $url = Url::to(['create', 'id' => $model->id]);
                $link = Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, ['class' => 'btn btn-warning btn-xs', 'role' => 'modal-remote', 'data-toggle' => 'tooltip', 'title' => 'Добавить',]);
                if($model->allow_submenu) return $link;
                else return false;
            },
        ],
        'viewOptions'=>['role'=>'modal-remote','title'=>'Просмотр','data-toggle'=>'tooltip', 'class' => 'btn btn-success btn-xs'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Изменить', 'data-toggle'=>'tooltip', 'class' => 'btn btn-info btn-xs'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить', 'class' => 'btn btn-danger btn-xs',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтвердите действие',
                          'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
                    ]
    ],

];   