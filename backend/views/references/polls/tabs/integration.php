<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;

$integration = $model->getIntgerration();
$ramka = "gray"; $fon = "white";
if($integration->frame_color != null) $ramka = $integration->frame_color; 
if($integration->background_color != null) $fon = $integration->background_color; 
?>
<div class="panel-body" style="margin: 10px 25px;">
    <?php $form = ActiveForm::begin(['action' => ['integration','id'=>$model->id]]); ?>

    	<div class="row">
    		<div class="col-md-2">
                <b><?=$integration->attributeLabels()['type'];?></b>
    		</div>
    		<div class="col-md-3">
    			<?= $form->field($integration, 'type')->dropDownList($integration->getType(),[])->label(false)?>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-2">
                <b><?=$integration->attributeLabels()['language_id'];?></b>
    		</div>
    		<div class="col-md-3">
    			<?= $form->field($integration, 'language_id')->dropDownList($integration->getLangList(),[])->label(false)?>
    		</div>
    	</div>
    	<div class="row">
            <div class="col-md-2">
                <b><?=$integration->attributeLabels()['frame'];?></b>
            </div>
            <div class="col-md-1">
                <?= $form->field($integration, 'frame')->checkbox(['id'=>'frame','label'=>'без цвета']); ?>
            </div>
            <div class="col-md-2"  id="frameLabel" <?=$integration->frame != 1 ? 'style="display:none"' : ''?>>
                <?= $form->field($integration, 'frame_color')->widget(ColorInput::classname(), [
                    'options' => ['placeholder' => 'Выберите цвет...',
                        'onchange' => 'var color = $(this).val(); $("#ramka").css({ "border":"1px solid "+ color});'
                    ],
                ])->label(false); ?>
            </div>
        </div>
    	<div class="row">
    		<div class="col-md-2">
                <b><?=$integration->attributeLabels()['background'];?></b>
    		</div>
    		<div class="col-md-1">
    			<?= $form->field($integration, 'background')->checkbox(['id'=>'background','label'=>'без цвета']); ?>
    		</div>
    		<div class="col-md-2"  id="backgroundLabel" <?=$integration->background != 1 ? 'style="display:none"' : ''?>>
    			<?= $form->field($integration, 'background_color')->widget(ColorInput::classname(), [
	                'options' => ['placeholder' => 'Выберите цвет...',
                     'onchange' => 'var color = $(this).val(); $("#ramka").css({ "background-color": color});'
                ],
	            ])->label(false); ?>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-2">
                <b><?=$integration->attributeLabels()['result'];?></b>
    		</div>
    		<div class="col-md-1">
    			<?= $form->field($integration, 'result')->checkbox(['id'=>'result','label'=>'без цвета']); ?>
    		</div>
    		<div class="col-md-2"  id="resultLabel" <?=$integration->result != 1 ? 'style="display:none"' : ''?>>
    			<?= $form->field($integration, 'result_color')->widget(ColorInput::classname(), [
	                'options' => ['placeholder' => 'Выберите цвет...'],
	            ])->label(false); ?>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-md-2"><b>Пример</b></div>
    		<div class="col-md-6" id="ramka" style="border: 1px solid <?=$ramka?>; padding:20px 0 20px 40px; background-color: <?= $fon;?>">
    			<h4 class="block">Вам нравится наш сайт?</h4>
				<p>Да</p>
				<p>Нет</p>
				<button type="" class="btn btn-default">Ответить</button>
    		</div>
    	</div>
    	<br><br>
	  	<div class="form-group">
	        <?= Html::submitButton( 'Сохранить', ['class' => 'btn btn-primary']) ?>
            <?= Html::a( 'Отмена', ['index'],['class' => 'btn btn-inverse']) ?>
	    </div>
     <?php ActiveForm::end(); ?>
</div>

<?php 
$this->registerJs(<<<JS

    $("#frame").on('click', function(e){ 
        if(e.target.checked) $('#frameLabel').show(200);
        else $('#frameLabel').hide();
    });

    $("#background").on('click', function(e){ 
        if(e.target.checked) $('#backgroundLabel').show(200);
        else $('#backgroundLabel').hide();
    });

    $("#result").on('click', function(e){ 
        if(e.target.checked) $('#resultLabel').show(200);
        else $('#resultLabel').hide();
    });

JS
);
?>