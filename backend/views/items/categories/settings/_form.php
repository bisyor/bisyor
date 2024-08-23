<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
use unclead\multipleinput\MultipleInput;
use backend\models\items\CategoriesDynprops;
$i = 0;
$start = CategoriesDynprops::getStartId();
$old_ids = \yii\helpers\ArrayHelper::getColumn($variants,'id');  
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'create-settings-category-form',
    ]
]); ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title"><?=$this->title?></h4>
    </div>
    <div class="panel-body" style="padding-left:40px; ">
    <ul class="nav nav-pills" id="tab-2-nav" >
        <?php foreach($langs as $lang):?>
            <li class="<?= $i == 0 ? 'active' : '' ?>">
                <a data-toggle="tab" onclick="changeTab($(this))" data-id="<?=$lang->url?>" href="#<?=$lang->url?>-tab-2"><?=(isset(explode('-',$lang->name)[1]) ? explode('-',$lang->name)[1] : $lang->name)?></a>
            </li>
        <?php $i++; endforeach;?>
    </ul>
    <hr>
    <?php
		$templateInput = '<div class="row"><div class="col-md-2">
	            {label}</div><div class="col-md-5">{input}{hint}{error}</div></div>
	            ';
        $templateCheckbox = '<div class="row"><div class="col-md-1">
                        {label}</div><div class="col-md-1">{input}{error}</div><div class="col-md-5">{hint}</div></div>
                        ';
	?>
	<div class="row">
		<div class="row">
			<div class="col-md-2">
				<label><?=$model->getAttributeLabel('type')?></label>
			</div>
			<div class="col-md-5">
				<?= $form->field($model, "type")->dropDownList($model->getTypeList(),
					[
					'onchange' => 'changeDefault();',
					'disabled' => !($model->isNewRecord)
					])->label(false)?>
			</div>
          			<div class="col-md-2" id="only-type6">
				<?= $form->field($model, 'parent')->widget(CheckboxX::classname(), 
                    [
                    	'autoLabel' => true,
                        'labelSettings' => [
                            'position' => CheckboxX::LABEL_RIGHT,
                        ],
                    	'pluginOptions'=>[
                        'threeState'=>false
                    ]
                ])->label(false) ?>
            </div>
		</div>
        <div class="row">
            <div class="col-md-2">
                <label><?=$model->getAttributeLabel('data_field')?></label>
            </div>
            <div class="col-md-5">
                <?= $form->field($model, "data_field")->dropDownList($model->getDataField(),
                    [
                        'onchange' => 'changeDefault();',
                        'disabled' => !($model->isNewRecord)
                    ])->label(false)?>
            </div>
        </div>
	    <div class="tab-content" id="tab-2-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
            <div id="ru-tab-2" class="tab-pane active in  tab-1" data-id="ru">
       			<?= $form->field($model, "title",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;','class'=>'form-control inputs'])?>
       			<?= $form->field($model, "description",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;','class'=>'form-control inputs'])?>
            </div>
            <?php $i = 0; foreach($langs as $lang): ?>
                <?php if ($lang->url == 'ru') continue; ?>
                <div id="<?=$lang->url?>-tab-2" class="tab-pane fade in tab-1" data-id="<?=$lang->url?>">
                    <?= $form->field($model, "translation_title[".$lang->url."]",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;','class'=>'form-control inputs'])?>
       				<?= $form->field($model, "translation_description[".$lang->url."]",['template' => $templateInput])->textInput(['maxlength' => true,'style'=>'margin-bottom:0px !important;','class'=>'form-control inputs'])?>
                </div>
            <?php $i++; endforeach;?>
        </div>
        <div class="default-value">
        	<div class="row">
	        	<div class="col-md-2">
					<label><?=$model->getAttributeLabel('default_value_typ1')?></label>
	        	</div>
	        	<div class="col-md-5">
    			    <div class="type1" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;">
			       			<?= $form->field($model, "default_value_typ1")->textInput()->label(false)?>
			        </div>
			        <div class="type2" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px; display: none;">
		       			<?= $form->field($model, "default_value_typ2")->textarea(['rows' => 4])->label(false)?>
			        </div>
			        <div class="type4" style="display: none;">
			        	<?= $form->field($model, 'default_value_typ4')->radioList(
					            $model->getParent(),
					            [
					                'separator' => "&nbsp;&nbsp;&nbsp;&nbsp;",
					            ]
					        )->label(false) ?>
				    </div>
					<div class="type5" style="display: none;">
				    	<?= $form->field($model, 'default_value_typ5')->widget(CheckboxX::classname(), 
		                    [
		                    	'pluginOptions'=>[
		                        'threeState'=>false
		                    ]
		                ])->label(false) ?>
					</div>
				    <div class="type6" style="display: none;">
				    	<?php foreach ($old_ids as $id): ?>
					    	<input type="hidden" name="type6-old_ids[]" value="<?=$id?>">
				    	<?php endforeach ?>
				    		<!-- <input type="hidden" name="type6-checked" id="type6-checked" value=<?php //$model->default_value?>>
				    	<div class="row" style="margin-bottom: 15px;">
				    		<div class="col-md-1">
					    		<input type="radio" name="type6-radio" value="0" style="margin-top: 8px;" <?php //($model->default_value == 0) ? "checked" : ""?> onclick="$('#type6-checked').val($(this).val());">
					    	</div>
					    	<div class="col-md-8">
					    		<input type="text" name="" class="form-control input-sm" value="Выбрать">
				    		</div>
				    	</div> -->
				    	<div class="examples">
				    		<?php if ($start > 1 && $model->type == CategoriesDynprops::TYPE6): ?>
				    			<?php foreach ($variants as $variant): ?>
							    	<div class="row" style="margin-bottom: 15px;">
							    		<input type="hidden" name="type6-ids[]" value="<?=$variant->id?>" class="form-control input-sm">
							    		<input type="hidden" name="type6-sort[]" value="<?=$variant->id?>" class="form-control input-sm">
							    		<div class="col-md-1">
								    		<input type="radio" name="type6-radio" value="<?=$variant->id?>" style="margin-top: 8px;" onclick="$('#type6-checked').val($(this).val());" onchange="if($(this).prop('checked')){removeChecks($(this).attr('name'));$(this).attr('checked','');}else{$(this).removeAttr('checked','');};" <?=($variant->id == $model->default_value) ? "checked" : ""?>>
								    	</div>
								    	<div class="col-md-8">
								    		<div class="type6 tab-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;margin-bottom: 0px !important;">
									            <div data-id="ru"  class="tab-pane active in tab-1">
									       			<input type="text" name="type6-title[][ru]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm" value="<?=$variant->name?>">
									            </div>
									            <?php $i = 0; foreach($langs as $lang): ?>
									                <?php if ($lang->url == 'ru') continue; ?>
									                <div class="tab-pane fade in tab-1" data-id="<?=$lang->url?>">
								                    <input type="text" name="type6-title[][<?=$lang->url?>]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm" value="<?=isset($variant->translation_name[$lang->url]) ? $variant->translation_name[$lang->url] : ''?>">
									                </div>
									            <?php $i++; endforeach;?>
									        </div>
							    		</div>
							    		<div class="col-md-3">
								    		<button type="button" class="btn btn-success btn-icon btn-circle btn-sm up-button" onclick="up($(this))" style="margin-top: 4px;"><i class="fa fa-caret-up"></i></button>
								    		&nbsp;
								    		<button type="button" onclick="down($(this))" class="btn btn-success btn-icon btn-circle btn-sm down-button" style="margin-top: 4px;"><i class="fa fa-caret-down"></i></button>
								    		&nbsp;
								    		<button type="button" onclick="remove($(this))" class="btn btn-danger btn-icon btn-circle btn-sm" style="margin-top: 4px;"><i class="fa fa-times"></i></button>
								    	</div>
							    	</div>
				    			<?php $start++; endforeach ?>
				    		<?php endif ?>
				    	</div>
				    	<div class="example" style="display: none;">			    	
					    	<div class="row" style="margin-bottom: 15px;">
					    		<input type="hidden" name="type6-sort[]" value="<?=$start?>">
					    		<div class="col-md-1">
						    		<input type="radio" name="type6-radio" value="<?=$start?>" style="margin-top: 8px;" onchange="if($(this).prop('checked')){removeChecks($(this).attr('name'));$(this).attr('checked','');}else{$(this).removeAttr('checked','');};" onclick="$('#type6-checked').val($(this).val());">
						    	</div>
						    	<div class="col-md-8">
						    		<div class="type6 tab-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;margin-bottom: 0px !important;">
							            <div data-id="ru"  class="tab-pane active in tab-1">
							       			<input type="text" name="type6-title[][ru]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm">
							            </div>
							            <?php $i = 0; foreach($langs as $lang): ?>
							                <?php if ($lang->url == 'ru') continue; ?>
							                <div class="tab-pane fade in tab-1" data-id="<?=$lang->url?>">
						                    <input type="text" name="type6-title[][<?=$lang->url?>]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm">
							                </div>
							            <?php $i++; endforeach;?>
							        </div>
					    		</div>
					    		<div class="col-md-3">
						    		<button type="button" class="btn btn-success btn-icon btn-circle btn-sm up-button" onclick="up($(this))" style="margin-top: 4px;"><i class="fa fa-caret-up"></i></button>
						    		&nbsp;
						    		<button type="button" onclick="down($(this))" class="btn btn-success btn-icon btn-circle btn-sm down-button" style="margin-top: 4px;"><i class="fa fa-caret-down"></i></button>
						    		&nbsp;
						    		<button type="button" onclick="remove($(this))" class="btn btn-danger btn-icon btn-circle btn-sm" style="margin-top: 4px;"><i class="fa fa-times"></i></button>
						    	</div>
					    	</div>
					    </div>
				    	<br>
				    	<button type="button" name="type6" class="btn btn-white btn-xs add-example">добавить значение</button>
					</div>
					<div class="type8" style="display: none;">
				    	<?php foreach ($old_ids as $id): ?>
					    	<input type="hidden" name="type8-old_ids[]" value="<?=$id?>">
				    	<?php endforeach ?>
				    		<input type="hidden" name="type8-checked" id="type8-checked" value=<?=$model->default_value?>>
				    	<div class="example" style="display: none;">
					    	<div class="row" style="margin-bottom: 15px;">
					    		<input type="hidden" name="type8-sort[]" value="<?=$start?>">
					    		<div class="col-md-1">
						    		<input type="radio" name="type8-radio" onclick="$('#type8-checked').val($(this).val());" onchange="if($(this).prop('checked')){removeChecks($(this).attr('name'));$(this).attr('checked','');}else{$(this).removeAttr('checked','');};" style="margin-top: 8px;" value="<?=$start?>">
						    	</div>
						    	<div class="col-md-8">
						    		<div class="type8 tab-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;margin-bottom: 0px !important;">
							            <div data-id="ru"  class="tab-pane active in tab-1">
							       			<input type="text" name="type8-title[][ru]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm">
							            </div>
							            <?php $i = 0; foreach($langs as $lang): ?>
							                <?php if ($lang->url == 'ru') continue; ?>
							                <div class="tab-pane fade in tab-1" data-id="<?=$lang->url?>">
						                    <input type="text" name="type8-title[][<?=$lang->url?>]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm">
							                </div>
							            <?php $i++; endforeach;?>
							        </div>
					    		</div>
					    		<div class="col-md-3">
						    		<button type="button" class="btn btn-success btn-icon btn-circle btn-sm up-button" onclick="up($(this))" style="margin-top: 4px;"><i class="fa fa-caret-up"></i></button>
						    		&nbsp;
						    		<button type="button" onclick="down($(this))" class="btn btn-success btn-icon btn-circle btn-sm down-button" style="margin-top: 4px;"><i class="fa fa-caret-down"></i></button>
						    		&nbsp;
						    		<button type="button" onclick="remove($(this))" class="btn btn-danger btn-icon btn-circle btn-sm" style="margin-top: 4px;"><i class="fa fa-times"></i></button>
						    	</div>
					    	</div>
					    </div>
				    	<div class="type8 examples" style="display: none;">
				    		<?php if ($start > 1 && $model->type == CategoriesDynprops::TYPE8): ?>
				    			<?php foreach ($variants as $variant): ?>
							    	<div class="row" style="margin-bottom: 15px;">
							    		<input type="hidden" name="type8-ids[]" value="<?=$variant->id?>" class="form-control input-sm">
							    		<input type="hidden" name="type8-sort[]" value="<?=$variant->id?>" class="form-control input-sm">
							    		<div class="col-md-1">
								    		<input type="radio" name="type8-radio" value="<?=$variant->id?>" style="margin-top: 8px;" onclick="$('#type8-checked').val($(this).val());" onchange="if($(this).prop('checked')){removeChecks($(this).attr('name'));$(this).attr('checked','');}else{$(this).removeAttr('checked','');};" <?=($variant->id == $model->default_value) ? "checked" : ""?>>
								    	</div>
								    	<div class="col-md-8">
								    		<div class="type8 tab-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;margin-bottom: 0px !important;">
									            <div data-id="ru"  class="tab-pane active in tab-1">
									       			<input type="text" name="type8-title[][ru]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm" value="<?=$variant->name?>">
									            </div>
									            <?php $i = 0; foreach($langs as $lang): ?>
									                <?php if ($lang->url == 'ru') continue; ?>
									                <div class="tab-pane fade in tab-1" data-id="<?=$lang->url?>">
								                    <input type="text" name="type8-title[][<?=$lang->url?>]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm" value="<?=isset($variant->translation_name[$lang->url]) ? $variant->translation_name[$lang->url] : ''?>">
									                </div>
									            <?php $i++; endforeach;?>
									        </div>
							    		</div>
							    		<div class="col-md-3">
								    		<button type="button" class="btn btn-success btn-icon btn-circle btn-sm up-button" onclick="up($(this))" style="margin-top: 4px;"><i class="fa fa-caret-up"></i></button>
								    		&nbsp;
								    		<button type="button" onclick="down($(this))" class="btn btn-success btn-icon btn-circle btn-sm down-button" style="margin-top: 4px;"><i class="fa fa-caret-down"></i></button>
								    		&nbsp;
								    		<button type="button" onclick="remove($(this))" class="btn btn-danger btn-icon btn-circle btn-sm" style="margin-top: 4px;"><i class="fa fa-times"></i></button>
								    	</div>
							    	</div>
				    			<?php endforeach ?>
				    		<?php endif ?>
				    	</div>
				    	<button type="button" name="type8" class="btn btn-white btn-xs add-example">добавить значение</button>
				    	<br>
				    	<br>
				    	<?= $form->field($model, 'group_one_row_type8')->widget(CheckboxX::classname(), 
		                    [
		                    	'autoLabel' => true,
		                        'labelSettings' => [
		                            'position' => CheckboxX::LABEL_RIGHT,
		                        ],
		                    	'pluginOptions'=>[
		                        'threeState'=>false
		                    ]
		                ])->label(false) ?>
					</div>
					<div class="type9" style="display: none;">
						<?php $start++; foreach ($old_ids as $id): ?>
					    	<input type="hidden" name="type9-old_ids[]" value="<?=$id?>">
				    	<?php endforeach ?>
				    	<div class="example" style="display: none;">
					    	<div class="row" style="margin-bottom: 15px;">
					    		<input type="hidden" name="type9-sort[]" value="<?=$start?>">
					    		<div class="col-md-1">
						    		<input type="checkbox" style="margin-top: 8px;" value="<?=$start?>" onchange="if($(this).prop('checked')){$(this).parent('div').next('div').children('input').val(1);$(this).attr('checked','');}else{$(this).parent('div').next('div').children('input').val(0);$(this).removeAttr('checked','');};">
						    	</div>
						    	<div class="col-md-8">
						    		<input type="hidden" name="type9-radio[]" value="0">
						    		<div class="type9 tab-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;margin-bottom: 0px !important;">
							            <div data-id="ru"  class="tab-pane active in tab-1">
							       			<input type="text" name="type9-title[][ru]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm">
							            </div>
							            <?php $i = 0; foreach($langs as $lang): ?>
							                <?php if ($lang->url == 'ru') continue; ?>
							                <div class="tab-pane fade in tab-1" data-id="<?=$lang->url?>">
						                    <input type="text" name="type9-title[][<?=$lang->url?>]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm">
							                </div>
							            <?php $i++; endforeach;?>
							        </div>
					    		</div>
					    		<div class="col-md-3">
						    		<button type="button" class="btn btn-success btn-icon btn-circle btn-sm up-button" onclick="up($(this))" style="margin-top: 4px;"><i class="fa fa-caret-up"></i></button>
						    		&nbsp;
						    		<button type="button" onclick="down($(this))" class="btn btn-success btn-icon btn-circle btn-sm down-button" style="margin-top: 4px;"><i class="fa fa-caret-down"></i></button>
						    		&nbsp;
						    		<button type="button" onclick="remove($(this))" class="btn btn-danger btn-icon btn-circle btn-sm" style="margin-top: 4px;"><i class="fa fa-times"></i></button>
						    	</div>
					    	</div>
					    </div>
				    	<div class="type9 examples" style="display: none;">
				    		<?php if ($start > 1 && $model->type == CategoriesDynprops::TYPE9): ?>
				    			<?php foreach ($variants as $variant): ?>
							    	<div class="row" style="margin-bottom: 15px;">
							    		<input type="hidden" name="type9-ids[]" value="<?=$variant->id?>">
							    		<input type="hidden" name="type9-sort[]" value="<?=$variant->id?>">
							    		<div class="col-md-1">
								    		<input type="checkbox"  style="margin-top: 8px;" onchange="if($(this).prop('checked')){$(this).parent('div').next('div').children('input').val(1);$(this).attr('checked','');}else{$(this).parent('div').next('div').children('input').val(0);$(this).removeAttr('checked');};" <?=($variant->value == 1) ? "checked" : ""?>>
								    	</div>

								    	<div class="col-md-8">
								    		<input type="hidden"  name="type9-radio[]" value="<?=$variant->value?>">
								    		<div class="type9 tab-content" style="padding-left: 0px;padding-right: 0px;padding-top: 0px;padding-bottom: 0px;margin-bottom: 0px !important;">
									            <div data-id="ru"  class="tab-pane active in tab-1">
									       			<input type="text" name="type9-title[][ru]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm" value="<?=$variant->name?>">
									            </div>
									            <?php $i = 0; foreach($langs as $lang): ?>
									                <?php if ($lang->url == 'ru') continue; ?>
									                <div class="tab-pane fade in tab-1" data-id="<?=$lang->url?>">
								                    <input type="text" name="type9-title[][<?=$lang->url?>]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm" value="<?=isset($variant->translation_name[$lang->url]) ? $variant->translation_name[$lang->url] : ''?>">
									                </div>
									            <?php $i++; endforeach;?>
									        </div>
							    		</div>
							    		<div class="col-md-3">
								    		<button type="button" class="btn btn-success btn-icon btn-circle btn-sm up-button" onclick="up($(this))" style="margin-top: 4px;"><i class="fa fa-caret-up"></i></button>
								    		&nbsp;
								    		<button type="button" onclick="down($(this))" class="btn btn-success btn-icon btn-circle btn-sm down-button" style="margin-top: 4px;"><i class="fa fa-caret-down"></i></button>
								    		&nbsp;
								    		<button type="button" onclick="remove($(this))" class="btn btn-danger btn-icon btn-circle btn-sm" style="margin-top: 4px;"><i class="fa fa-times"></i></button>
								    	</div>
							    	</div>
				    			<?php endforeach ?>
				    		<?php endif ?>
				    	</div>
				    	<button type="button" name="type9" class="btn btn-white btn-xs add-example">добавить значение</button>
				    	<br>
				    	<br>
				    	<?= $form->field($model, 'group_one_row_type9')->widget(CheckboxX::classname(), 
		                    [
		                    	'autoLabel' => true,
		                        'labelSettings' => [
		                            'position' => CheckboxX::LABEL_RIGHT,
		                        ],
		                    	'pluginOptions'=>[
		                        'threeState'=>false
		                    ]
		                ])->label(false) ?>
					</div>
					<div class="type10" style="display: none;">
				    	<div class="example" style="display: none;">			    	
					    	<div class="row" style="margin-bottom: 15px;">
					    		<input type="hidden" name="type10-sort[]" value="<?=$start?>" class="form-control input-sm">
					    		<div class="col-md-4">
						    		<input type="text" placeholder="от:" name="type10-from[]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm">
						    	</div>
						    	<div class="col-md-4">
						    		<input type="text" placeholder="до:" name="type10-to[]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm">
					    		</div>
					    		<div class="col-md-3">
						    		<button type="button" class="btn btn-success btn-icon btn-circle btn-sm up-button" onclick="up($(this))" style="margin-top: 4px;"><i class="fa fa-caret-up"></i></button>
						    		&nbsp;
						    		<button type="button" onclick="down($(this))" class="btn btn-success btn-icon btn-circle btn-sm down-button" style="margin-top: 4px;"><i class="fa fa-caret-down"></i></button>
						    		&nbsp;
						    		<button type="button" onclick="remove($(this))" class="btn btn-danger btn-icon btn-circle btn-sm" style="margin-top: 4px;"><i class="fa fa-times"></i></button>
						    	</div>
					    	</div>
					    </div>
				    	<div class="type10 examples" style="display: none;">
				    		<?php if (!empty($model->search_ranges_type10) && isset($model->search_ranges_type10)): ?>
				    			<?php foreach ($model->search_ranges_type10 as $key => $value): ?>
							    	<div class="row" style="margin-bottom: 15px;">
							    		<input type="hidden" name="type10-sort[]" value="<?=$start?>">
							    		<div class="col-md-4">
								    		<input type="text" placeholder="от:" name="type10-from[]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm" value="<?=$value['from']?>">
								    	</div>
								    	<div class="col-md-4">
								    		<input type="text" placeholder="до:" name="type10-to[]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm" value="<?=$value['to']?>">
							    		</div>
							    		<div class="col-md-3">
								    		<button type="button" class="btn btn-success btn-icon btn-circle btn-sm up-button" onclick="up($(this))" style="margin-top: 4px;"><i class="fa fa-caret-up"></i></button>
								    		&nbsp;
								    		<button type="button" onclick="down($(this))" class="btn btn-success btn-icon btn-circle btn-sm down-button" style="margin-top: 4px;"><i class="fa fa-caret-down"></i></button>
								    		&nbsp;
								    		<button type="button" onclick="remove($(this))" class="btn btn-danger btn-icon btn-circle btn-sm" style="margin-top: 4px;"><i class="fa fa-times"></i></button>
								    	</div>
							    	</div>
					    		<?php endforeach ?>
				    		<?php endif ?>
				    	</div>
				    	<button type="button" name="type10" class="btn btn-white btn-xs add-example">добавить значение</button>
				    	<br>
				    	<br>
				    	<?= $form->field($model, 'search_range_user_type10')->widget(CheckboxX::classname(), 
		                    [
		                    	'autoLabel' => true,
		                        'labelSettings' => [
		                            'position' => CheckboxX::LABEL_RIGHT,
		                        ],
		                    	'pluginOptions'=>[
		                        'threeState'=>false
		                    ]
		                ])->label(false) ?>
					</div>
					<div class="type11" style="display: none;">
						<div class="row" style="margin-bottom: 15px;">
				    		<div class="col-md-4">
					    		<input type="text" placeholder="от:" name="type11-start" onkeyup="$(this).attr('value',$(this).val())" value="<?=$model->start?>" class="form-control input-sm">
					    	</div>
					    	<div class="col-md-4">
					    		<input type="text" placeholder="до:" name="type11-end" onkeyup="$(this).attr('value',$(this).val())" value="<?=$model->end?>" class="form-control input-sm">
				    		</div>
				    		<div class="col-md-4">
					    		<input type="text" placeholder="шаг:" name="type11-step" onkeyup="$(this).attr('value',$(this).val())" value="<?=$model->step?>" class="form-control input-sm">
				    		</div>
				    	</div>
				    	<div class="example" style="display: none;">			    	
					    	<div class="row" style="margin-bottom: 15px;">
					    		<input type="hidden" name="type11-sort[]" value="<?=$start?>" class="form-control input-sm">
					    		<div class="col-md-4">
						    		<input type="text" placeholder="от:" name="type11-from[]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm">
						    	</div>
						    	<div class="col-md-4">
						    		<input type="text" placeholder="до:" name="type11-to[]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm">
					    		</div>
					    		<div class="col-md-3">
						    		<button type="button" class="btn btn-success btn-icon btn-circle btn-sm up-button" onclick="up($(this))" style="margin-top: 4px;"><i class="fa fa-caret-up"></i></button>
						    		&nbsp;
						    		<button type="button" onclick="down($(this))" class="btn btn-success btn-icon btn-circle btn-sm down-button" style="margin-top: 4px;"><i class="fa fa-caret-down"></i></button>
						    		&nbsp;
						    		<button type="button" onclick="remove($(this))" class="btn btn-danger btn-icon btn-circle btn-sm" style="margin-top: 4px;"><i class="fa fa-times"></i></button>
						    	</div>
					    	</div>
					    </div>
				    	<div class="type11 examples" style="display: none;">
				    		<?php if (!empty($model->search_ranges_type11) && isset($model->search_ranges_type11)): ?>
				    			<?php foreach ($model->search_ranges_type11 as $key => $value): ?>
							    	<div class="row" style="margin-bottom: 15px;">
							    		<input type="hidden" name="type11-sort[]" value="<?=$start?>" class="form-control input-sm">
							    		<div class="col-md-4">
								    		<input type="text" placeholder="от:" name="type11-from[]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm" value="<?=$value['from']?>">
								    	</div>
								    	<div class="col-md-4">
								    		<input type="text" placeholder="до:" name="type11-to[]" onkeyup="$(this).attr('value',$(this).val())" class="form-control input-sm" value="<?=$value['to']?>">
							    		</div>
							    		<div class="col-md-3">
								    		<button type="button" class="btn btn-success btn-icon btn-circle btn-sm up-button" onclick="up($(this))" style="margin-top: 4px;"><i class="fa fa-caret-up"></i></button>
								    		&nbsp;
								    		<button type="button" onclick="down($(this))" class="btn btn-success btn-icon btn-circle btn-sm down-button" style="margin-top: 4px;"><i class="fa fa-caret-down"></i></button>
								    		&nbsp;
								    		<button type="button" onclick="remove($(this))" class="btn btn-danger btn-icon btn-circle btn-sm" style="margin-top: 4px;"><i class="fa fa-times"></i></button>
								    	</div>
							    	</div>
					    		<?php endforeach ?>
				    		<?php endif ?>
				    	</div>
				    	<label>Диапазоны поиска:</label><br>
				    	<button type="button" name="type11" class="btn btn-white btn-xs add-example">добавить диапозон</button>
				    	<br>
				    	<br>
				    	<?= $form->field($model, 'search_range_user_type11')->widget(CheckboxX::classname(), 
		                    [
		                    	'autoLabel' => true,
		                        'labelSettings' => [
		                            'position' => CheckboxX::LABEL_RIGHT,
		                        ],
		                    	'pluginOptions'=>[
		                        'threeState'=>false
		                    ]
		                ])->label(false) ?>
					</div>
		     	</div>
	        </div>
        </div>
        <hr>
        <div class="row">
			<div class="col-md-2">
				<label><?=$model->getAttributeLabel('cache_key')?></label>
			</div>
			<div class="col-md-5">
				<?= $form->field($model, "cache_key")->textInput([])->label(false)?>
				<?= $form->field($model, 'req')->widget(CheckboxX::classname(), 
                    [
                    	'autoLabel' => true,
                        'labelSettings' => [
                            'position' => CheckboxX::LABEL_RIGHT,
                        ],
                    	'pluginOptions'=>[
                        'threeState'=>false
                    ]
                ])->label(false) ?>
                <div style="display: none;" id="in-search">
	            	<?= $form->field($model, 'in_search')->widget(CheckboxX::classname(), 
	                    [
	                    	'options' =>[ 'class' => 'default-value'],
	                    	'autoLabel' => true,
	                        'labelSettings' => [
	                            'position' => CheckboxX::LABEL_RIGHT,
	                        ],
	                    	'pluginOptions'=>[
	                        'threeState'=>false
	                    ]
	                ])->label(false) ?>
                </div>
                <?= $form->field($model, 'in_seek')->widget(CheckboxX::classname(), 
                    [
                    	'autoLabel' => true,
                        'labelSettings' => [
                            'position' => CheckboxX::LABEL_RIGHT,
                        ],
                    	'pluginOptions'=>[
                        'threeState'=>false
                    ]
                ])->label(false) ?>
                <?= $form->field($model, 'parent_value')->widget(CheckboxX::classname(),
                    [
                    	'autoLabel' => true,
                        'labelSettings' => [
                            'position' => CheckboxX::LABEL_RIGHT,
                        ],
                    	'pluginOptions'=>[
                        'threeState'=>false
                    ]
                ])->label(false) ?>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-10">
		    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success','name' => 'submit-button', 'value' => \backend\models\items\Categories::TYPE_TEMPLATE]) ?>
		    <button class="btn btn-inverse" type="button" onClick="history.back();">Назад</button>
		</div>
	</div>
</div>
<?php ActiveForm::end(); ?>
<?php 
$this->registerJs(<<<JS
	removeChecks = function(name){
		$("[name='"+ name + "']").removeAttr('checked','');
	}
    changeTab = function(obj){
        val = obj.attr('data-id');
        $('#tab-2-nav li').removeClass('active');
        $(".tab-1").removeClass('active');
        $("[data-id^='"+val+"']").addClass('active');
        obj.addClass('active');
    }
    changeDefault = function(){
    	val = $("#categoriesdynprops-type").val();

    	$("[class^='type']").hide();
    	
    	if(val !=1 && val != 2){
    		$("#in-search").show();
    	}else{
    		$("#in-search").hide();
    	}

    	if(val == 6){
    		$("#only-type6").show();
    	}else{
    		$("#only-type6").hide();
    	}
    	$(".type" + val).show();
    }
    up = function(el){
		current = el.parent('div').parent('div');
    	current_html = current.html();
		prev = current.prev();
		console.log(prev.html());
		console.log(current.html());
		prev_html = prev.html();
		current.html(prev_html);
		prev.html(current_html);
    }
    down = function(el){
    	current = el.parent('div').parent('div');
    	current_html = current.html();
		next = current.next();
		next_html = next.html();
		current.html(next_html);
		next.html(current_html);
    }
    remove = function(el){
    	current = el.parent('div').parent('div');
    	current.remove();
    }
    $(".add-example").on('click', function(){
    	name = $(this).attr('name');
    	var obj = $("." + name + " .example").children('div');
    	val = obj.children('div').children('input').val();
    	val++;
    	obj.children('div').children('input').val(val);
    	obj.children('input').val(val);
    	var template = $("." + name + " .example").html();
    	$("." + name + " .examples").append(template);	
	})
	$(document).ready(function(){
		changeDefault();
	})
JS
)
?>