<?php

use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Vacancies */
?>
<div class="vacancies-view">
    <div class="panel panel-inverse user-index">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="/references/vacancies/index" role="modal-remote" class="btn btn-xs  btn-info">Назадь  </a>
                <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
            <h4 class="panel-title">Список </h4>
        </div>
        <div class="panel-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    'vacancy_count',
                ],
            ]) ?>
            <div id="ajaxCrudDatatable">
                <?=GridView::widget([
                    'id'=>'crud-datatable',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-bordered'],
                    'pjax'=>true,
                    // 'rowOptions' => ['class' => 'danger'],
                    'columns' => [
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
                            'attribute'=>'name',
                        ],
                        [
                            'class'=>'\kartik\grid\DataColumn',
                            'attribute'=>'phone',
                        ],
                        [
                            'class'=>'\kartik\grid\DataColumn',
                            'attribute'=>'file',
                            'value' => function($data){
                                return '';
                            }
                        ],
                        [
                            'class'=>'\kartik\grid\DataColumn',
                            'attribute'=>'description',
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'dropdown' => false,
                            'vAlign'=>'middle',
                            'urlCreator' => function($action, $model, $key, $index) { 
                                    return Url::to([$action,'id'=>$key]);
                            },
                            'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
                            'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
                            'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                                              'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                              'data-request-method'=>'post',
                                              'data-toggle'=>'tooltip',
                                              'data-confirm-title'=>'Are you sure?',
                                              'data-confirm-message'=>'Are you sure want to delete this item'], 
                        ],
                    
                    ],
                    'panelBeforeTemplate' => false,
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,
                    'responsiveWrap' => false,
                    'pager' => [
                        'firstPageLabel' => 'Первый',
                        'lastPageLabel'  => 'Последный'
                    ],
                    'panel' => [
                        'headingOptions' => ['style' => 'display: none;'],
                    ]
                ])?>
            </div>
        </div>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>