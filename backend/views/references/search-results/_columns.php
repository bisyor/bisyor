<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    /*[
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ], */
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'pid',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'region_id',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'query',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'counter',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'diff',
        'label' => 'Неуспешных',
        'value' => function($data){
            return $data->counter-$data->hits;
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'last_time',
        'content' => function($data){
            if($data->last_time != null) return date('H:i d.m.Y', strtotime($data->last_time));
        }
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Сайт | Телеграмм Бот | Андроид | IOS',
        'content' => function($data){
        return '<p>
                                <a class="btn btn-primary btn-xs ">'.$data['site'].'</a>
                                <a class="btn btn-warning btn-xs ">'.$data['telegram_bot'].'</a>
                                <a class="btn btn-info btn-xs ">'.$data['android'].'</a>
                                <a class="btn btn-inverse btn-xs ">'.$data['ios'].'</a>
                            </p>';
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width'=>'120px',
        'template' => '{leadView} {leadDelete}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons'=>[
            'leadView' => function ($url, $model) {
                    $url = Url::to(['/references/search-results/view', 'id' => $model->id]);
                    return Html::a('<span style="font-size: 12px;" class="glyphicon glyphicon-eye-open"></span>', $url, [
                        'data-pjax'=>'0','title'=>'Просмотр','class'=>'btn btn-info btn-xs' ,
                    ]);
            },
            'leadDelete' => function ($url, $model) {
                    $url = Url::to(['/references/search-results/delete', 'id' => $model->id]);
                    return Html::a('<span style="font-size: 12px;" class="glyphicon glyphicon-trash"></span>', $url, [
                        'role'=>'modal-remote','title'=>'Удалить','class'=>'btn btn-danger btn-xs' ,
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемент?',
                    ]);
            },
        ],
    ],
];
     