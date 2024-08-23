<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'key',
    ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'admin_access',
        'format'=>'raw',
        'value'=>function($data){
               return '<label class="switch switch-small">
                    <input type="checkbox"'. (($data->admin_access == 1)?' checked=""':'""').'value="'.$data->id.'" onchange="$.post(\'/users/roles/change-values\',{id:'.$data->id.'},function(data){ });">
                    <span></span>
                    </a>
                </label>';
            },
    ],
    [
        'contentOptions'=>['class'=>'text-center'],
        'headerOptions'=>['class'=>'text-center'],
        'class'=>'\kartik\grid\DataColumn',
        'width' => '40px',
        // 'attribute'=>'color',
        'label' => 'Цвет',
        'content' => function($data){
            return "<div style='background-color:".$data->color."; width:30px; height: 30px; border-radius:10px'></div>";
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '15%',
        'dropdown' => false,    
        'vAlign'=>'middle',
        'template' => '{leadMethods} {view} {update}',
        'buttons'  => [
            'leadMethods' => function ($url, $model) {
                $url = Url::to(['methods', 'id' => $model->id]);
                if ($model->id != 22)
                    return Html::a('<span class="fa fa-group"></span>', $url, [
                        'class' => 'btn btn-inverse btn-xs',
                        'data-pjax'=>'0','title'=>'Доступ',
                        'data-toggle'=>'tooltip',
                    ]);
                else return false;
            },
        ],
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Просмотр','data-toggle'=>'tooltip', 'class' => 'btn btn-success btn-xs'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Обновить', 'data-toggle'=>'tooltip', 'class'=>'btn btn-info btn-xs'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Удалить',  'class'=>'btn btn-danger btn-xs',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтвердите действие',
                          'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
                      ],
    ],

];   