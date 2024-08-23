<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RegionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Регион';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="/references/countries" data-pjax="0" class="btn btn-xs btn-warning">Назад <i class="fa fa-back"></i> </a>
            <?= Html::a('Добавить <i class="fa fa-plus"></i>', ['create','countries_id' => $countries_id], [ 'role' => 'modal-remote', 'title' => 'Добавить', 'class' => 'btn btn-xs btn-success' ]);?>
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Список</h4>
    </div>
    <div class="panel-body">
        <div id="ajaxCrudDatatable">
            <?=GridView::widget([
                'id'=>'crud-datatable',
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-bordered'],
                'pjax'=>true,
                'columns' => require(__DIR__.'/_columns.php'),
                'panelBeforeTemplate' =>    false,
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
                // 'after'=>BulkButtonWidget::widget([
                // 'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Удалить все',
                // ["bulk-delete"] ,
                // [
                // "class"=>"btn btn-danger btn-xs",
                // 'role'=>'modal-remote-bulk',
                // 'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                // 'data-request-method'=>'post',
                // 'data-confirm-title'=>'Подтвердите действие',
                // 'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'
                // ]),
                // ]).
                '<div class="clearfix"></div>',
                ]
            ])?>
        </div>
    </div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "options" => [
        "tabindex" => false,
    ],
    "footer"=>"",
])?>
<?php Modal::end(); ?>
