<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use backend\models\bills\Bills;
return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
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
        'attribute'=>'date_cr',
        'filter' => DatePicker::widget(['language' => 'ru',
                    'name' => 'search_created_date']),
        'filterType' => GridView::FILTER_DATE,
        'filterWidgetOptions' => [
            'layout' => '{input}{picker}{remove}',
            'options' => ['prompt' => 'Выберите'],
            'pluginOptions' => ['format' => 'dd.mm.yyyy', 'autoclose' => true],
        ],
        'content' => function($data){
            return date("H:i d.m.Y", strtotime($data->date_cr));
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_balance',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'amount',
        'content' => function($data){
            return $data->type ==1 ? '+ '.$data->amount : '- '.$data->amount;
        }
    ],
     [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',
        'format' => 'html',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'filter' => Bills::getStatus(),
        'filterType' => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'size' => Select2::MEDIUM,
            'options' => ['prompt' => 'Выберите'],
            'pluginOptions' => ['allowClear' => true],
        ],
        'content' => function($data){
            return Bills::getStatus()[$data->status];
        }
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'change_state',
    // ],
];   