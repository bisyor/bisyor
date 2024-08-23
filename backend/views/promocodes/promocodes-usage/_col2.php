<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\promocodes\PromocodesUsage;
use kartik\select2\Select2;
use kartik\grid\GridView;
use kartik\date\DatePicker;
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
        'attribute'=>'promocode_id',
        'content' => function($data){
            if($data->promocode->active == 1){
                return "<span style='color: #1c7430' class='fa fa-circle'></span> " . Html::a($data->promocode->code, ['/promocodes/promocodes/update', 'id' => $data->promocode_id], ['data-pjax' =>0]);
            }else{
                return "<span style='color: #3F4B55' class='fa fa-circle'></span> " . Html::a($data->promocode->code, ['/promocodes/promocodes', 'id' => $data->promocode_id],  ['data-pjax' =>0]);
            }
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Название',
        'content' => function($data){
            return $data->promocode->title;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'used_at',
        'filter' => DatePicker::widget(['language' => 'ru',
            'name' => 'search_created_date']),
        'filterType' => GridView::FILTER_DATE,
        'filterInputOptions' => ['id' => 'promocode-usage-date-active-3'],
        'filterWidgetOptions' => [
            'layout' => '{input}{picker}',
            'options' => ['prompt' => 'Выберите'],
            'pluginOptions' => ['format' => 'dd.mm.yyyy', 'autoclose' => true],
        ],
        'content' => function($data){
            return $data->used_at ? date("d.m.Y", strtotime($data->used_at)) : "-";
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'user_id',
        'content' => function($data){
            return Html::a(($data->user->email) ? $data->user->email : $data->user->phone, ['users', 'id' =>$data->user_id], ['role' => 'modal-remote']);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Где использован',
        'width' => '20%',
        'content' => function($data){
            if(!$data->promocode->category_list){
                if($data->promocode->type == 1){
                    if($data->item_id){
                        if($data->item_id != 0 && !empty($data->item->title)) $title_item = $data->item->title;
                        else $title_item = "";
                        return "Категория:<b>".$data->category->title ."</b><br>Объявление ".
                            Html::a($data->item_id, ['/items/view', 'id' => $data->item_id]). " - " . $title_item;
                    }else{
                        if($data->category_id != 0 && !empty($data->item->title)) $title_item = $data->category->title;
                        else $title_item = '';
                        if($data->shop_id != 0 && !empty($data->shop->name)) $shop_name = $data->shop->name;
                        else $shop_name = '';
                        return "Категория:<b>".$title_item ."</b><br>Магазин ".
                            Html::a($data->shop_id, ['/shops/view', 'id' => $data->shop_id]). " - " . $shop_name;
                    }
                }else{
                    if($data->used_at) return "Пополнение счета на" . $data->promocode->amount . " сум";
                }
            }
        }
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'category_id',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'category_root_id',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'item_id',
//    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'shop_id',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'shop_categories',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'is_active',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'success',
        'content' => function($data){
            return PromocodesUsage::getSuccess()[$data->success];
        },
        'filter' => PromocodesUsage::getSuccess(),
        'filterType' => GridView::FILTER_SELECT2,
        'filterInputOptions' => ['id' => 'promocode-usage-select-active-2'],
        'filterWidgetOptions' => [
            'id' => 'saas',
            'size' => Select2::MEDIUM,
            'options' => ['prompt' => 'Выберите'],
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
//    [
//        'class' => 'kartik\grid\ActionColumn',
//        'dropdown' => false,
//        'vAlign'=>'middle',
//        'urlCreator' => function($action, $model, $key, $index) {
//                return Url::to([$action,'id'=>$key]);
//        },
//        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
//        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
//        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
//                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
//                          'data-request-method'=>'post',
//                          'data-toggle'=>'tooltip',
//                          'data-confirm-title'=>'Are you sure?',
//                          'data-confirm-message'=>'Are you sure want to delete this item'],
//    ],

];
?>
