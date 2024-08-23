<?php 
    $templateInput = 	'<div class="row">
    						<div class="col-md-3">{label}</div>
    						<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-2">{input}{error}</div>
								</div>
							</div>
						</div>';
    $templateWithLabel1 = '<div class="row">
    						<div class="col-md-3">{label}</div>
    						<div class="col-md-2">
    							<div class="input-group">{input}<span class="input-group-addon">символов</span></div>{error}
							</div>
						</div>';
	$templateWithLabel2 = '<div class="row">
							<div class="col-md-3">{label}</div>
							<div class="col-md-2">
								<div class="input-group">{input}<span class="input-group-addon">на страницу</span></div>{error}
							</div>
						</div>';

?>
<?= $form->field($model, 'shops_form_title_limit', ['template' => $templateWithLabel1])->textInput(['class' => 'form-control number_input']) ?>
<?= $form->field($model, 'shops_form_descr_limit', ['template' => $templateWithLabel1])->textInput(['class' => 'form-control number_input']) ?>
<?= $form->field($model, 'shops_phones_limit', ['template' => $templateInput])->textInput(['class' => 'form-control number_input']) ?>
<?= $form->field($model, 'shops_social_limit', ['template' => $templateInput])->textInput(['class' => 'form-control number_input']) ?>
<?= $form->field($model, 'shop_items_pagesize', ['template' => $templateWithLabel2])->textInput(['class' => 'form-control number_input']) ?>