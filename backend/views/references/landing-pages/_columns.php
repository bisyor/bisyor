<?php
use yii\helpers\Url;
use yii\helpers\Html;
use dosamigos\switchery\Switchery;
use yii\web\JsExpression;

return [
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
        'attribute'=>'landing_uri',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'original_uri',
        'format'=>'html',
        'width'=>'200px;',
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     // 'attribute'=>'name',
    //     'width'=>'100px',
    //     'contentOptions'=>['class'=>'text-center'],
    //     'headerOptions'=>['class'=>'text-center'],
    //     'header' =>'Голосов',
    //     'content' => function($data){
    //         return $data->getVotes();
    //     }
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     // 'attribute'=>'name',
    //     'width'=>'100px',
    //     'contentOptions'=>['class'=>'text-center'],
    //     'headerOptions'=>['class'=>'text-center'],
    //     'header' =>'Закрыто',
    //     'content' => function($data){
    //         return $data->getClosedVote();
    //     }
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Статус',
        'content' => function($model){
             return Switchery::widget([
                    'name' => 'enabled'.$model->id,
                    'value' => $model->enabled,
                    'checked' => $model->enabled,
                    'clientOptions' => [
                        'size' => 'mini',
                        'color' => '#5FBEAA',
                        'secondaryColor' => '#CCCCCC',
                        'jackColor' => '#FFFFFF',
                    ],
                    'clientEvents' => [
                        'change' => new JsExpression('function() {
                        $.post(\'/references/landing-pages/change-values\', {id: '.$model->id.'}, function(data){$.pjax.reload({container: "#crud-datatable"});});
                    }')
                                ]
                ]);
        }

    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{leadUpdate} {leadDelete}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons'=>[
            
            'leadUpdate' => function ($url, $model) {
                $url = Url::to(['/references/landing-pages/update', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>0,'title'=>'Редактировать','class'=>'btn btn-info btn-xs']);
            },
            'leadDelete' => function ($url, $model) {
                    $url = Url::to(['/references/landing-pages/delete', 'id' => $model->id]);
                    return Html::a('<span style="font-size: 12px;" class="glyphicon glyphicon-trash"></span>', $url, [
                        'role'=>'modal-remote','title'=>'Удалить','class'=>'btn btn-danger btn-xs' ,
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемент?',
                    ]);
            },
            
        ],
    ],

];   