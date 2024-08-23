<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'url',
        'content'=>function($data){
            return $data->url." (".$data->local.")"."&nbsp&nbsp&nbsp&nbsp".Html::img($data->getFlag(), [ 'style' => 'height:55px;width:55px;' ]);
        }
    ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'local',
        'width' => '60px'
    ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'attribute'=>'status',
        'width'=>'150px',
        'format'=>'raw',
        'value'=>function($data){
               return '<label class="switch switch-small">
                    <input type="checkbox"'. (($data->status == 1)?' checked=""':'""').(($data->default==2)?' disabled=""':'""').'value="'.$data->id.'" onchange="$.post(\'language/change-values\',{id:'.$data->id.'},function(data){ });">
                    <span></span>
                    </a>
                </label>';
            },
    ],
    [
        'class'    => 'kartik\grid\ActionColumn',
        'template' => ' {update} {leadDelete} {messages}',
        'viewOptions'=>['role'=>'modal-remote','title'=>'Просмотр','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=> 'Редактировать', 'data-toggle'=>'tooltip', 'class' => 'btn btn-success btn-xs'],
        'width' => '12%',
        'buttons'  => [
            'messages' => function($url, $model){
                $url = Url::to(['/translations/source-message/', 'id' => $model->url]);
                return Html::a('<span class="glyphicon glyphicon-book"></span>', $url, [
                    'class' => 'btn btn-info btn-xs',
                    'data-pjax'=>0,'title'=> 'Переводы', 
                    'data-toggle'=>'tooltip'
                ]);
            },
            'leadDelete' => function ($url, $model) {
                if($model->default == 0){
                    $url = Url::to(['/references/language/delete', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'class' => 'btn btn-warning btn-xs',
                          'role'=>'modal-remote','title'=> 'Удалить', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=> 'Подтвердите действие',
                          'data-confirm-message'=> 'Вы уверены что хотите удалить этого элемента?',
                    ]);
                }
            },
        ]
    ],
    
];