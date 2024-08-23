<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'width' => '60px',
//        // 'attribute'=>'avatar',
//        'label' => 'Аватар',
//        'content' => function($data){
//            return Html::img($data->getAvatar(), ['style' => 'width:60px; height:60px; border-radius: 25%',]);
//        }
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'ФИО',
        'content' => function($data){
            return $data['moderated']['fio'];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Телефон',
        'content' => function($data){
            return $data['moderated']['phone'];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Email',
        'content' => function($data){
            return $data['moderated']['email'];
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'label' => 'К-во',
        'content' => function($data){
            return $data['count'];
        }
    ],
];