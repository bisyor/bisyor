<?php
/* 
    Веб разработчик: Abdulloh Olimov 
*/

use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'search_text',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'changed_date',
        'content' => function($data){
            return date("m.d.Y" ,strtotime($data->changed_date));
        },
    ],
];