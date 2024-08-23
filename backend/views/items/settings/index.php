<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;


CrudAsset::register($this);
$this->params['breadcrumbs'][] = ['label' => "Объявления"];
$this->params['breadcrumbs'][] = 'Настройки';

$first = ''; $second = ''; $third = ''; $foo = '';
// Yii::$app->session['items-setting'] = 3;

if(Yii::$app->session['items-setting'] === null || Yii::$app->session['items-setting'] == '1') $first = 'active';
if(Yii::$app->session['items-setting'] == '2') $second = 'active';
if(Yii::$app->session['items-setting'] == '3') $third = 'active';
if(Yii::$app->session['items-setting'] == '4') $foo = 'active';
// echo "<pre>";
// print_r(Yii::$app->session['items-setting']); die;

?>
<div class="panel panel-inverse" data-sortable-id="ui-typography-14">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand" ><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload" ><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse" ><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove" ><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Настройки</h4>
    </div>
    <div class="panel-body">
	    <ul class="nav nav-tabs">
            <li class="<?= $first?>">
                <a href="#default-tab-1" data-toggle="tab" onclick="$.get('/references/polls/set-tab', {'tab': 'items-setting', 'value':'1'}, function(data){} );">Общие настройки</a>
            </li>
            <li class="<?= $second?>">
                <a href="#default-tab-2" data-toggle="tab" onclick="$.get('/references/polls/set-tab', {'tab': 'items-setting', 'value':'2'}, function(data){} );">Спам фильтр</a>
            </li>
            <li class="<?= $third?>">
                <a href="#default-tab-3" data-toggle="tab" onclick="$.get('/references/polls/set-tab', {'tab': 'items-setting', 'value':'3'}, function(data){} );">Поделиться</a>
            </li>
            <li class="<?= $foo?>">
                <a href="#default-tab-4" data-toggle="tab" onclick="$.get('/references/polls/set-tab', {'tab': 'items-setting', 'value':'4'}, function(data){} );">Поисковые фразы</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane  <?= $first?>" id="default-tab-1">
                <?=
                    $this->render('general', [
                        'model' => $model,
                    ]);
                ?>
            </div>
            <div class="tab-pane  <?= $second?>" id="default-tab-2">
                <div class="panel panel-inverse user-index">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="/references/black-list/create" role="modal-remote" class="btn btn-xs  btn-success">Добавить <i class="fa fa-plus"></i> </a>
                            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Список </h4>
                    </div>
                    <div class="panel-body">
                        <div id="ajaxCrudDatatable">
                            <?=GridView::widget([
                            'id'=>'crud-datatable',
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'tableOptions' => ['class' => 'table table-bordered'],
                            'pjax'=>true,
                            // 'rowOptions' => ['class' => 'danger'],
                            'columns' => require(__DIR__.'/_black_columns.php'),
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
            </div>
            <div class="tab-pane  <?= $third?>" id="default-tab-3">
                   <?=
                        $this->render('share', [
                        'share' => $share,
                        ]);
                    ?>
            </div>
            <div class="tab-pane  <?= $foo?>" id="default-tab-4">
               <div class="panel panel-inverse user-index">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="/references/wordforms/create" role="modal-remote" class="btn btn-xs  btn-success">Добавить <i class="fa fa-plus"></i> </a>
                            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Список </h4>
                    </div>
                    <div class="panel-body">
                        <div id="ajaxCrudDatatable">
                            <?=GridView::widget([
                            'id'=>'crud-datatable-word',
                            'dataProvider' => $wordDataProvider,
                            'filterModel' => $wordSearchModel,
                            'tableOptions' => ['class' => 'table table-bordered'],
                            'pjax'=>true,
                            // 'rowOptions' => ['class' => 'danger'],
                            'columns' => require(__DIR__.'/_word_columns.php'),
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
            </div>
        </div>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
                    
                    
                    
