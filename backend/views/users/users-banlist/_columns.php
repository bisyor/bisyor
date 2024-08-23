<?php
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\select2\Select2;
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
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
        'attribute'=>'ip_list',
        'label' => 'Блокировка',
        'content' => function($data){
            return str_replace('*', '<br>', $data->ip_list);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'filter' => ['1' => 'бессрочно',
                            '2' => '30 минут',
                            '3' => '1 час',
                            '4' => '6 часов',
                            '5' => '1 день',
                            '6' => '7 дней',
                            '7' => '2 недели',
                            '8' => '1 месяц',
                            '9' => 'До даты ...',],
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'size' => Select2::SMALL,
            'options' => ['prompt' => 'Выберите'],
            'pluginOptions' => ['allowClear' => true],
        ],
        'content' => function($date){
            return $date->TypeLabel();
        },
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'selected',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',
        'label' => 'Описание'
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'date_cr',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'finished',
        'label' => 'Период',
        'content' => function($data){
            return $data->finished != null ? date("H:i d.m.Y", strtotime($data->finished)) : 'Бесконечный';
        }
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'reason',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'exclude',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'status',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '12%',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Просмотр','data-toggle'=>'tooltip', 'class' => 'btn btn-success btn-xs'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Обновить', 'data-toggle'=>'tooltip', 'class' => 'btn btn-info btn-xs'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить', 'class' => 'btn btn-danger btn-xs',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтвердите действие',
                          'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
                      ],
    ],

];   