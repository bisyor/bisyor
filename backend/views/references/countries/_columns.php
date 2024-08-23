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
        'attribute'=>'name',
    ], 

    [
        'attribute' => 'declination',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'category',
        'header' => 'Областы',
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'width' => '100px',
        'content' => function($data){ 
            return '<center>' . Html::a('Список', ['references/regions', 'countries_id' => $data->id], ['data-pjax'=>'0','title'=> 'Список', 'data-toggle'=>'tooltip', 'class'=>'btn btn-warning btn-xs']) . '</center>';
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width'=>'120px',
        'template' => '{leadUpdate}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons'=>[
            'leadUpdate' => function ($url, $model) {
                $url = Url::to(['/references/countries/update', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'role'=>'modal-remote', 'data-toggle'=>'tooltip', 'title'=>'Редактировать','class'=>'btn btn-info btn-xs']);
            },         
        ],
    ],
];   
