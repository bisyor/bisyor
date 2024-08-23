<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Сортировка';
$this->params['breadcrumbs'][] = ['label' => 'Категория', 'url' => ['/shops/shop-categories/index']];
$this->params['breadcrumbs'][] = 'Сортировка';
?>
<div class="scorm-form">
    <?php $form = ActiveForm::begin([
        'options' => 
            [
                'id' => 'sorting-form'
            ]
    ]); ?>
    <input type="hidden" name="sort" id="sort">
    <div class="panel panel-inverse">
        <div class="panel-heading ui-draggable-handle">
            <h3 class="panel-title">Сортировка</h3>                               
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12 ui-sortable" id="sortList">
                        <?php foreach ($list as $key => $value): ?>
                            <div class="panel" data-id='<?=$key?>' style="margin-bottom:0px;" data-sortable-id="ui-general-<?=$key?>">
                                <div class="panel-heading" >
                                    <div class="row">
                                        <div class="col-md-4 offset-md-4">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="" style="border: 1px gray solid;border-radius: 4px; height: 30px; justify-content: center;padding: 5px;font-size: 12px;">
                                                 <i class="glyphicon glyphicon-cog"></i> 
                                                <strong><?=$value['title']?></strong>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <p class="btn btn-md btn-icon btn-inverse pull-right"><i class="fa fa-list"></i></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info pull-right']) ?>
                <?= Html::a('Назад', ['/shops/shop-categories/index'],['class' => 'btn btn-inverse pull-left']) ?>
            </div>
        </div>
        
    </div>
    <?php ActiveForm::end(); ?>    
</div>

<?php 
$this->registerJs(<<<JS

$("#sorting-form").on('submit',function(){
    mouseDown();
});
mouseDown = function(){
    arr = [];
    $( ".panel" ).each(function( index ) {
        val = $( this ).attr('data-id');
        arr.push(val);
    });
    $("#sort").val(arr.join(","));
}
JS
)
?>