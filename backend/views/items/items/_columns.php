<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
        'width' => '5%',
    ],
     [
        'class'=>'\kartik\grid\DataColumn',
        'width' => '60px',
        // 'attribute'=>'avatar',
        'label' => 'Изображение',
        'content' => function($data){
            return Html::img($data->getImageM(), ['style' => 'width:60px; height:60px; border-radius: 25%',]);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
        'format' => 'raw',
        'value' => function($data){
            $icon = '';
            $service = $data->getCheckServices();
            if(($data->date_cr != $data->date_up) && ($data->date_up != '')) $icon = ' <span class="fa fa-pencil"></span>';
            $url = Url::to(['/items/items/view', 'id' => $data->id]);
            $link = Html::a('<span class="fa fa-external-link"></span> '.mb_substr($data->title,0,90) . $icon." ".$service, $url, [
                    'role'=>'modal-remote','title'=> 'Просмотр',
                    'data-toggle'=>'tooltip','class'=>'btn btn-sm btn-link','style' => 'padding-left:0px;'
                ]);
            return $link."<br><p class='muted'>".$data['cat']['title']."</p>";
        },
        'width' => '50%'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_cr',
        'width' => '20%',
        'headerOptions' => ['class'=> 'text-center'],
        'contentOptions' => ['class'=> 'text-center'],
        'value' => function($data){
            return date("H:i d.m.Y", strtotime($data->date_cr));
        },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '120px',
        'dropdown' => false,
        'vAlign'=>'middle',
        'headerOptions'=>['class'=>'text-center'],
        'template' => '{leadUserView} {leadUpdate} {leadDelete}',
        'buttons'  => [
            'leadUserView' => function($url, $model){
                $url = Url::to(['/items/items/user-info', 'id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-user"></span>', $url, [
                    'role'=>'modal-remote','title'=> 'Пользователь',
                    'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-info'
                ]);
            },
            'leadUpdate' => function ($url, $model) {
                $url = Url::to(['/items/items/update','id' => $model->id]);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                    [
                        'data-pjax'=>0,'title'=>'Изменить', 'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-success'
                    ]);
            },
            // 'leadDelete' => function ($url, $model) {
            //     $url = Url::to(['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_INPUBLICATION ]);
            //     $url = Url::to(['/items/items/delete',
            //         'id' => $model->id,
            //         'tab' => ( isset($_COOKIE["tab-items"]) && $_COOKIE["tab-items"] != 'undefined' ) ? $_COOKIE["tab-items"] : null ]);
            //     $url = Url::to(['/items/items/change-status-item', 'id' => $model->id, 'status' => Items::STATUS_INPUBLICATION ]);
            //     return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
            //         [
            //             'role'=>'modal-remote','title'=>'Удалить',
            //             'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            //             'data-request-method'=>'post',
            //             'data-toggle'=>'tooltip',
            //             'data-confirm-title'=>'Подтвердите действие',
            //             'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?','class'=>'btn btn-xs btn-danger'
            //             ]);
            // },
            'leadDelete' => function ($url, $model) {
                    $url = Url::to(['/items/items/delete', 'id' => $model->id]);
                    return Html::a('<span style="font-size: 12px;" class="glyphicon glyphicon-trash"></span>', $url, [
                        'role'=>'modal-remote','title'=>'Удалить','class'=>'btn btn-danger btn-xs' ,
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемент?',
                    ]);
            },
        ]
    ],

];
