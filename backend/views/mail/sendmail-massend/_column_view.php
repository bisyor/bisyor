<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'title',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'text',
        'content' => function($data){
            return $data->text;
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'content' => function($data){
           return $data->user_id ? $data->user->getUserFio() : $data->phone;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'to_phone',
        'content' => function($data){
            return ($data->to_phone) ? 'Да':'Нет';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'to_email',
        'content' => function($data){
            return ($data->to_email) ? 'Да':'Нет';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'content' => function($data){
            if($data->status == 0) return "<span class='text-danger'>Не отправлено</span>";
            elseif($data->status == 1) return "<span class='text-success'>Отправлено</span>";
            else return "<span class='text-warning'>Отказано</span>>";
        }
    ],
    [
        'class' =>  '\kartik\grid\DataColumn',
        'attribute' =>'date_cr',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Действия',
        'content' => function($data){
           if($data->status != 1){
               return \yii\helpers\Html::a('<span class="fa fa-send"></span> Отправить', ['resend', 'id' => $data->id], ['role'=>'modal-remote']);
           }
        }
    ],

];