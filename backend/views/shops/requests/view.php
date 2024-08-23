<?php
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->params['breadcrumbs'][] = ['label' => 'Заявки', 'url' => ['/shops/requests/index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="panel panel-inverse shops-view">
    <!-- <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Карточка магазина</h4>
    </div> -->
    <div class="panel-body" style="padding: 0px;">
        <?= \yii\widgets\DetailView::widget([
            'model' => $model,
            'attributes' => [
                
                [
                    'attribute'=>'logo',
                    'format' => 'raw',
                    'value' => function($data){
                        return $data->getImg('150px','150px');
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute'=>'name',
                    'value' => function($data){
                        return '<i class="fa fa-building fa-lg m-r-5"></i>  ' . $data->name;
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute'=>'user_id',
                    'value' => function($data){
                        if($data->user_id)
                            return '<i class="fa fa-user fa-lg m-r-5"></i>  ' . $data->user->getUserFio();
                        else return null;
                    }
                ],
                [
                    'attribute'=>'status',
                    'format' => 'raw',
                    'value' => function($data){
                        return $data->getStatusName($data->status);
                    },
                ],
                [
                    'format' => 'raw',
                    'attribute'=>'description',
                    'value' => function($data){
                        return '<i class="fa fa-flash fa-lg m-r-5"></i>  ' . $data->description;
                    },
                ],
                [
                    'format' => 'raw',
                    'attribute'=>'district_id',
                    'value' => function($data){
                        return '<i class="fa fa-compass fa-lg m-r-5"></i>  '.$data->district->region->name . " , " . $data->district->name;
                    },
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'address',
                    'value' => function($data){
                        return '<i class="fa fa-map-marker fa-lg m-r-5"></i>  ' . $data->address;
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'phones',
                    'value' => function($data){
                        return '<i class="fa fa-mobile fa-lg m-r-5"></i>  ' . implode(",  ",$data->getPhoneNumbers());
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute' => 'site',
                    'value' => function($data){
                        return '<i class="fa fa-globe fa-lg m-r-5"></i>  ' . $data->site;
                    }
                ],
                [
                    'format' => 'raw',
                    'attribute'=>'blocked_reason',
                    'value' => function($data){
                        return '<i class="fa fa-ban fa-lg m-r-5"></i>  ' . $data->blocked_reason;
                    },
                ],
                [
                    'format' => 'raw',
                    'attribute'=>'admin_comment',
                    'value' => function($data){
                        return '<i class="fa fa-comment fa-lg m-r-5"></i>  ' . $data->admin_comment;
                    },
                ],
                [
                    'format' => 'raw',
                    'attribute'=>'social_networks',
                    'value' => function($data){
                        return $data->getSotSetiTemplate();
                    },
                ],
                [
                    'format' => 'raw',
                    'attribute'=>'date_cr',
                    'value' => function($data){
                        return '<i class="fa fa-plus-circle fa-lg m-r-5"></i>  ' . $data->date_cr;
                    },
                ],
                
                [
                    'format' => 'raw',
                    'attribute'=>'date_up',
                    'value' => function($data){
                        return '<i class="fa fa-pencil fa-lg m-r-5"></i>  ' . $data->date_up;
                    },
                ],
            ],
        ]) ?>
    </div>
</div>