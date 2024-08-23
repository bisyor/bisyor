<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\blogs\BlogPosts;

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
                return Html::img($data->getAvatar(), [ 'style' => 'height:55px;width:80px;']);
            }
            else return Html::img('/backend/web/uploads/noimg.jpg', [ 'style' => 'height:55px;width:80px;']);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'blog_categories_id',
        'filter' => BlogPosts::getCategoriesList(),
        'content' => function($data){
            return $data->blogCategories->name;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'slug',
        'format' => 'raw',
        'value' => function($data) {
            return Html::a($data->getSlugLink() . ' <i class="fa fa-external-link"></i>', $data->getSlugLink(), ['target' => '_blank']);
        }
    ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'attribute'=>'status',
        'width'=>'150px',
        'format'=>'raw',
        'filter' => BlogPosts::getStatusList(),
        'value'=>function($data){
            return $data->getStatusName();    
        },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{leadView} {leadUpdate} {leadDelete}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons'=>[
            'leadView' => function ($url, $model) {
                $url = Url::to(['/blogs/blog-posts/view', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'data-pjax'=>0, 'data-toggle'=>'tooltip', 'title'=>'Просмотр','class'=>'btn btn-info btn-xs']);
            },
            'leadUpdate' => function ($url, $model) {
                $url = Url::to(['/blogs/blog-posts/update', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'data-pjax'=>0, 'data-toggle'=>'tooltip', 'title'=>'Редактировать','class'=>'btn btn-warning btn-xs']);
            },
            'leadDelete' => function ($url, $model) {
                    $url = Url::to(['/blogs/blog-posts/delete', 'id' => $model->id]);
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
