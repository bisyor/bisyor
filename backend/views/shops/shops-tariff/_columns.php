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
        'attribute'=>'abonement_id',
        'value' => 'abonement.title'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_cr',
        'value' => function($data){
            return $data->getDate($data->date_cr);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'format' => 'raw',
        'value' => function($data){
            return $data->getStatusName();
        },
        'filter' => \backend\models\shops\ShopsTariff::getStatusType(),

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'data_access',
        'value' => function($data){
            return $data->getDate($data->data_access);
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '120px',
        'dropdown' => false,
        'vAlign'=>'middle',
        'headerOptions'=>['class'=>'text-center'],
        'template' => '{leadView}',
        'buttons'  => [
            'leadView' => function ($url, $model) {
                $url = Url::to(['/shops/shops-tariff/view', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'role'=>'modal-remote','title'=> 'Просмотр', 
                    'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-success'
                ]);
            },
            'leadUpdate' => function ($url, $model) {
                $url = Url::to(['/shops/shops-tariff/update', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'role'=>'modal-remote','title'=>'Изменить', 'class'=>'btn btn-xs btn-primary'
                ]);
            },
            'leadDelete' => function ($url, $model) {
                $url = Url::to(['/shops/shops-tariff/delete', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, 
                    [
                        'role'=>'modal-remote','title'=>'Удалить', 
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?','class'=>'btn btn-xs btn-danger'
                    ]);
            },
        ]
    ],
];   