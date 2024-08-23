<?php
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset; 

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\ShopSliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

CrudAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\models\shops\Shops */

// $this->params['breadcrumbs'][] = ['label' => 'Создать', 'url' => ['/shops/shops/index']];
// $this->params['breadcrumbs'][] = "";
?>

<div class="panel panel-inverse shops-view">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title"><?=$title?></h4>
    </div>
    
    <div class="panel-body" style="padding: 0px;">
        <div style="margin:0;">
            <ul class="nav nav-tabs" id="main-nav">
                <li id="tab-1"><a href="#default-tab-1" data-toggle="tab">Основные</a></li>
                <li id="tab-2"><a href="#default-tab-2" data-toggle="tab">Шаблоны</a></li>
                <li id="tab-3"><a href="#default-tab-3" data-toggle="tab">SEO</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="default-tab-1">
                    <?= $this->render('tabs/tab1',[
                        'model' => $model,
                        'langs' => $langs
                    ]) ?>
                </div>

                <div class="tab-pane fade in" id="default-tab-2">
                    <?= $this->render('tabs/tab2',[
                        'model' => $model,
                        'langs' => $langs
                    ]) ?>
                </div>

                <div class="tab-pane fade in" id="default-tab-3">
                    <?= $this->render('tabs/tab3',[
                        'model' => $model,
                        'langs' => $langs
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<?php 
$this->registerJsFile('/js/cookie.js');
$this->registerJs(<<<JS
    var active_tab = getCookie('tab-categories');
    if(!active_tab || active_tab == 'undefined'){
        active_tab = 'tab-1';
    }
    for(i = 0; i<4; i++){
        $("#default-tab-" + i).removeClass('active');
        $("#tab-" + i).removeClass('active');
    }
    $("#"+active_tab).addClass('active');
    $("#default-"+active_tab).addClass('active');

    $('#main-nav li').on('click',function(){
        setCookie('tab-categories',$(this).attr('id'));
    });
JS
)
?>