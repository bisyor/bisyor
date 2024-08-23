<?php
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;

/**
 * @var $this yii\web\View
 * @var $searchModel backend\models\shops\ShopSliderSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $this yii\web\View
 * @var $model backend\models\shops\Shops
 * @var $searchModelClaims backend\models\shops\ShopsClaimsSearch
 * @var $dataProviderClaims backend\models\shops\ShopsClaims
 * @var $searchModelTarifs backend\models\shops\ShopsTariffSearch
 * @var $dataProviderTarifs backend\models\shops\ShopsTariff
 * @var $itemsSearchModel backend\models\items\ItemsSearch
 * @var $itemsDataProvider backend\models\items\Items
 * @var $searchModelSlider backend\models\shops\ShopSliderSearch
 * @var $dataProviderSlider backend\models\shops\ShopSlider
 * @var $searchModelComment backend\models\shops\ShopsCommentSearch
 * @var $dataProviderComment backend\models\shops\ShopsComment
 * @var $searchModelRating backend\models\shops\ShopsRatingSearch
 * @var $dataProviderRating backend\models\shops\ShopsRating
 * @var $searchModelSubscribers backend\models\shops\ShopsSubscribersSearch
 * @var $dataProviderSubscribers backend\models\shops\ShopsSubscribers
 * @var $active_tab
 */

CrudAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['/shops/shops/index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="panel panel-inverse shops-view">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Карточка магазина</h4>
    </div>

    <div class="panel-body" style="padding: 0px;">
        <div style="margin:0;">
            <ul class="nav nav-tabs">
                <li id="tab-1"><a href="#default-tab-1" data-toggle="tab">Общие</a></li>
                <li id="tab-2"><a href="#default-tab-2" data-toggle="tab">Жалобы</a></li>
                <li id="tab-3"><a href="#default-tab-3" data-toggle="tab">Услуги</a></li>
                <li id="tab-4"><a href="#default-tab-4" data-toggle="tab">Абонементы</a></li>
                <li id="tab-5"><a href="#default-tab-5" data-toggle="tab">Объявления(<?=$model->count_items?>)</a></li>
                <li id="tab-6"><a href="#default-tab-6" data-toggle="tab">Слайдеры</a></li>
                <li id="tab-7"><a href="#default-tab-7" data-toggle="tab">Комментарии</a></li>
                <li id="tab-8"><a href="#default-tab-8" data-toggle="tab">Оценка</a></li>
                <li id="tab-9"><a href="#default-tab-9" data-toggle="tab">Подписчики</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="default-tab-1">
                    <?= $this->render('tabs/tab1',[
                        'model' => $model
                    ]) ?>
                </div>

                <div class="tab-pane fade in" id="default-tab-2">
                    <?= $this->render('tabs/tab2',[
                        'searchModel' => $searchModelClaims,
                        'dataProvider' => $dataProviderClaims,
                    ]) ?>
                </div>

                <div class="tab-pane fade in" id="default-tab-3">
                    <?= $this->render('tabs/tab3',[
                        'model' => $model
                    ]) ?>
                </div>

                <div class="tab-pane fade in" id="default-tab-4">
                    <?= $this->render('tabs/tab4',[
                        'model' => $model,
                        'searchModel' => $searchModelTarifs,
                        'dataProvider' => $dataProviderTarifs
                    ]) ?>
                </div>

                <div class="tab-pane fade in" id="default-tab-5">
                    <?= $this->render('tabs/tab5',[
                        'model' => $model,
                        'searchModel' => $itemsSearchModel,
                        'dataProvider' => $itemsDataProvider,
                    ]) ?>
                </div>

                <div class="tab-pane fade in" id="default-tab-6">
                    <?= $this->render('tabs/tab6',[
                        'model' => $model,
                        'searchModel' => $searchModelSlider,
                        'dataProvider' => $dataProviderSlider
                    ]) ?>
                </div>
                <div class="tab-pane fade in" id="default-tab-7">
                    <?= $this->render('tabs/tab7',[
                        'model' => $model,
                        'searchModelComment' => $searchModelComment,
                        'dataProviderComment' => $dataProviderComment
                    ]) ?>
                </div>
                <div class="tab-pane fade in" id="default-tab-8">
                    <?= $this->render('tabs/tab8',[
                        'model' => $model,
                        'searchModelRating' => $searchModelRating,
                        'dataProviderRating' => $dataProviderRating
                    ]) ?>
                </div>
                <div class="tab-pane fade in" id="default-tab-9">
                    <?= $this->render('tabs/tab9',[
                        'model' => $model,
                        'searchModelSubscribers' => $searchModelSubscribers,
                        'dataProviderSubscribers' => $dataProviderSubscribers
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
    var active_tab = getCookie('tab');
    
    if(!active_tab || active_tab == 'undefined'){
        active_tab = 'tab-1';
    }
    if('$active_tab' != ''){
        active_tab = '$active_tab';
    }
    $("#"+active_tab).addClass('active');
    $(".tab-pane").removeClass('active');
    $("#default-"+active_tab).addClass('active');

    $('.nav li').on('click',function(){
        setCookie('tab',$(this).attr('id'));
    });
JS
)
?>