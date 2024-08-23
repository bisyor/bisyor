<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;


CrudAsset::register($this);
$this->params['breadcrumbs'][] = ['label' => "Счета"];
$this->params['breadcrumbs'][] = 'Операции со счетом пользователя';

$first = ''; $second = ''; $third = ''; $foo = '';
// Yii::$app->session['items-setting'] = 3;

if(Yii::$app->session['payment-tab'] === null || Yii::$app->session['payment-tab'] == '1') $first = 'active';
if(Yii::$app->session['payment-tab'] == '2') $second = 'active';
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
        <h4 class="panel-title">Операции со счетом пользователя</h4>
    </div>
    <div class="panel-body">
	    <ul class="nav nav-tabs">
            <li class="<?= $first?>">
                <a href="#default-tab-1" data-toggle="tab" onclick="$.get('/references/polls/set-tab', {'tab': 'payment-tab', 'value':'1'}, function(data){} );">Пополнить счет</a>
            </li>
            <li class="<?= $second?>">
                <a href="#default-tab-2" data-toggle="tab" onclick="$.get('/references/polls/set-tab', {'tab': 'payment-tab', 'value':'2'}, function(data){} );">Списать со счета</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane  <?= $first?>" id="default-tab-1">
                <?=
                    $this->render('tabs/payment', [
                        'model' => $model,
                        'user_id' => $user_id,
                    ]);
                ?>
            </div>
            <div class="tab-pane  <?= $second?>" id="default-tab-2">
                <?=
                    $this->render('tabs/operation', [
                        'operation' => $operation,
                        'user_id' => $user_id,
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
                    
                    
                    
