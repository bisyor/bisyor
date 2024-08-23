<?php
use yii\helpers\Url;

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
        'attribute'=>'title',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'enabled',
        'width' => '100px;',
        'format' => 'html',
        'value' => function($data){
            return $data->getStatusName($data->enabled);
        },
        'filter' => \backend\models\shops\ShopsAbonements::getStatusType(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'is_free',
        'format' => 'html',
        'value' => function($data){
            return $data->getYesNo($data->is_free);
        },
        'filter' => \backend\models\shops\ShopsAbonements::getAnswerType(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'import',
        'format' => 'html',
        'value' => function($data){
            return $data->getYesNo($data->import);
        },
        'filter' => \backend\models\shops\ShopsAbonements::getAnswerType(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'mark',
        'format' => 'html',
        'value' => function($data){
            return $data->getYesNo($data->mark);
        },
        'filter' => \backend\models\shops\ShopsAbonements::getAnswerType(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fix',
        'format' => 'html',
        'value' => function($data){
            return $data->getYesNo($data->fix);
        },
        'filter' => \backend\models\shops\ShopsAbonements::getAnswerType(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'is_default',
        'format' => 'html',
        'value' => function($data){
            return $data->getYesNo($data->is_default);
        },
        'filter' => \backend\models\shops\ShopsAbonements::getAnswerType(),
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'width' => '120px',
        'viewOptions'=>['data-pjax'=>0,'title'=>'Просмотр','data-toggle'=>'tooltip','class' => 'btn btn-xs btn-success'],
        'updateOptions'=>['data-pjax'=>0,'title'=>'Изменить', 'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-primary'],
        'deleteOptions'=>[
                        'role'=>'modal-remote','title'=>'Удалить', 
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?','class'=>'btn btn-xs btn-danger',
        ], 
    ],

];   