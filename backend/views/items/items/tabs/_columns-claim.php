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
            return Html::a('#' . $data->item_id , ['#'], [
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
        'template' => '{leadCheck} {leadDelete}',
        'buttons'  => [
            'leadCheck' => function ($url, $model) {
                $url = Url::to(['/items/items/check-claim',
                    'id' => $model->id, 
                    'tab' => ( isset($_COOKIE["tab-items-claims"]) && $_COOKIE["tab-items-claims"] != 'undefined' ) ? $_COOKIE["tab-items-claims"] : null ]);
                if($model->viewed === false)
                    return Html::a('<span class="fa fa-check"></span>', $url, 
                        [
                            'role'=>'modal-remote','title'=>'Посмотрено', 
                            
                            'class'=>'btn btn-xs btn-info'
                        ]);
            },

            'leadDelete' => function ($url, $model) {
                $url = Url::to(['/items/items/delete-claim',
                    'id' => $model->id, 
                    'tab' => ( isset($_COOKIE["tab-items-claims"]) && $_COOKIE["tab-items-claims"] != 'undefined' ) ? $_COOKIE["tab-items-claims"] : null ]);
                    return Html::a('<span class="fa fa-trash"></span>', $url, 
                        [
                            'role'=>'modal-remote',
                            'title'=>'Удалить', 
                            'class'=>'btn btn-xs btn-danger']
                    );
            },
        ]
    ],

];   