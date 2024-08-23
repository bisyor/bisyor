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
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'from',
        'label' => 'От',
        'content' => function($data){
            return $data->from."-".$data->name;
        }
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'name',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'status',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'text',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'to_phone',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shop_only',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'template_id',
    // ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'date_cr',
         'content' => function($data){
             if ($data->date_cr) return date("d.m.Y H:i:s" , strtotime($data->date_cr));
         }
     ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'shop_only',
        'label' =>'Для кому',
        'content' => function($data){
             return $data->getUsersDescription();
        }
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'date_up',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'width' => '12%',
        'vAlign'=>'middle',
        'template' => '{view}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['data-pjax' => 0,'title'=>'Просмотр','data-toggle'=>'tooltip', 'class' => 'btn btn-success btn-xs']
    ],

];   