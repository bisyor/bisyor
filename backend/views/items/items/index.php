<?php
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset; 
use yii\widgets\Pjax;
use yii\helpers\Html;

CrudAsset::register($this);
$i = 0;
$this->title = 'Объявления';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-inverse claims-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?php echo  Html::a('Добавить <i class="fa fa-plus"></i>', ['create'],
                        ['data-pjax'=>0,'title'=> 'Добавить','class'=>'btn btn-xs btn-success','data-toggle' => 'tooltip']); 
            ?>
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
                <?php foreach ($statuses as $key => $value): ?>
                    <li id="tab-<?=$key?>" ><a href="#default-tab-<?=$key?>" data-toggle="tab"><?=$value['name'].((\backend\models\items\Items::STATUS_MODERATING == $key) ? ' (' . $itemsCountModeration . ')' : '')?></a></li>
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

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>

<?php Modal::end(); ?>

<?php 
$this->registerJsFile('/js/cookie.js');
$this->registerJs(<<<JS

    $(document).on('ready pjax:success', function(){
        // ...
    });

    var active_tab = getCookie('tab-items');
    if(!active_tab || active_tab == 'undefined'){
        active_tab = 'tab-0';
    }
    
    $("#"+active_tab).addClass('active');
    $(".tab-pane").removeClass('active');
    $("#default-"+active_tab).addClass('active');

    $('.nav li').on('click',function(){
        value = $(this).attr('id');
        setCookie('tab-items',value);
        // $.pjax.reload({container:'#crud-datatable-items-'+value+'-pjax',async:true});
    });

    refresh = function(){
        $("[name^='ItemsSearch']").each(function (index) {
            $(this).val('');
            $(this).val(null).trigger('change');
        });
    }
    sendRequest = function(val){
        var form = $("#search-form-" + val);
        $.ajax({
            type: 'post',
            url: '/items/items/index',
            data: form.serialize()+"&tab="+val,
            success: function (data) {
                $('#default-tab-' + val).html(data);
            }
        });
    }
JS
)
?>