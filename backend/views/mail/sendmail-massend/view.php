<?php

use johnitvn\ajaxcrud\CrudAsset;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\mail\SendmailMassend */
$this->title = 'Список рассылок';
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);
?>
<div class="sendmail-massend-index">
    <div class="panel panel-inverse user-index">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <?= Html::a('Назад <i class="fa fa-back"></i>', ['/mail/sendmail-massend/'],
                    ['title'=> 'Назад','class'=>'pull-left btn-xs btn btn-danger'])?>
            </div>
            <h4 class="panel-title">Список рассылок</h4>
        </div>
        <div class="panel-body">
            <div id="ajaxCrudDatatable">
                <?=GridView::widget([
                    'id'=>'crud-datatable',
                    'dataProvider' => $dataProvider,
                    'filterModel' => false,
                    'tableOptions' => ['class' => 'table table-bordered'],
                    'pjax'=>true,
                    'columns' => require(__DIR__.'/_column_view.php'),
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