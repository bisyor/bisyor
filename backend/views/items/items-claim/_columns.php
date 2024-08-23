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
        'attribute'=>'item_id',
        'width' => '60px',
        'contentOptions' => ['class' => 'text-center'],
        'format' => 'raw',
        'value' => function($data){
            $url = Url::to(['/items/items/view', 'id' => $data->item_id]);
            return Html::a('#' . $data->item_id , $url, [
                    'role'=>'modal-remote','title'=> 'Просмотр', 
                    'data-toggle'=>'tooltip','class'=>'btn btn-link'
                ]);
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'reason',
        'value' => function($data){
            return $data->getReasonDescription();
        },
        'filter' => \backend\models\items\ItemsClaim::getReason(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'viewed',
        'width' => '60px',
        'contentOptions' => ['class' => 'text-center'],
        'format' => 'raw',
        'value' => function($data){
            return $data->getYesNo();
        },
        'filter' => \backend\models\items\ItemsClaim::getAnswerType(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_cr',
        'width' => '60px',
        'contentOptions' => ['class' => 'text-center'],
        'format' => 'raw',
        'value' => function($data){
            return $data->getDate();
        },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '120px',
        'dropdown' => false,
        'vAlign'=>'middle',
        'headerOptions'=>['class'=>'text-center'],
        'template' => '{leadView} {leadCheck} {leadDelete}',
        'buttons'  => [
            'leadView' => function ($url, $model) {
                $url = Url::to(['/items/items-claim/view', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'role'=>'modal-remote','title'=> 'Просмотр', 
                    'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-success'
                ]);
            },
            'leadCheck' => function ($url, $model) {
                $url = Url::to(['/items/items-claim/check',
                    'id' => $model->id]);
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

            'leadDelete' => function ($url, $model) {
                $url = Url::to(['/items/items-claim/delete',
                    'id' => $model->id]);
                    return Html::a('<span class="fa fa-trash"></span>', $url, 
                        ['role'=>'modal-remote','title'=>'Удалить', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?','class'=>'btn btn-xs btn-danger']
                    );
            },
        ]
    ],

];   