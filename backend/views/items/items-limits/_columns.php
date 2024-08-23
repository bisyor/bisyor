<?php
use yii\helpers\Url;

return [
//    [
//        'class' => 'kartik\grid\CheckboxColumn',
//        'width' => '20px',
//    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cat_id',
        'content' => function($data){
            return $data->category->title;
        }
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'enabled'
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'items',
        'label' => 'Лимит'
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'settings',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'group_id',
    // ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'enabled',
         'content' => function($data){
            return $data->enabled ? '<input type="checkbox" checked onchange="$.post(\'/items/items-limits/set-enabled\', {id:'.$data->id.'}, function(data) {});">' : '<input type="checkbox" onchange="$.post(\'/items/items-limits/set-enabled\', {id:'.$data->id.'}, function(data) {});">';
         }
     ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'width' => '12%',
        'vAlign'=>'middle',
        'template' => '{update} {delete}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
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