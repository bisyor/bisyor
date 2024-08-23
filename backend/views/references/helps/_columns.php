<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\references\Helps;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute' => 'helps_categories_id',
        'filter' => Helps::getHelpsCategoriesList(),
        'content' => function($data){
            return $data->helpsCategories->name;
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
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'text',
        'format' => 'html',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'usefull_count',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nousefull_count',
    ],
  /*  [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
        'header' => 'Вопросы',
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'width' => '100px',
        'content' => function($data){
            return '<center>' . Html::a('Добавить', ['references/helps/index', 'help_id' => $data->id], ['data-pjax'=>'0','title'=> 'Добавить вопросы', 'class'=>'btn btn-warning btn-xs']) . '</center>';
        }
    ],*/
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
                $url = Url::to(['/references/helps/update', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'data-pjax'=>'0', 'data-toggle'=>'tooltip', 'title'=>'Редактировать','class'=>'btn btn-success btn-xs']);
            },
            'leadDelete' => function ($url, $model) {
                    $url = Url::to(['/references/helps/delete', 'id' => $model->id]);
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