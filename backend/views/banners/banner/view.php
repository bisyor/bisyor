<?php

use yii\widgets\DetailView;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model backend\models\banners\Banners */
$this->title = 'Карточка';
$this->params['breadcrumbs'][] = ['label' => "Баннеры", 'url' => ['/banners/banner']];
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
$first = ''; $second = ''; $third = ''; 
if(Yii::$app->session['banners'] === null || Yii::$app->session['banners'] == '1') $first = 'active';
if(Yii::$app->session['banners'] == '2') $second = 'active';
if(Yii::$app->session['banners'] == '3') $third = 'active';
?> 

<div class="banners-view">
      
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
                    <li class="<?=$first?>"><a href="#default-tab-1" data-toggle="tab" onclick="$.get('/banners/banner/set-tab', {'tab': 'banners', 'value':'1'}, function(data){} );">Информация</a></li>
                    <li class="<?=$second?>"><a href="#default-tab-2" data-toggle="tab" onclick="$.get('/banners/banner/set-tab', {'tab': 'banners', 'value':'2'}, function(data){} );">Слайды</a></li>
                    <li class="<?=$third?>"><a href="#default-tab-3" data-toggle="tab" onclick="$.get('/banners/banner/set-tab', {'tab': 'banners', 'value':'3'}, function(data){} );">Статистика</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade   <?=$first?> in" id="default-tab-1">
                        <?=$this->render('tabs/_information',['model' =>$model])?>
                    </div>
                    <div class="tab-pane fade <?=$second?> in" id="default-tab-2">
                        <?=$this->render('tabs/_items',[
                            'model' => $model,
                            'itemsDataProvider' => $itemsDataProvider,
                        ])?>  
                    </div>  
                    <div class="tab-pane fade <?=$third?> in" id="default-tab-3">
                        <?= $this->render('tabs/_statistic',[
                            'model' => $model,
                            'statisticDataProvider' => $statisticDataProvider,
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
