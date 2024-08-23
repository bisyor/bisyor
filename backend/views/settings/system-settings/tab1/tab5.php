<?php 
    $templateInput = 	'<div class="row">
    						<div class="col-md-3">{label}</div>
    						<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-3">{input}{error}</div>
	    							<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>';

    $templateDropdown1 = '<div class="row">
    						<div class="col-md-3">{label}</div>
	    					<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-5">{input}{error}</div>
	    							<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>';
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
    							<div class="input-group">{input}<span class="input-group-addon">дней</span></div>{hint}{error}
							</div>
						</div>';

?>

<?= $form->field($model, 'import_access',['template' => $templateDropdown1])->dropDownLIst($model->getImportAccess()); ?>

<?= $form->field($model, 'import_csv_frontend',['template' => $templateDropdown2])->dropDownLIst($model->getState()); ?>

<?= $form->field($model, 'import_update_republicate',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('Обновлять срок публикации объявления при обновлении данных о нем'); ?>

<?= $form->field($model, 'import_cleanup', ['template' => $templateWithLabel1])->textInput(['class' => 'form-control number_input']) ?>

<?= $form->field($model, 'import_title_auto',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('В случае если для категории включено настройка шаблонов заголовка и описания она также будет применяться и для импортируемых в неё объявлений'); ?>



