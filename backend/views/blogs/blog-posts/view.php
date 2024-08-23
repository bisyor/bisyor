<?php

use yii\widgets\DetailView;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model backend\models\blogs\BlogPosts */
$this->title = 'Карточка';
$this->params['breadcrumbs'][] = ['label' => "Посты", 'url' => ['/blogs/blog-posts']];
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<div class="blog-posts-view">
 
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>  
        <h4 class="panel-title">Карточка </h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#default-tab-1" data-toggle="tab">Информация</a></li>
                    <li class=""><a href="#default-tab-2" data-toggle="tab">Оценки</a></li>
                    <li class=""><a href="#default-tab-3" data-toggle="tab">Теги</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="default-tab-1">
                        <?=$this->render('tabs/_information',['model' =>$model])?>  
                    </div>
                    <div class="tab-pane fade active" id="default-tab-2">
                        <?=$this->render('tabs/_likes',[
                            'model' => $model,
                            'likeDataProvider' => $likeDataProvider,
                        ])?>  
                    </div>
                    <div class="tab-pane fade active" id="default-tab-3">
                        <?=$this->render('tabs/_tags',[
                        'model' => $model,
                        'tagsDataProvider' => $tagsDataProvider,
                    ])?>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "options" => [
        "tabindex" => false,
    ],
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>