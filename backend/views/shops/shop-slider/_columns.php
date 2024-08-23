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
        'format' => 'raw',
        'width' => '85px',
        'attribute' => 'image',
        'value' => function($data){
            return $data->getImg('75px','75px');
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'text',
        'width'=>'300px',
        'value'=>function($data){
            if(strlen($data->text) > 200){
                return substr($data->text,0,200)."...";
            }
            else
                return $data->text;
        },
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'link',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '120px',
        'dropdown' => false,
        'vAlign'=>'middle',
        'headerOptions'=>['class'=>'text-center'],
        'template' => '{leadView} {leadUpdate} {leadDelete}',
        'buttons'  => [
            'leadView' => function ($url, $model) {
                $url = Url::to(['/shops/shop-slider/view', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'role'=>'modal-remote','title'=> 'Просмотр', 
                    'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-success'
                ]);
            },
            'leadUpdate' => function ($url, $model) {
                $url = Url::to(['/shops/shop-slider/update', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'role'=>'modal-remote','title'=>'Изменить', 'class'=>'btn btn-xs btn-primary'
                ]);
            },
            'leadDelete' => function ($url, $model) {
                $url = Url::to(['/shops/shop-slider/delete', 'id' => $model->id]);
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