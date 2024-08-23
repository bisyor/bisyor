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
        'value' => 'user.fio'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'reason',
        'value' => function($data){
            return $data->getReasonDescription();
        },
        'filter' => \backend\models\shops\ShopsClaims::getReason(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'viewed',
        'format' => 'raw',
        'value' => function($data){
            return $data->getYesNo();
        },
        'filter' => \backend\models\shops\ShopsClaims::getAnswerType(),
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '120px',
        'dropdown' => false,
        'vAlign'=>'middle',
        'headerOptions'=>['class'=>'text-center'],
        'template' => '{leadView} {leadCheck}',
        'buttons'  => [
            'leadView' => function ($url, $model) {
                $url = Url::to(['/shops/shops-claims/view', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'role'=>'modal-remote','title'=> 'Просмотр', 
                    'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-success'
                ]);
            },
            'leadCheck' => function ($url, $model) {
                $url = Url::to(['/shops/shops-claims/check', 'id' => $model->id]);
                if($model->viewed === false)
                    return Html::a('<span class="fa fa-check"></span>', $url, 
                        [
                            'role'=>'modal-remote','title'=>'Посмотрено', 
                            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                            'data-request-method'=>'post',
                            'data-toggle'=>'tooltip',
                            'data-confirm-title'=>'Подтвердите действие',
                            'data-confirm-message'=>'Изменить как просмотрено?',
                            'class'=>'btn btn-xs btn-info'
                        ]);
            },
        ]
    ],

];   