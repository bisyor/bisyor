<?php
use yii\helpers\Url;
use yii\helpers\Html;
use dosamigos\switchery\Switchery;
use yii\web\JsExpression;
use kartik\select2\Select2;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use backend\models\promocodes\Promocodes;
return [
//    [
//        'class' => 'kartik\grid\CheckboxColumn',
//        'width' => '20px',
//    ],
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
        'attribute'=>'code',
        'content' => function($data){
            return $data->code . "<br><i>" . $data->title . "</i>";
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'content' => function($data){
            if($data->type == 1){
                switch ($data->discount_type){
                    case 1 : return  Promocodes::getTypeList()[$data->type] . " " .$data->discount . " %";
                    case 2 : return  Promocodes::getTypeList()[$data->type] . " " .$data->discount . " сум";
                    case 3 : return  Promocodes::getDiscountList()[$data->discount_type];
                    default : return "---";
                }
            }else{
                return Promocodes::getTypeList()[$data->type] . "<br>" . $data->amount . " сум";
            }
            return ;
        },
        'filter' => Promocodes::getTypeList(),
        'filterType' => GridView::FILTER_SELECT2,
        'filterInputOptions' => ['id' => 'promocode-select-type-1'],
        'filterWidgetOptions' => [
            'size' => Select2::MEDIUM,
            'options' => ['prompt' => 'Выберите'],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'usage_by',
        'label' => 'Для кого',
        'content' => function($data){
            return Promocodes::getUsageByList()[$data->usage_by];
        },
        'filter' => Promocodes::getUsageByList(),
        'filterType' => GridView::FILTER_SELECT2,
        'filterInputOptions' => ['id' => 'promocode-select-usage-1'],
        'filterWidgetOptions' => [
            'size' => Select2::MEDIUM,
            'options' => ['prompt' => 'Выберите'],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'discount_type',
//        'content' => function($data){
//            return $data->getDiscountList()[$data->discount_type];
//        }
//    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'discount',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'usage_for',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'amount',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'usage_limit',
    // ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'headerOptions' => ['class' => 'text-center'],
         'contentOptions' => ['class' => 'text-center'],
         'label' => ' Использований',
         'attribute'=>'used',
         'content' => function($data){
            return  Html::a($data->used, ['/promocodes/promocodes-usage/index', 'code' => $data->id],
                ['data-pjax' => 0,'title'=> 'Просмотр']);
         }
     ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_at',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'active_from',
        'label' => 'Запущен',
        'filter' => DatePicker::widget(['language' => 'ru',
            'name' => 'search_created_date']),
        'filterType' => GridView::FILTER_DATE,
        'filterInputOptions' => ['id' => 'promocode-date-active-1'],
        'filterWidgetOptions' => [
            'layout' => '{input}{picker}',
            'options' => ['prompt' => 'Выберите'],
            'pluginOptions' => ['format' => 'dd.mm.yyyy', 'autoclose' => true],
        ],
        'content' => function($data){
            return empty($data->active_from) ? 'Не используется' : date("d.m.Y", strtotime($data->active_from));
        },
        'contentOptions' => [
            'width' => '150px',
        ]
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'contentOptions' => ['class' => 'text-center'],
        'headerOptions' => ['class' => 'text-center'],
        'attribute'=>'active_to',
        'width' => '15%',
        'filter' => DatePicker::widget(['language' => 'ru',
            'name' => 'search_created_date']),
        'filterType' => GridView::FILTER_DATE,
        'filterInputOptions' => ['id' => 'promocode-date-to-1'],
        'filterWidgetOptions' => [
            'layout' => '{input}{picker}',
            'options' => ['prompt' => 'Выберите'],
            'pluginOptions' => ['format' => 'dd.mm.yyyy', 'autoclose' => true],
        ],
        'content' => function($data){
            if($data->active_to){
                return date("d.m.Y", strtotime($data->active_to));
            }else{
                if($data->usage_limit){
                    return "<span class='text-center'>Бессрочно </span> <br> до " .$data->usage_limit ."использований";
                }
            }
        }
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'active',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'statistics_id',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'is_once',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'break_days',
    // ],
    [
    	'class'=>'\kartik\grid\DataColumn',
    	'label' => 'Активен',
    	'content' => function($model){
    		 return Switchery::widget([
                    'name' => 'active',
                    'value' => $model->active,
                    'checked' => $model->active,
                    'clientOptions' => [
                        'size' => 'mini',
                        'color' => '#5FBEAA',
                        'secondaryColor' => '#CCCCCC',
                        'jackColor' => '#FFFFFF',
                    ],
                    'clientEvents' => [
                        'change' => new JsExpression('function() {
                        $.post(\'promocodes/active-change\', {id: '.$model->id.'}, function(data){$.pjax.reload({container: "#crud-datatable"});});
                    }')
                                ]
                ]);
    	}

    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{update}',
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