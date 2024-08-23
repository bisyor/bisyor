<?php
use yii\helpers\Url;
use yii\helpers\Html;
return [
    /*[
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],*/
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
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'minutes',
        'width' => '150px',
        'content' => function($data){
            return \yii\widgets\MaskedInput::widget([
                'name' => 'data',
                'value' => $data->minutes,
                'id'=>'minutes'.$data->id,
                'mask' => '9',
                'options' => [
                    'class' =>'form-control',
                    'style'=>'',
                    'onchange'=>" $.get('/references/cache-clear/set-values', {'id':$data->id, 'attribute': 'minutes', 'value':$(this).val()}, function(data){ 
                        document.getElementById('total_price').innerText = data;
                    } );  $('#minutes{$data->id}').inputmask('decimal',{min:0},{max:2780});",
                ],
                'clientOptions' => ['repeat' => 10, 'greedy' => false]
            ]);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'key',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width'=>'120px',
        'template' => '{leadView} {leadUpdate}',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
        },
        'buttons'=>[
            'leadUpdate' => function ($url, $model) {
                $url = Url::to(['/references/cache-clear/update', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'role'=>'modal-remote', 'data-toggle'=>'tooltip', 'title'=>'Редактировать','class'=>'btn btn-success btn-xs']);
            },
            'leadView' => function ($url, $model) {
                $url = Url::to(['/references/cache-clear/view', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'role'=>'modal-remote', 'data-toggle'=>'tooltip', 'title'=>'Просмотр','class'=>'btn btn-info btn-xs']);
            },
            'leadDelete' => function ($url, $model) {
                $url = Url::to(['/references/cache-clear/delete', 'id' => $model->id]);
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