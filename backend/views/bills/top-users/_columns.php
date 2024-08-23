<?php

use backend\models\bills\Bills;
use yii\helpers\Html;
use yii\helpers\Url;
return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' =>'Пользователь',
        'content' => function($data){

            if($data['user_id']){
                if($data['user']['fio']) $link_name = $data['user']['fio'];
                elseif($data['user']['email']) $link_name = $data['user']['email'];
                else $link_name = $data['user']['phone'];
            }else $link_name = "#".$data['user_id'];

            $url = Url::to(['/bills/top-users/user-info', 'id' => $data['user_id']]);
            $link = Html::a($link_name, $url, [
                    'role'=>'modal-remote','title'=> 'Просмотр', 
                    'data-toggle'=>'tooltip','class'=>'btn btn-sm btn-link '.(!$data['user_id'] ? 'disabled':''),'style' => 'padding-left:0px;'
                ]);
            return $link;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Баланс',
        'attribute' => 'balance',
        'pageSummary' => true,
        'format' => 'decimal',
        'content' => function($data) {
            return number_format($data['balance'], 0, '.', ' ')." сум";
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' =>'PayMe',
        'attribute' => 'payme_summa',
        'pageSummary' => true,
        'format' => 'decimal',
        'content' => function($data){
            return number_format($data['payme_summa'], 0, '.', ' ')." сум";;
        },
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'label' =>'Click',
        'attribute' => 'click_summa',
        'pageSummary' => true,
        'format' => 'decimal',
        'content' => function($data){
            return number_format($data['click_summa'], 0, '.', ' ')." сум";;
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' =>'PayNet',
        'attribute' => 'paynet_summa',
        'pageSummary' => true,
        'format' => 'decimal',
        'content' => function($data){
            return number_format($data['paynet_summa'], 0, '.', ' ')." сум";;
        },
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'label' =>'Общая сумма',
        'attribute' => 'totalSumma',
        'pageSummary' => true,
        'format' => 'decimal',
        'content' => function($data){
            return number_format($data['totalSumma'], 0, '.', ' ')." сум";;
        },
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'label' =>'История',
        'content' => function($data){
        $user_id = $data['user_id'];
            return '<a data-pjax="0" href="/bills/bills?BillsSearch[user_id]='. $user_id.'" class="btn btn-primary btn-xs">История</a>';
        },
    ],


];   