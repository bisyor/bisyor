<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'icon_b',
        'format' => 'raw',
        'value' => function($data){
            return $data->getImg(true,'50px','50px');
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'price',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'short_description',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'enabled',
        'width' => '130px;',
        'format' => 'html',
        'value' => function($data){
            return $data->getStatusName($data->enabled);
        },
        'filter' => \backend\models\shops\Services::getStatusType(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_up',
        'label' => 'Изменено',
        'format' => 'raw',
        'value' => function($data){
            return $data->date_up . "<br>" . "(" . $data->changed->fio . ")";
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{update}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Просмотр','data-toggle'=>'tooltip'],
        'updateOptions'=>['data-pjax'=>0,'title'=>'Изменить', 'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-success'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?','class'=>'btn btn-xs btn-danger'], 
    ],

];   