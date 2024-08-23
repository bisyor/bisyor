<?php

use kartik\grid\GridView;
use kartik\select2\Select2;
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
        'width' => '60px',
        // 'attribute'=>'avatar',
        'label' => 'Аватар',
        'content' => function($data){
            return Html::img($data->getAvatar(), ['style' => 'width:60px; height:60px; border-radius: 25%',]);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fio',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'phone',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'device',
        'label' => 'Устройства',
        'filter' => \backend\models\users\UserHistory::getDeviceList(),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'size' => Select2::SMALL,
            'options' => ['prompt' => 'Выберите'],
            'pluginOptions' => ['allowClear' => true],
        ],
        'content' => function($data){
            return $data->device->getFromDevice();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'count',
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'label' => 'К-во',
        'content' => function($data){
            return $data->count;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'content' => function($data){
            return \backend\components\StaticFunction::status($data->status);
        }
    ],  
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'last_seen',
        'content' => function($data){
            return $data->last_seen ? date("H:i d.m.Y", strtotime($data->last_seen)) : '';
        }
    ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'attribute'=>'is_verify',
        'width'=>'150px',
        'format'=>'raw',
        'value'=>function($data){
            return '<label class="switch switch-small">
                    <input type="checkbox"'. (($data->is_verify == 1)?' checked=""':'""').'value="'.$data->id.'" onchange="$.post(\'/users/users/change-is-verify-values\',{id:'.$data->id.'},function(data){ });">
                    <span></span>
                    </a>
                </label>';
        },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view} {leadUpdate} {delete}',
        'buttons'  => [
            'leadUpdate' => function ($action, $model) {
                $url = Url::to(['edit-info', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'class' => 'btn btn-info btn-xs',
                    'data-pjax'=>'0','title'=>'Обновить',
                    'data-toggle'=>'tooltip',
                ]);
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['title'=>'Просмотр','data-toggle'=>'tooltip', 'class' => 'btn btn-success btn-xs'],
//         'updateOptions'=>['role'=>'modal-remote','title'=>'Обновить', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить', 'class' => 'btn btn-danger btn-xs',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтвердите действие',
                          'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
                      ],
    ],

];   