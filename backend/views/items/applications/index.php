<?php
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use yii\widgets\Pjax;


$this->title = 'Заяавка';
$this->params['breadcrumbs'][] = $this->title;
CrudAsset::register($this);
?>
<style type="text/css" media="screen">
    .panel-body {
        padding: 0 !important;
    }
</style>
<?php Pjax::begin(['enablePushState' => true, 'id' => 'crud-datatable-index']); ?>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <div class="panel-heading-btn">
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
                    <li class="active"><a href="#default-tab-1" data-toggle="tab" aria-expanded="true"><b>Новый</b></a></li>
                    <li class=""><a href="#default-tab-2" data-toggle="tab" aria-expanded="false"><b>В процессе работы</b></a></li>
                    <li class=""><a href="#default-tab-3" data-toggle="tab" aria-expanded="false"><b>Отменено</b></a></li>
                    <li class=""><a href="#default-tab-4" data-toggle="tab" aria-expanded="false"><b>Завершение</b></a></li>
                </ul>
                <div class="tab-content">

                    <div class="tab-pane fade active in" id="default-tab-1">
                        <?= $this->render(
                            'tabs/new.php', [
                                'searchModel' => $searchModel,
                                'dataProvider' => $dataProvider,
                            ]
                        ) ?>
                    </div>
                    <div class="tab-pane fade" id="default-tab-2">
                        <?= $this->render(
                            'tabs/proccess.php', [
                                'searchModel' => $searchModel,
                                'dataProvider' => $proccessProvider,
                            ]
                        )?>
                    </div>
                    <div class="tab-pane fade" id="default-tab-3">
                        <?= $this->render(
                            'tabs/canceled.php', [
                                'searchModel' => $searchModel,
                                'dataProvider' => $cancelProvider,
                            ]
                        )?>
                    </div>
                    <div class="tab-pane fade" id="default-tab-4">
                        <?= $this->render(
                            'tabs/completed.php', [
                                'searchModel' => $searchModel,
                                'dataProvider' => $completedProvider,
                            ]
                        )?>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php Pjax::end(); ?>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>








