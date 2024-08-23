<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
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
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'icon',
        'width' => '100px',
        'content' => function($data){
            if ($data->icon != null){
                return Html::img(Yii::$app->params['image_site'].'/web/uploads/social_icons/'.$data->icon, [ 'style' => 'height:40px;width:40px;']);
            }
        }
    ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'attribute'=>'status',
        'width'=>'150px',
        'format'=>'raw',
        'value'=>function($data){
               return '<label class="switch switch-small">
                    <input type="checkbox"'. (($data->status == 1)?' checked=""':'""').'value="'.$data->id.'" onchange="$.post(\'/references/social-networks/change-status\',{id:'.$data->id.'},function(data){ });">
                    <span></span>
                    </a>
                </label>';
            },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '12%',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Просмотр','data-toggle'=>'tooltip', 'class' => 'btn btn-success btn-xs'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Изменить', 'data-toggle'=>'tooltip', 'class' => 'btn btn-info btn-xs'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить', 'class' => 'btn btn-danger btn-xs',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтвердите действие',
                          'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
                      ],
    ],

];   