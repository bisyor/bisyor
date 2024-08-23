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

	$templateDropdown2 = '<div class="row">
							<div class="col-md-3">{label}<br>Публикация объявлений</div>
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-3">{input}{error}</div>
									<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>';
	$templateWithLabel2 = '<div class="row">
    						<div class="col-md-3">{label}<br>Профиль пользователя</div>
    						<div class="col-md-2">
    							<div class="input-group">{input}<span class="input-group-addon">на страницу</span></div>{hint}{error}
							</div>
						</div>';
?>

<?= $form->field($model, 'shops_search_sphinx',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('Статус: поиск и индексирование работает'); ?>

<?= $form->field($model, 'shops_premoderation',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('магазины публикуются в списке после проверки модератором'); ?>

<?= $form->field($model, 'shops_categories',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('используются категории магазинов, магазин может быть привязан к пользователяю, пользователь может подать заявку на закрепление магазина за своим профилем'); ?>

<?= $form->field($model, 'shops_category_count', ['template' => $templateInput])->textInput(['class' => 'form-control number_input']) ?>
<?= $form->field($model, 'shops_categories_limit', ['template' => $templateWithLabel2])->textInput(['class' => 'form-control number_input']) ?>

<?= $form->field($model, 'shops_abonement',['template' => $templateDropdown2])->dropDownLIst($model->getStatus()); ?>

<?= $form->field($model, 'shops_abonement_default_limit', ['template' => $templateInput])->textInput(['class' => 'form-control number_input']) ?>
