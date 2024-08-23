<?= $form->field($model, 'sms_service',[
	'template' => '<div class="row">
							<div class="col-md-3">{label}<br>Смс</div>
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-4">{input}{error}</div>
									<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
])->dropDownLIst($model->getSmsService()); ?>
<?= $form->field($model, 'sms_service_token', [
	'template' => '<div class="row">
							<div class="col-md-3">{label}</div>
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-12">{input}{error}</div>
									<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
])->textarea(['class' => 'form-control'])?>

<?= $form->field($model, 'sms_service_message', [
	'template' => '<div class="row">
							<div class="col-md-3">{label}</div>
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-12">{input}{error}</div>
									<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
])->textarea(['class' => 'form-control'])?>


<?= $form->field($model, 'users_sms_retry_limit', [
	'template' => '<div class="row">
							<div class="col-md-3">{label}</div>
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-3">{input}{error}</div>
									<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
	])->textInput(['class' => 'form-control number_input'])?>

<?= $form->field($model, 'users_sms_retry_timeout', [
	'template' => '<div class="row">
    						<div class="col-md-3">{label}</div>
    						<div class="col-md-2">
    							<div class="input-group">{input}<span class="input-group-addon">минут</span></div>{hint}{error}
							</div>
						</div>'
	])->textInput(['class' => 'form-control number_input'])?>


<?= $form->field($model, 'users_sms_code_type',[
	'template' => '<div class="row">
							<div class="col-md-3">{label}</div>
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-5">{input}{error}</div>
									<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>' 
	])->dropDownLIst($model->getSmsCodeType()); ?>

<?= $form->field($model, 'users_sms_code_length', [
	'template' => '<div class="row">
    						<div class="col-md-3">{label}</div>
    						<div class="col-md-2">
    							<div class="input-group">{input}<span class="input-group-addon">символов</span></div>{hint}{error}
							</div>
						</div>'
	])->textInput(['class' => 'form-control number_input'])?>

<?= $form->field($model, 'users_sms_links_short',[
	'template' => '<div class="row">
							<div class="col-md-3">{label}<br>Регистрация</div>
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-4">{input}{error}</div>
									<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>' 
	])->dropDownLIst($model->getStatus()); ?>


