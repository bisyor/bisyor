<?php
use yii\helpers\Url;
use yii\helpers\Html;
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
        'attribute'=>'type',
        'content' => function($data) {
            return $data->getTypeList()[$data->type];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'img',
        'label' => 'Значение',
        'content' => function($data) {
            if($data->type == $data::TYPE_IMAGE) {
                if ($data->img != null){
                    return Html::img(Yii::$app->params['image_site'].'/web/uploads/banners/'.$data->img, [ 'style' => 'height:55px;width:80px;']);
                }
                else return Html::img('/backend/web/uploads/noimg.jpg', [ 'style' => 'height:55px;width:80px;']);                
            }
            else return $data->type_data;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'url',   
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'show_limit',
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',   
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'enabled',
        'content' => function($data) {
            if($data->enabled) return 'Да';
            else return 'Нет';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'show_start',
        'label' => 'Дата',
        'content' => function($data) {
            return $data->show_start . ' - ' . $data->show_finish;
        }
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'lang_code',
        'label' => 'Язык баннера',
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
                $url = Url::to(['/banners/banner-slide/update', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'data-pjax'=>'0', 'data-toggle'=>'tooltip', 'title'=>'Редактировать','class'=>'btn btn-info btn-xs']);
            },
            'leadDelete' => function ($url, $model) {
                    $url = Url::to(['/banners/banner-slide/delete', 'id' => $model->id]);
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
