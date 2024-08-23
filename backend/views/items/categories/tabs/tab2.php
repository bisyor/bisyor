<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
$i = 0;
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'create-template-category-form',
    ]
]); ?>

<?= $form->field($model, 'type')->hiddenInput(['value' => \backend\models\items\Categories::TYPE_TEMPLATE ])->label(false) ?>
<div class="panel-body" style="padding: 0px;">
    <ul class="nav nav-pills" id="tab-2-nav">
        <?php foreach($langs as $lang):?>
            <li class="<?= $i == 0 ? 'active' : '' ?>">
                <a data-toggle="tab" href="#<?=$lang->url?>-tab-2"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
            </li>
        <?php $i++; endforeach;?>
    </ul>
    <hr>
    <?php
		$templateInput = '<div class="row"><div class="col-md-2">
	            {label}</div><div class="col-md-9">{input}{hint}{error}</div></div>
	            ';
        $templateCheckbox = '<div class="row"><div class="col-md-2">
                        {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-5">{hint}</div></div>
                        ';
	?>
	<div class="row">
		<div class="col-md-9">
			<?= $form->field($model, 'tpl_title_enabled',['template' => $templateCheckbox])->widget(CheckboxX::classname(),[
	                'pluginOptions'=>[
	                        'threeState'=>false
	                    ],
	                'options'=>[
	                        'onchange' => "
	                            element = $(this).parent('div').parent('div').next().children('div');
	                            value = $(this).val();
	                            if(value == 1){
						            $('.inputs').prop('readonly',true);
	                                element.html('Включено');
	                            }else{
						            $('.inputs').prop('readonly',false);
	                                element.html('Выключено');
	                            }
	                        "
	                    ]
	        ])->hint(($model->tpl_title_enabled == 1) ? 'Включено' : 'Выключено'); ?>
		    <div class="row">
		    	<div class="col-md-2 offset-md-2">
		    	</div>
		    	<div class="col-md-7">
		    		<p>
		    			В случае если включено и шаблоны заголовка не указаны, будут применяться настройки из категорий выше, первый найденный непустой шаблон отображаемый под полями ввода
		    		</p>
		    	</div>
		    </div>
		    <div class="tab-content" id="tab-2-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
                <div id="ru-tab-2" class="tab-pane active in">
           			<?= $form->field($model, "tpl_title_view",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;','class'=>'form-control inputs'])?>
					<?= $form->field($model, "tpl_title_list",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;','class'=>'form-control inputs'])?>
					<?= $form->field($model, "tpl_descr_list",['template' => $templateInput])->textarea(['rows' => 7,'class'=>'form-control inputs'])?> 
                </div>
                <?php $i = 0; foreach($langs as $lang): ?>
                    <?php if ($lang->url == 'ru') continue; ?>
                    <div id="<?=$lang->url?>-tab-2" class="tab-pane fade in">
                        <?= $form->field($model, 'translation_tpl_title_view['.$lang->url.']',['template' => $templateInput])->textInput(['value' => isset($model->translation_tpl_title_view[$lang->url]) ? $model->translation_tpl_title_view[$lang->url] : null,'class'=>'form-control inputs'])?>
                        <?= $form->field($model, 'translation_tpl_title_list['.$lang->url.']',['template' => $templateInput])->textInput(['value' => isset($model->translation_tpl_title_list[$lang->url]) ? $model->translation_tpl_title_list[$lang->url] : null,'class'=>'form-control inputs'])?>
                        <?= $form->field($model, 'translation_tpl_descr_list['.$lang->url.']',['template' => $templateInput])->textarea(['rows' => 7,'class'=>'form-control inputs','value' => isset($model->translation_tpl_descr_list[$lang->url]) ? $model->translation_tpl_descr_list[$lang->url] : null])?>
                    </div>
                <?php $i++; endforeach;?>
            </div>
		</div>

		<div class="col-md-3" >
			<div style="max-height: 330px;overflow-y: auto;">
				<?php 
			        $tags = [
			            'Марка' => '{491}',
			            'Пробег' => '{112}',
			            'Год выпуска' => '{113}',
			            'Объём двигателя' => '{114}',
			            'Цена' => '{price}',
			            'Категория объявления' => '{category}',
			            'Родительская категория объявления' => '{category-parent}',
			            'Категория уровня N = 1 .. 4' => '{category-N}',
			            'Описания - первые 100 символов(description.N для изменения количество)' => '{description}',
			            'Город' => '{geo.city}',
			            'Город со сколением' => '{geo.city.in}',
			            'Станция метро' => '{geo.metro}',
			            'Район города' => '{geo.district}',
			        ];
			    ?>
			    <?php foreach ($tags as $key => $value): ?>
			    	<button class="btn btn-link tags" type="button"><?=$value?></button>
			    	<br>
			    	<p class="muted" style="margin-left: 10px;"><?=$key?></p>
			    <?php endforeach ?>
			</div>
			<hr>
	    	<button class="btn btn-link razdelitel" type="button">+ добавить разделитель </button>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-10">
			<p class="text-right m-b-0">
			    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name' => 'submit-button', 'value' => \backend\models\items\Categories::TYPE_TEMPLATE]) ?>
			    <button class="btn btn-inverse" type="button" onClick="history.back();">Назад</button>
			</p>
		</div>
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
    $(".razdelitel").on("click", function(){
    	if(!prevFocus) return;
    	oldValue = prevFocus.val();
        value = oldValue + '|';
        prevFocus.val(value);
	});

    $(".tags").on("click",function(){
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
    $('#categories-tpl_title_enabled').trigger('change')
JS
)
?>