<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\shops\ShopCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категория';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<?php Pjax::begin(['enablePushState' => false,'id' => 'crud-datatable-pjax'])?>
<div class="panel panel-inverse shop-categories-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">

            <?php echo  Html::a('Добавить <i class="fa fa-plus"></i>', ['/items/categories/create'],
                        ['data-pjax'=>0,'title'=> 'Добавить категория','class'=>'btn btn-xs btn-success','data-toggle' => 'tooltip']) 
            ?>
            <?php  $url = \yii\helpers\Url::to(['/items/categories/sorting','id' => 1]);
                echo \yii\helpers\Html::a('<span class="glyphicon glyphicon-sort"></span>  Сортировка', $url, ['data-pjax'=>'0','title'=>'Сортировка','data-toggle' => 'tooltip','class'=>'btn btn-xs btn-warning']);
            ?>
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            
        </div>
        <h4 class="panel-title">Список</h4>
    </div>
    <div class="panel-body" style="margin: 0px; padding: 0px;">
        <div id="ajaxCrudDatatable" style="margin: 0px; padding: 0px;">
            <table class="table table-bordered" id="category_table" style="width: 100%;">
                <tr>
                    <th style="">
                        № 
                    </th>
                    <th style="width:2%;">
                        
                    </th>
                    <th style="">
                        Названия
                    </th>
                    <th>
                        Объявления
                    </th>
                    <th style="width: 5%; ">
                        Карта 
                    </th>
                    <th style="width: 5%; ">
                        Цена 
                    </th>
                    <!-- <th style="width: 9%; ">
                        Статус 
                    </th>
                    <th style="width: 15%; ">
                        Суб-категория
                    </th> -->
                    <th style="width: 8%;">
                        Действия
                    </th>
                </tr>
                <?= \backend\widgets\CategoryWidget::widget() ?>
            </table>
        </div>
    </div>
</div>
<?php Pjax::end()?>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>

<?php Modal::end(); ?>
