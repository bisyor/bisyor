<?php 
	$templateDropdown2 = '<div class="row">
							<div class="col-md-3">{label}</div>
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-3">{input}{error}</div>
									<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>';
    
    $templateWithLabel1 = '<div class="row">
    						<div class="col-md-3">{label}</div>
    						<div class="col-md-2">
    							<div class="input-group">{input}<span class="input-group-addon">символов</span></div>{hint}{error}
							</div>
						</div>';

?>

<?= $form->field($model, 'seo_filter_cats_empty',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('Отображать ссылки на категории без объявлений в фильтре поиска'); ?>

<?= $form->field($model, 'seo_cats_empty_index',['template' => $templateDropdown2])->dropDownLIst($model->getStatus()); ?>

<?= $form->field($model, 'seo_view_meta_description_limit', ['template' => $templateWithLabel1])->textInput(['class' => 'form-control number_input']) ?>
