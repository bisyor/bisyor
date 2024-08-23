<?php 
    $templateInput = 	'<div class="row">
    						<div class="col-md-3">{label}<br>Публикация объявлений</div>
    						<div class="row">
    							<div class="col-md-12">{input}{error}</div>
    							<div class="col-md-12">{hint}</div>
							</div>
						</div>';

    $templateDropdown1 = '<div class="row">
    						<div class="col-md-3">{label}<br>Публикация объявлений</div>
	    					<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-5">{input}{error}</div>
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
    
    $templateWithLabel1 = '<div class="row">
    						<div class="col-md-3">{label}<br>Публикация объявлений</div>
    						<div class="col-md-2">
    							<div class="input-group">{input}<span class="input-group-addon">дней</span></div>{hint}{error}
							</div>
						</div>';
	$templateWithLabel2 = '<div class="row">
    						<div class="col-md-3">{label}<br>Профиль пользователя</div>
    						<div class="col-md-2">
    							<div class="input-group">{input}<span class="input-group-addon">на страницу</span></div>{hint}{error}
							</div>
						</div>';
$templateforCount= '<div class="row">
    						<div class="col-md-3">{label}<br>Публикация объявлений</div>
    						<div class="col-md-2">
    							<div class="input-group">{input}</div>{hint}{error}
							</div>
						</div>';
?>
<?= $form->field($model, 'item_author',['template' => $templateDropdown1])->dropDownLIst($model->getItemAuthor())->hint('Добавление объявлений доступно сразу только "от частного лица", после открытия магазина - объявления размещаются "от частного лица" или "от магазина"'); ?>
<?= $form->field($model, 'general_premium_view_type',['template' => $templateDropdown1])->dropDownLIst($model->getItemsPrimumType()); ?>

<?= $form->field($model, 'general_publication_authorized',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('Публикация объявления доступна только авторизованным пользователям'); ?>
<?= $form->field($model, 'general_publication_pre_moderation',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('публикация объявления выполняется после проверки модератора'); ?>
<?= $form->field($model, 'general_publication_pre_moderation_update',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('после редактирования объявления скрывается с публикации и отправляется на обязательную проверку модератора'); ?>
<?= $form->field($model, 'general_announcement_period',['template' => $templateDropdown2])->dropDownLIst($model->getState());?>
<?= $form->field($model, 'general_editing_item_category',['template' => $templateDropdown2])->dropDownLIst($model->getState()); ?>
<?= $form->field($model, 'general_agreement_submitting_item',['template' => $templateDropdown2])->dropDownLIst($model->getShowOrNot()); ?>
<?= $form->field($model, 'general_activation_link_expiration_day', ['template' => $templateWithLabel1])->textInput(['class' => 'number_input form-control']) ?>
<?= $form->field($model, 'general_auto_deletion_item', ['template' => $templateWithLabel1])->textInput(['class' => 'number_input form-control']) ?>
<?= $form->field($model, 'general_deleting_inactive_user_items',['template' => $templateDropdown2])->dropDownLIst($model->getGeneralDeletingInactiveUserItems());?>
<?= $form->field($model, 'general_sms_alert',['template' => $templateDropdown2])->dropDownLIst($model->getGeneralSmsAlert())->hint('Уведомления отправляются только для объявлений с активной услугой "Премиум"'); ?>
<?= $form->field($model, 'general_re_publishing_raise', ['template' => $templateWithLabel1])->textInput(['class' => 'number_input form-control']) ?>
<?= $form->field($model, 'recommendation_count', ['template' => $templateforCount])->textInput(['class' => 'number_input form-control']) ?>
<?= $form->field($model, 'recommendation_categories_count', ['template' => $templateforCount])->textInput(['class' => 'number_input form-control']) ?>
<?= $form->field($model, 'last_item_count_in_new_items', ['template' => $templateforCount])->textInput(['class' => 'number_input form-control']) ?>
<?= $form->field($model, 'general_user_items_pagesize', ['template' => $templateWithLabel2])->textInput(['class' => 'number_input form-control']) ?>
<?= $form->field($model, 'general_limits_payed',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('Укажите настройки лимитов публикации в разделе "Объявления/Лимиты"'); ?>
<?= $form->field($model, 'general_automatic_translation',['template' => $templateDropdown2])->dropDownLIst($model->getGeneralAutomaticTranslation()) ?>

<?php 


?>


