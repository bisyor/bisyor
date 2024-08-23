<?php

use backend\models\items\Applications;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

return [
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
        'attribute'=>'item_id',
        'format' => 'raw',
        'content' => function($data){
            return "<a data-pjax='0' href='/items/items/update?id={$data->item_id}'>{$data->item->title}</a>";
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'phone',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fullname',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'address',
    ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'created_at',
         'content' => function($data){
             return date("d.m.Y H:i" , strtotime($data->created_at));
         }
     ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_at',
    // ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{leadUpdate} {leadDelete}',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
        },
        'buttons'=>[
            'leadUpdate' => function ($url, $model) {
                $url = Url::to(['/items/applications/update', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'role'=>'modal-remote', 'data-toggle'=>'tooltip', 'title'=>'Редактировать','class'=>'btn btn-success btn-xs']);
            },

            'leadDelete' => function ($url, $model) {
                if($model->status == Applications::STATUS_ENDED) {
                    $url = Url::to(['/items/applications/delete',
                        'id' => $model->id]);
                    return Html::a('<span class="fa fa-trash"></span>', $url,
                        ['role' => 'modal-remote', 'title' => 'Удалить',
                            'data-confirm' => false, 'data-method' => false,// for overide yii data api
                            'data-request-method' => 'post',
                            'data-toggle' => 'tooltip',
                            'data-confirm-title' => 'Подтвердите действие',
                            'data-confirm-message' => 'Вы уверены что хотите удалить этого элемента?', 'class' => 'btn btn-xs btn-danger']
                    );
                }
            },
        ],
    ],

];   