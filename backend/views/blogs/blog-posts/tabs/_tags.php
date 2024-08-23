<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;

?>
<a href="/blogs/blog-posts/add-tag?id=<?=$model->id?>" role="modal-remote" class="btn btn-xs btn-success">Добавить <i class="fa fa-plus"></i> </a>
<br>
<br>
<?=GridView::widget([
    'id'=>'tags-datatable',
    'dataProvider' => $tagsDataProvider,
    //'filterModel' => $searchShops,
    'pjax'=>true,
    'panelBeforeTemplate' => false,
    'columns' => require(__DIR__.'/_tag_columns.php'),
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'responsiveWrap' => false,
    'panel' => false
])?>

