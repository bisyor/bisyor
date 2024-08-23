<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'value' => function($data){
            return $data->user->getUserFio();
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'format' => 'raw',
        'attribute'=>'date_cr',
        'value' => function($data){
            return $data->date_cr;
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'phone',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-center'],
        'format' => 'raw',
        'value' => function($data){
            return $data->getStatusTemplate();
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '120px',
        'dropdown' => false,
        'vAlign'=>'middle',
        'headerOptions'=>['class'=>'text-center'],
        'template' => '{leadView} {leadDelete}',
        'buttons'  => [
            'leadView' => function ($url, $model) {
                $url = Url::to(['/shops/requests/view', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title'=> 'Просмотр','role' => 'modal-remote', 
                    'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-success'
                ]);
            },
            'leadDelete' => function ($url, $model) {
                $url = Url::to(['/shops/requests/delete', 'id' => $model->id, 'tab' => ((isset($_COOKIE["tab-requests"]) && $_COOKIE["tab-requests"] != 'undefined') ? $_COOKIE["tab-requests"] : 'tab-1')]);
                return Html::a('<span class="fa fa-trash"></span>', $url, 
                    [
                        'role'=>'modal-remote','title'=>'Удалить', 
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
                        'class'=>'btn btn-xs btn-danger',
                    ]);
            },
        ]
    ],

];   