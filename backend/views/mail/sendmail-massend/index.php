<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\mail\SendmailMassendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ' Список рассылок';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="sendmail-massend-index">
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
        <h4 class="panel-title"> Список рассылок</h4>
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
                'striped' => true,
                'condensed' => true,
                'responsive' => true,  
                'responsiveWrap' => false,         
                'panelBeforeTemplate' => false,        
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
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'options' => [
        'tabindex' => false,
    ],
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
