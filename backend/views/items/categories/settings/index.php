<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset; 
CrudAsset::register($this);
$this->params['breadcrumbs'][] = ['label' => 'Категория', 'url' => ['/items/categories/index']];
// $this->params['breadcrumbs'][] = ['label' => $category_name, 'url' => ['/items/categories/settings', 'id' => $category_id, 'name' => $category_name]];
$this->title = 'Дин. св-ва категории '.$category_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">

            <?php echo  Html::a('Добавить <i class="fa fa-plus"></i>', ['/items/categories/create-settings','id' => $category_id,'name' => $category_name
        ],
                        ['data-pjax'=>0,'title'=> 'Добавить категория','class'=>'btn btn-xs btn-success','data-toggle' => 'tooltip']) 
            ?>

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
                ]
            ])?>
        </div>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",
])?>
<?php Modal::end(); ?>