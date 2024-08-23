<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\promocodes\PromocodesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Промокоды';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?= Html::a('Добавить <i class="fa fa-plus"></i>', ['create'],
                ['role'=>'modal-remote','title'=> 'Добавить','class'=>'btn btn-xs btn-success']);?>
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Промокоды </h4>
    </div>
    <div class="panel-body" style="padding: 0">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#All" data-toggle="tab">Все</a></li>
            <li class=""><a href="#dataActive" data-toggle="tab">Активные</a></li>
            <li class=""><a href="#dataDeactive" data-toggle="tab">Неактивные</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="All">
                <div id="ajaxCrudDatatable">
                    <?=GridView::widget([
                        'id'=>'crud-datatable',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'tableOptions' => ['class' => 'table table-bordered'],
                        'pjax'=>true,
                         'rowOptions' => ['class' => 'warning'],
                        'columns' => require(__DIR__.'/_columns.php'),
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
                            'after'=> '<div class="clearfix"></div>',
                        ]
                    ])?>
                </div>
            </div>
            <div class="tab-pane" id="dataActive">
                <div id="ajaxCrudDatatable">
                    <?=GridView::widget([
                        'id'=>'crud-datatable-active',
                        'dataProvider' => $dataActive,
                        'filterModel' => $searchModel,
                        'tableOptions' => ['class' => 'table table-bordered'],
                        'pjax'=>true,
                         'rowOptions' => ['class' => 'success'],
                        'columns' => require(__DIR__.'/_columns_aktiv.php'),
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
                            'after'=> '<div class="clearfix"></div>',
                        ]
                    ])?>
                </div>
            </div>
            <div class="tab-pane" id="dataDeactive">
                <div id="ajaxCrudDatatable">
                    <?=GridView::widget([
                        'id'=>'crud-datatable-deactive',
                        'dataProvider' => $dataDeactive,
                        'filterModel' => $searchModel,
                        'tableOptions' => ['class' => 'table table-bordered'],
                        'pjax'=>true,
                         'rowOptions' => ['class' => 'danger'],
                        'columns' => require(__DIR__.'/_columns_neaktiv.php'),
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
                            'after'=> '<div class="clearfix"></div>',
                        ]
                    ])?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'options' => [
      'tabindex' => false
    ],
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
