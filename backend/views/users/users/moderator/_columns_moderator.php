<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'width' => '60px',
        // 'attribute'=>'avatar',
        'label' => 'Аватар',
        'content' => function($data){
            return Html::img($data->getAvatar(), ['style' => 'width:60px; height:60px; border-radius: 25%',]);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fio',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'phone',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
    ],  
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'last_seen',
        'content' => function($data){
            return $data->last_seen ? date("H:i d.m.Y", strtotime($data->last_seen)) : '';
        }
    ],  
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{leadView} {leadUpdate} {delete}',
        'buttons'  => [
            'leadView' => function ($action, $model) {
                    $url = Url::to(['/users/users/moderator-view', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                        'class' => 'btn btn-success btn-xs',
                        'data-pjax'=>'0','title'=>'Просмотр',
                        'data-toggle'=>'tooltip',
                    ]);
            },
            'leadUpdate' => function ($action, $model) {
                $url = Url::to(['/users/users/edit-moderator', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'class' => 'btn btn-info btn-xs',
                    'data-pjax'=>'0','title'=>'Обновить',
                    'data-toggle'=>'tooltip',
                ]);
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['title'=>'Просмотр','data-toggle'=>'tooltip'],
        // 'updateOptions'=>['role'=>'modal-remote','title'=>'Обновить', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить', 'class' => 'btn btn-danger btn-xs',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтвердите действие',
                          'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
                      ],
    ],

];   