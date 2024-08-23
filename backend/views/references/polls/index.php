<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;


$this->title = 'Опросы';
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);
?>
<style type="text/css" media="screen">
    .panel-body {
     padding: 0 !important; 
}
</style>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="/references/polls/create" data-pjax="0" class="btn btn-xs  btn-success"> <i class="fa fa-plus"></i> Добавить </a>
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>

        </div>
        <h3 class="panel-title">
           <b> Опросы</b>
        </h3>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#default-tab-1" data-toggle="tab" aria-expanded="true"><b>Все</b></a></li>
                <li class=""><a href="#default-tab-2" data-toggle="tab" aria-expanded="false"><b>Активные</b></a></li>
                <li class=""><a href="#default-tab-3" data-toggle="tab" aria-expanded="false"><b>Завершенные</b></a></li>
                <li class=""><a href="#default-tab-4" data-toggle="tab" aria-expanded="false"><b>Черновики</b></a></li>
            </ul>
            <div class="tab-content">
                
                <div class="tab-pane fade active in" id="default-tab-1">
                    <?= $this->render(
                        'tabs/all.php', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $dataProvider,
                        ]
                    ) ?> 
                </div>
                <div class="tab-pane fade" id="default-tab-2">
                    <?= $this->render(
                        'tabs/actively.php', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $activeProvider,
                        ]
                    )?> 
                </div>
                <div class="tab-pane fade" id="default-tab-3">
                    <?= $this->render(
                        'tabs/completed.php', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $completedProvider,
                        ]
                    )?> 
                </div>
                <div class="tab-pane fade" id="default-tab-4">
                    <?= $this->render(
                        'tabs/chernovek.php', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $chernovekProvider,
                        ]
                    )?> 
                </div>

            </div> 
        </div>
    </div>
</div>               





                   


