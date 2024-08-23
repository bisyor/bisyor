<?php
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\ContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $panelBeforeTemplate */

$this->title = 'Контакты';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
$panelBeforeTemplate = "";
$panelBeforeTemplate .= \backend\widgets\BulkButtonWidget::widget([
    'buttons'=>\yii\helpers\Html::a('Удалить',
        ["bulk-delete"] ,
        [
            "class"=>"btn btn-danger btn-xs",
            'role'=>'modal-remote-bulk',
            'data-confirm'=>false, 'data-method'=>false,
            'data-request-method'=>'post',
            'data-confirm-title'=>'Подтвердите действие',
            'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?'
        ]),
]);
$panelBeforeTemplate .= '<div class="clearfix"></div>';

$first = ''; $second = ''; $third = ''; $foo = ''; $five = '';
if(Yii::$app->session['contacts'] === null || Yii::$app->session['contacts'] == '1') $first = 'active';
if(Yii::$app->session['contacts'] == '2') $second = 'active';
if(Yii::$app->session['contacts'] == '3') $third = 'active';
if(Yii::$app->session['contacts'] == '4') $foo = 'active';
if(Yii::$app->session['contacts'] == '5') $five = 'active';
?>
<style type="text/css" media="screen">
    .panel-body {
     padding: 0 !important; 
}
</style>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h3 class="panel-title">
           <b>Список</b>
        </h3>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="<?=$first?>"><a href="#default-tab-1" data-toggle="tab" aria-expanded="true"  onclick="$.get('/references/contacts/set-tab', {'tab': 'contacts', 'value':'1'}, function(data){} );"><b>Ошибка на сайте</b></a></li>
                <li class="<?=$second?>"><a href="#default-tab-2" data-toggle="tab" aria-expanded="false" onclick="$.get('/references/contacts/set-tab', {'tab': 'contacts', 'value':'2'}, function(data){} );"><b>Технический вопрос</b></a></li>
                <li class="<?=$third?>"><a href="#default-tab-3" data-toggle="tab" aria-expanded="false" onclick="$.get('/references/contacts/set-tab', {'tab': 'contacts', 'value':'3'}, function(data){} );"><b>Предложение</b></a></li>
                <li class="<?=$foo?>"><a href="#default-tab-4" data-toggle="tab" aria-expanded="false" onclick="$.get('/references/contacts/set-tab', {'tab': 'contacts', 'value':'4'}, function(data){} );"><b>Другие вопрос</b></a></li>
                <li class="<?=$five?>"><a href="#default-tab-5" data-toggle="tab" aria-expanded="false" onclick="$.get('/references/contacts/set-tab', {'tab': 'contacts', 'value':'5'}, function(data){} );"><b>Все</b></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade <?=$first?>  in" id="default-tab-1">
                    <?= $this->render(
                        'first.php', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $firstDataProvider,
                            'panelBeforeTemplate' => $panelBeforeTemplate,
                        ]
                    ) ?> 
                </div>
                <div class="tab-pane fade <?=$second?> in " id="default-tab-2">
                    <?= $this->render(
                        'second.php', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $secondDataProvider,
                            'panelBeforeTemplate' => $panelBeforeTemplate,
                        ]
                    )?> 
                </div>
                <div class="tab-pane fade <?=$third?> in" id="default-tab-3">
                    <?= $this->render(
                        'third.php', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $sentenceDataProvider,
                            'panelBeforeTemplate' => $panelBeforeTemplate,
                        ]
                    )?>
                </div>
                <div class="tab-pane fade <?=$foo?> in" id="default-tab-4">
                    <?= $this->render(
                        'foth.php', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $thirdDataProvider,
                            'panelBeforeTemplate' => $panelBeforeTemplate,
                        ]
                    )?> 
                </div>
                <div class="tab-pane fade <?=$five?> in" id="default-tab-5">
                    <?= $this->render(
                        'five.php', [
                            'searchModel' => $searchModel,
                            'dataProvider' => $allDataProvider,
                            'panelBeforeTemplate' => $panelBeforeTemplate,
                        ]
                    )?>
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
