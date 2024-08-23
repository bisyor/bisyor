<?php 

$first = ''; $second = ''; $third = ''; $foo = '';
if(Yii::$app->session['polls'] === null || Yii::$app->session['polls'] == '1') $first = 'active';
if(Yii::$app->session['polls'] == '2') $second = 'active';
if(Yii::$app->session['polls'] == '3') $third = 'active';
if(Yii::$app->session['polls'] == '4') $foo = 'active';
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
           <b> Опросы</b>
        </h3>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="<?=$first?>">
                    <a href="#default-tab-1" data-toggle="tab" aria-expanded="true" onclick="$.get('/references/polls/set-tab', {'tab': 'polls', 'value':'1'}, function(data){} );"><b>Общие</b></a>
                </li>
                <li class="<?=$second?>">
                    <a href="#default-tab-2" data-toggle="tab" aria-expanded="false" onclick="$.get('/references/polls/set-tab', {'tab': 'polls', 'value':'2'}, function(data){} );"><b>Интеграция</b></a>
                </li>
                <li class="<?=$third?>">
                    <a href="#default-tab-3" data-toggle="tab" aria-expanded="false" onclick="$.get('/references/polls/set-tab', {'tab': 'polls', 'value':'3'}, function(data){} );"><b>Результаты</b></a>
                </li>
                <li class="<?=$foo?>">
                    <a href="#default-tab-4" data-toggle="tab" aria-expanded="false" onclick="$.get('/references/polls/set-tab', {'tab': 'polls', 'value':'4'}, function(data){} );"><b>Пользователи</b></a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade  <?=$first?> in" id="default-tab-1">
                    <?= $this->render('_form_update', [
				        'model' => $model,
				        'values'=>$values,
				    ]) ?>
                </div>
                <div class="tab-pane  <?=$second?> fade in" id="default-tab-2">
                    <?= $this->render('tabs/integration.php', [
                        'model' => $model,
                    ]) ?>
                </div>
                <div class="tab-pane <?=$third?>  fade in" id="default-tab-3">
                    <?= $this->render('tabs/results.php', [
                        'model' => $model,
                    ]) ?>
                </div>
                <div class="tab-pane  <?=$foo?> fade in" id="default-tab-4">
                    <?= $this->render('tabs/users.php', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div> 
        </div>
    </div>
</div>               





                   


