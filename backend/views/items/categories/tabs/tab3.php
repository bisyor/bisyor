<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

 ?>
<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'create-seo-category-form',
    ]
]); ?>

<?= $form->field($model, 'type')->hiddenInput(['value' => \backend\models\items\Categories::TYPE_SEO ])->label(false) ?>

<div class="panel-body" style="padding: 0px;">
    <ul class="nav nav-pills" id="tab-1-nav">
        <li class="active" id="tab-1-1" onclick="$(':focus').blur();$('#w0').trigger('change')"><a href="#default-tab-1-1" data-toggle="tab">Поиск в категории</a></li>
        <li id="tab-1-2" onclick="$(':focus').blur();$('#w1').trigger('change')"><a href="#default-tab-1-2" data-toggle="tab">Просмотр объявления</a></li>
    </ul>
    <hr>
    <div class="tab-content" id="tab-1-content" >
        <div class="tab-pane active in" id="default-tab-1-1">
            <?= $this->render('tab3-1',[
                'model' => $model,
                'langs' => $langs,
                'form' => $form,
            ]) ?>
        </div>

        <div class="tab-pane fade in" id="default-tab-1-2">
            <?= $this->render('tab3-2',[
                'model' => $model,
                'langs' => $langs,
                'form' => $form,
            ]) ?>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-md-10">
		<p class="text-right m-b-0">
		    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name' => 'submit-button', 'value' => \backend\models\items\Categories::TYPE_SEO]) ?>
		    <button class="btn btn-inverse" type="button" onClick="history.back();">Назад</button>
		</p>
	</div>
</div>
<?php ActiveForm::end(); ?>


<?php 
$this->registerJs(<<<JS
    var prevFocus;

    $("input").on("focus",function() {
        prevFocus = $(this);
    });

    $("textarea").on("focus",function() {
        prevFocus = $(this);
    });

    $(".tag").on("click",function(){
    	if(!prevFocus) return;
        oldValue = prevFocus.val();
        arr = oldValue.split(' ');
        newValue = $(this).html();
        if(arr.indexOf(newValue) != -1){
            new_arr = arr.splice(arr.indexOf(newValue),1);
        }else{
            arr.push(newValue);
        }
        value = arr.join(' ');
        prevFocus.val(value);
    });

    $("div").each(function( index ) {
       $( this ).removeClass('form-group');
    });

JS
)
?>