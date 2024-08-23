<?php
use johnitvn\ajaxcrud\CrudAsset; 


/* @var $this yii\web\View */
/* @var $model backend\models\Users */

$this->title = ' Карточка пользователия';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Пользователи </h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#default-tab-1" data-toggle="tab">Профиль</a></li>
                    <li class=""><a href="#default-tab-2" data-toggle="tab">Объявления</a></li>
                    <li class=""><a href="#default-tab-3" data-toggle="tab">Магазин</a></li>
                    <li class=""><a href="#default-tab-4" data-toggle="tab">Лимиты</a></li>
                    <li class=""><a href="#default-tab-5" data-toggle="tab">Баланс</a></li>
                    <li class=""><a href="#default-tab-6" data-toggle="tab">История пользователя</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="default-tab-1">
                        <?=$this->render('/users/users/moderator/_profil_moderator',['model' =>$model])?>
                    </div>
                    <div class="tab-pane fade" id="default-tab-2">
                        <?=$this->render('/users/users/tabs/_items',['searchItems' => $searchItems, 'dataItems' => $dataItems])?>
                    </div>
                    <div class="tab-pane" id="default-tab-3">
                        <?=$this->render('/users/users/tabs/_shops',['searchShops' => $searchShops, 'dataShops' =>$dataShops])?>
                    </div>
                    <div class="tab-pane" id="default-tab-5">
                        <?=$this->render('/users/users/tabs/_balance', ['searchBalance' => $searchBalance, 'dataBalance' => $dataBalance])?>
                    </div>
                    <div class="tab-pane" id="default-tab-6">
                        <?=$this->render('/users/users/tabs/_history',['dataProvider' =>$dataProvider])?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
