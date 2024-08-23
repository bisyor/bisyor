<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\promocodes\PromocodesUsageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title"> Статистика</h4>
    </div>
    <div class="panel-body" style="padding: 0">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#All" data-toggle="tab">Все</a></li>
            <li class=""><a href="#dataSkidka" data-toggle="tab">Скидка</a></li>
            <li class=""><a href="#dataPopolneniya" data-toggle="tab">Пополнения</a></li>
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
                            'after'=>
                                '<div class="clearfix"></div>',
                        ]
                    ])?>
                </div>
            </div>
            <div class="tab-pane" id="dataSkidka">
                    <?=GridView::widget([
                        'id'=>'crud-datatable-skidka',
                        'dataProvider' => $dataSkidka,
                        'filterModel' => $searchModel,
                        'tableOptions' => ['class' => 'table table-bordered'],
                        'pjax'=>true,
                        'columns' => require(__DIR__.'/_col2.php'),
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
                            'after'=>
                                '<div class="clearfix"></div>',
                        ]
                    ])?>
            </div>
            <div class="tab-pane" id="dataPopolneniya">
                    <?=GridView::widget([
                        'id'=>'crud-datatable-popolneniya',
                        'dataProvider' => $dataPopolneniya,
                        'filterModel' => $searchModel,
                        'tableOptions' => ['class' => 'table table-bordered'],
                        'pjax'=>true,
                        'columns' => require(__DIR__.'/_col3.php'),
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
                            'after'=>
                                '<div class="clearfix"></div>',
                        ]
                    ])?>
            </div>
        </div>

    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'options' => [
        'tabindex' => false,
    ],
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
