<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use backend\models\banners\Banners;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ], 
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'width',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'height',
    ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'attribute'=>'enabled',
        'width'=>'150px',
        'format'=>'raw',
        //'filter' => Banners::getStatusList(),
        'value'=>function($data){
           /* if($data->enabled == '1') return 'Да';
            else return 'Нет';*/
            return '<label class="switch switch-small">
                    <input type="checkbox"'. (($data->enabled == 1)?' checked=""':'""').'value="'.$data->id.'" onchange="$.post(\'/banners/banner/change-enabled\',{id:'.$data->id.'},function(data){ });">
                    <span></span>
                    </a>
                </label>';
            },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{leadView} {leadDelete}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons'=>[
            'leadView' => function ($url, $model) {
                $url = Url::to(['/banners/banner/view', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['data-pjax'=>0, 'data-toggle'=>'tooltip', 'title'=>'Просмотр','class'=>'btn btn-info btn-xs']);
            },
            'leadDelete' => function ($url, $model) {
                    $url = Url::to(['/banners/banner/delete', 'id' => $model->id]);
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
