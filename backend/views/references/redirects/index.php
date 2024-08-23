<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

$this->params['breadcrumbs'][] = ['label' => "SEO"];
$this->params['breadcrumbs'][] = 'Редиректы';
CrudAsset::register($this);
?>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="/references/redirects/create" role="modal-remote" class="btn btn-xs btn-success">Добавить <i class="fa fa-plus"></i> </a>
            <a href="/references/redirects/change-base" role="modal-remote" class="btn btn-xs btn-warning">Поправить базу<i class="glyphicon glyphicon-pencil"></i> </a>
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Редиректы </h4>
    </div>
    <div class="panel-body">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-bordered'],
            'pjax'=>true,
            // 'rowOptions' => ['class' => 'danger'],
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
            ]
            ])?>
        </div>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
