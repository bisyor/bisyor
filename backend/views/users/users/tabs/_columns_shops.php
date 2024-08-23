<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Категория',
        'width' => '300px',
        'attribute'=>'sections',

        'format' => 'raw',
        'value' => function($data){
            return $data->getSections();
        },
        'filter' => ArrayHelper::map(\backend\models\shops\ShopCategories::find()->all(), 'id', 'title'),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'size' => Select2::SMALL,
            'options' => ['prompt' => 'Выберите'],
            'pluginOptions' => ['allowClear' => true,'multiple' => true],
        ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Объявления',
        'format' => 'raw',
        'value' => function($data){
            return $data->getCountAds();
        },

    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'format' => 'raw',
        'attribute'=>'status',
        'value' => function($data){
            return $data->getStatusName($data->status);
        },
        'filter' => \backend\models\shops\Shops::getStatusType(),
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '120px',
        'template' => '{leadView} {leadDelete}',
        'buttons'  => [
            'leadView' => function ($param, $model) {
                $url = Url::to(['/shops/shops/view', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'class' => 'btn btn-xs btn-success',
                    'data-pjax'=>'0','title'=>'Просмотр',
                    'data-toggle'=>'tooltip',
                ]);
            },
            'leadDelete' => function ($param, $model) {
                $url = Url::to(['/shops/shops/delete', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['role'=>'modal-remote','title'=>'Удалить',
                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                    'data-request-method'=>'post',
                    'data-toggle'=>'tooltip',
                    'data-confirm-title'=>'Подтвердите действие',
                    'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?','class'=>'btn btn-xs btn-danger']);
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['data-pjax'=>0,'title'=>'Просмотр','data-toggle'=>'tooltip','class'=>'btn btn-xs btn-success'],
        'updateOptions'=>['data-pjax'=>0,'title'=>'Изменить', 'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-primary'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить',
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-toggle'=>'tooltip',
            'data-confirm-title'=>'Подтвердите действие',
            'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?','class'=>'btn btn-xs btn-danger'],
    ],

];   