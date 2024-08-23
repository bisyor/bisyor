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
?>

<?= $form->field($model, 'index_region_search',['template' => $templateDropdown2])->dropDownLIst($model->getState())->hint('отображать список объявлений на главной странице страны/региона/ города'); ?>

<?= $form->field($model, 'index_region_search_canonical',['template' => $templateDropdown2])->dropDownLIst($model->getState()); ?>
