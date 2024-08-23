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
        'attribute'=>'image',
        'width' => '150px',
        'content' => function($data){
            if ($data->image != null){
                return Html::img(Yii::$app->params['image_site'].'/web/uploads/brands/'.$data->image, [ 'style' => 'height:55px;width:80px;']);
            }
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'sorting',
    ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'attribute'=>'enabled',
        'width'=>'150px',
        'format'=>'raw',
        'value'=>function($data){
            return '<label class="switch switch-small">
                <input type="checkbox"'. (($data->enabled == 1)?' checked=""':'""').'value="'.$data->id.'" onchange="$.post(\'/admin/references/brands/change-enabled\',{id:'.$data->id.'},function(data){ });">
                <span></span>
                </a>
            </label>';
        },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width'=>'120px',
        'template' => '{leadView} {leadUpdate} {leadDelete}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons'=>[
            'leadView' => function ($url, $model) {
                $url = Url::to(['/references/brands/view', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'role'=>'modal-remote', 'data-toggle'=>'tooltip', 'title'=>'Просмотр','class'=>'btn btn-info btn-xs']);
            },
            'leadUpdate' => function ($url, $model) {
                $url = Url::to(['/references/brands/update', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'role'=>'modal-remote', 'data-toggle'=>'tooltip', 'title'=>'Редактировать','class'=>'btn btn-info btn-xs']);
            },
            'leadDelete' => function ($url, $model) {
                $url = Url::to(['/references/brands/delete', 'id' => $model->id]);
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
