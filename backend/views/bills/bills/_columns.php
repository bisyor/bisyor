<?php

use backend\models\bills\Bills;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
return [
//    [
//        'class' => 'kartik\grid\CheckboxColumn',
//        'width' => '20px',
//    ],
//    [
//        'class' => 'kartik\grid\SerialColumn',
//        'width' => '30px',
//    ],
     [
     'class'=>'\kartik\grid\DataColumn',
     'attribute'=>'id',
     ],
     [
     'class'=>'\kartik\grid\DataColumn',
     'attribute'=>'date_cr',
      'content' => function($data){
           $date = strtotime($data->date_cr);
           return $data->date_cr ? date("j ", $date).Bills::monthName()[date("n", $date)].date(" Y, H:i", $date) : '';
      }
     ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'content' => function($data){

            if($data->user_id){
                if($data->user->fio) $link_name = $data->user->fio;
                elseif($data->user->email) $link_name = $data->user->email;
                else $link_name = $data->user->phone;
            }else $link_name = $data->ip;

            $url = Url::to(['/bills/bills/user-info', 'id' => $data->id]);
            $link = Html::a($link_name, $url, [
                    'role'=>'modal-remote','title'=> 'Просмотр', 
                    'data-toggle'=>'tooltip','class'=>'btn btn-sm btn-link '.(!$data->user_id ? 'disabled':''),'style' => 'padding-left:0px;'
                ]);
            return $link;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_balance',
        'label' => 'Баланс',
        'pageSummary' => true,
        'format' => 'decimal',
        'content' => function($data) {
            return number_format($data->user_balance, 0, '.', ' ');
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'amount',
        'pageSummary' => true,
        'format' => 'decimal',
        'content' => function($data){
            if($data->type == Bills::TYPE_PAY || $data->type == Bills::TYPE_PPRIZ) return "<b style='color: #1c7430'>+".number_format($data->amount, 0, '.', ' ')."</b>";
            else return "<b class='text-danger'>-".number_format($data->amount, 0, '.', ' ')."</b>";
        }
    ],
     [
     'class'=>'\kartik\grid\DataColumn',
     'attribute'=>'description',
     'content' => function($data){
            return $data->description;
        }
     ],
     [
     'class'=>'\kartik\grid\DataColumn',
     'attribute'=>'status',
     'content' => function($data){
        $result = Bills::getStatus()[$data->status];
        if($data->status == Bills::STATUS_NEZAVERSHEN || $data->status == Bills::STATUS_OTMEN){
            return "<span class='text-danger'>$result</span>";
        }elseif($data->status == Bills::STATUS_ZAVERSHEN){
            return "<span style='color: #1c7430'>$result</span>";
        }else{
            return "<span class='text-warning'>$result</span>";
        }
     },
         'filter' => false
     ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Операция',
        'content' => function($data){
            $url = Url::to(['/bills/bills/operation', 'user_id' => $data->user_id]);
            return Html::a('<span class="fa fa-arrow-circle-right"></span>', $url, ['data-pjax'=>0, 'data-toggle'=>'tooltip', 'title'=>'Операция со счетом пользователя','class'=>'btn btn-info btn-xs']);
        },
        'filter' => false
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'service_id',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'svc_activate',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'svc_settings',
//    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'item_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'type',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'psystem',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'money',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'currency_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'date_cr',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'details',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ip',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'promocode_id',
    // ],
//    [
//        'class' => 'kartik\grid\ActionColumn',
//        'dropdown' => false,
//        'width' => '12%',
//        'vAlign'=>'middle',
//        'urlCreator' => function($action, $model, $key, $index) {
//                return Url::to([$action,'id'=>$key]);
//        },
//        'viewOptions'=>['role'=>'modal-remote','title'=>'Просмотр','data-toggle'=>'tooltip', 'class' => 'btn btn-success btn-xs'],
//        'updateOptions'=>['role'=>'modal-remote','title'=>'Изменить', 'data-toggle'=>'tooltip', 'class' => 'btn btn-info btn-xs'],
//        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить', 'class' => 'btn btn-danger btn-xs',
//                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
//                          'data-request-method'=>'post',
//                          'data-toggle'=>'tooltip',
//                          'data-confirm-title'=>'Подтвердите действие',
//                          'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
//                    ]
//    ],

];   