<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
// use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\shops\ServicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Услуги';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="panel panel-inverse services-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
        </div>
        <h4 class="panel-title">Список</h4>
    </div>
    <div class="panel-body">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
                'id'=>'crud-datatable',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-bordered'],
                'pjax'=>true,
                'columns' => require(__DIR__.'/_columns.php'),
                'panelBeforeTemplate' => '',
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
                'after'=>'<div class="clearfix"></div>',
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