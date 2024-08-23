<?php
use yii\helpers\Html;
$i = 0;
$this->title = 'Уведомления';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-inverse claims-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Список</h4>
    </div>

    <div class="panel-body" style="padding: 0px;">
        <div style="margin:0;">
            <ul class="nav nav-tabs">
                <?php foreach ($types as $key => $value): ?>
                    <li id="tab-<?=$key?>" ><a href="#default-tab-<?=$key?>" data-toggle="tab"><?=$value?></a></li>
                <?php $i++; endforeach ?>
            </ul>
            <div class="tab-content">
                <?php foreach ($dataProviders as $key => $value): ?>
                    <div class="tab-pane fade active in" id="default-tab-<?=$key?>">
                        <?= $this->render('tab',[
                            'searchModel' => $searchModel,
                            'dataProvider' => $value,
                            'status' => $key,
                            'tab' => 'tab-'.$key
                        ]) ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
<?php 
$this->registerJsFile('/js/cookie.js');
$this->registerJs(<<<JS
    var active_tab = getCookie('tab-alerts');
    if(!active_tab || active_tab == 'undefined'){
        active_tab = 'tab-item';
    }
    
    $("#"+active_tab).addClass('active');
    $(".tab-pane").removeClass('active');
    $("#default-"+active_tab).addClass('active');

    $('.nav li').on('click',function(){
        value = $(this).attr('id');
        setCookie('tab-alerts',value);
        // $.pjax.reload({container:'#crud-datatable-alerts-'+value+'-pjax',async:true});
    });
JS
)
?>