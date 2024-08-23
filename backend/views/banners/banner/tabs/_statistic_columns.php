<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use backend\models\banners\Banners;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Наименование реклам',
        'content' => function($data){
            return $data->bannerItems->title;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Текст',
        'content' => function($data){
            return $data->bannerItems->description;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Ссылка',
        'content' => function($data){
            return $data->bannerItems->url;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date',
        'content' => function($data){
            if($data->date != null) return date('d.m.Y', strtotime($data->date) );
            return null;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'clicks',   
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'shows',   
    ],
];   
