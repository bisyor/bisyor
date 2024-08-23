<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\references\Vacancies;
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
        'attribute'=>'title',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'vacancy_count',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'category_id',
        'filter' => Vacancies::getCaregoryList(),
        'content' => function($data){
            return $data->category_id ? $data->category->name : '<span style="color:#ff4d4d">Не задано</span>';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'price',
        'content' => function($data){
            return  number_format($data->price, 0, '.', ' ');
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'currency_id',
        'filter' => Vacancies::getCurrdencyList(),
        'content' => function($data){
            return $data->currency_id ? $data->currency->name : '<span style="color:#ff4d4d">Не задано</span>';
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width'=>'120px',
        'template' => '{leadUpdate} {leadDelete} {leadView}',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
        },
        'buttons'=>[
            'leadUpdate' => function ($url, $model) {
                $url = Url::to(['/references/vacancies/update', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'role'=>'modal-remote', 'data-toggle'=>'tooltip', 'title'=>'Редактировать','class'=>'btn btn-success btn-xs']);
            },
            'leadDelete' => function ($url, $model) {
                $url = Url::to(['/references/vacancies/delete', 'id' => $model->id]);
                return Html::a('<span style="font-size: 12px;" class="glyphicon glyphicon-trash"></span>', $url, [
                    'role'=>'modal-remote','title'=>'Удалить','class'=>'btn btn-danger btn-xs' ,
                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                    'data-request-method'=>'post',
                    'data-toggle'=>'tooltip',
                    'data-confirm-title'=>'Подтвердите действие',
                    'data-confirm-message'=>'Вы уверены что хотите удалить этого элемент?',
                ]);
            },
            'leadView' => function($url, $model){
                $url = Url::to(['/references/vacancies/view', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'data-pjax' => 0, 'data-toggle'=>'tooltip', 'title'=>'Просмотр','class'=>'btn btn-info btn-xs']);
            }
        ],
    ],

];   