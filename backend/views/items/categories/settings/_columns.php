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
        'attribute'=>'title',
        'format' => 'raw',
        'value' => function($data){
            if($data->req == 1){
                return $data->title . "<b><font color='red'>*</font></b>";
            }else{
                return $data->title;
            }
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'data_field',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'parent_value',
        'value' => function($data){
            return $data->getParentDesc();
        },
        'contentOptions' => ['class' => 'text-center'],
        'headerOptions' => ['class' => 'text-center']
    ],    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'in_search',
        'label' => 'Поиск',
        'content' => function($data){
            return  \kartik\checkbox\CheckboxX::widget([
                        'name'=>'s_3',
                        'value'=>$data->in_search,
                        'options'=>[
                            'id'=>'s_'.$data->id,
                            'onchange' => '$.post(\'/items/categories/change-search?id='.$data->id.'\',
                                function(success){
                                    $.pjax.reload(\'#crud-datatable-pjax\', {timeout : false});
                                })'
                        ],
                        'pluginOptions'=>['threeState'=>false]
                    ]);
        },
        'contentOptions' => ['class' => 'text-center'],
        'headerOptions' => ['class' => 'text-center']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cache_key',
        'contentOptions' => ['class' => 'text-center'],
        'headerOptions' => ['class' => 'text-center']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'value' => function($data){
            return $data->getTypeDescription();
        },
        'contentOptions' => ['class' => 'text-center'],
        'headerOptions' => ['class' => 'text-center']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'published_telegram',
        'contentOptions' => ['class' => 'text-center'],
        'headerOptions' => ['class' => 'text-center'],
        'content' => function($model){
            return \dosamigos\switchery\Switchery::widget([
                'name' => 'published_telegram',
                'value' => $model->published_telegram,
                'checked' => $model->published_telegram,
                'clientOptions' => [
                    'size' => 'mini',
                    'color' => '#5FBEAA',
                    'secondaryColor' => '#CCCCCC',
                    'jackColor' => '#FFFFFF',
                ],
                'clientEvents' => [
                    'change' => new \yii\web\JsExpression('function() {
                        $.post(\'/items/categories/active-change\', {id: '.$model->id.'}, function(data){$.pjax.reload({container: "#crud-datatable"});});
                    }')
                ]
            ]);
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'width' => '120px',
        'dropdown' => false,
        'vAlign'=>'middle',
        'headerOptions'=>['class'=>'text-center'],
        'template' => '{leadView} {leadDelete}',
        'buttons'  => [
            'leadView' => function ($url, $model) {
                $url = Url::to(['/items/categories/update-settings', 'id' => $model->id, 'name' => $model->category->title]);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'data-pjax'=>0,'title'=> 'Изменить', 
                    'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-success'
                ]);
            },
            'leadDelete' => function ($url, $model) {
                if($model->parent_value == 0){
                    $url = Url::to(['/items/categories/delete-setting','id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, 
                        ['role'=>'modal-remote','title'=>'Удалить', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?','class'=>'btn btn-xs btn-danger']
                    );
                }
                    
            },
        ]
    ],

];   