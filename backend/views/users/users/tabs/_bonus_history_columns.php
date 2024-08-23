<?php
return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
        'label' => 'Заголовок',
        'content' => function($data){
            return $data->bonus->title;
        }
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_cr',
        'content' => function($data){
            return date("H:i d.m.Y", strtotime($data->date_cr));
        }
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'summa',
        'content' => function($data){
            return number_format($data->summa, 0, '.', ' ');
        }
    ],
];