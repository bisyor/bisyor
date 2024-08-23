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
        'attribute'=>'user_id',
        'content' => function($data){
            return $data->getUserFio();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_cr',
        'content' => function($data){
            return date('d.m.Y H:i' , strtotime($data->date_cr));
        }
    ], 
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
        'content' => function($data){
            return $data->name.' <a href = "mailto: "'.$data->email.'">'.$data->email.'</a>';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'message',
        'content' => function($data){
            return (strlen($data->message) > 200) ? mb_substr($data->message, 0, 200) . "..." : $data->message;;
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '120px',
        'template' => '{leadCheck} {leadView} {leadDelete}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons'=>[
            'leadCheck' => function ($url, $model) {
                if(!$model->viewed)
                {
                    $url = Url::to(['/references/contacts/check', 'id' => $model->id]);
                    return Html::a('<span class="fa fa-check"></span>', $url, [ 'role'=>'modal-remote', 'data-toggle'=>'tooltip', 'title'=>'Просмотр','class'=>'btn btn-inverse btn-xs']);
                }
            },
            'leadView' => function ($url, $model) {
                $url = Url::to(['/references/contacts/view', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'role'=>'modal-remote', 'data-toggle'=>'tooltip', 'title'=>'Просмотр','class'=>'btn btn-info btn-xs']);
            },
            'leadDelete' => function ($url, $model) {
                $url = Url::to(['/references/contacts/delete', 'id' => $model->id]);
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