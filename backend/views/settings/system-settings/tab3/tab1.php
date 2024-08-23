<?= $form->field($model, 'users_register_type',[
	'template' => '<div class="row">
							<div class="col-md-3">{label}<br>Регистрация</div>
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-5">{input}{error}</div>
									<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>' 
	])->dropDownLIst($model->getRegisterType())->hint('Требовать только телефон, пароль присылать по SMS'); ?>

<?= $form->field($model, 'users_register_phone_contacts',[
	'template' => '<div class="row">
    						<div class="col-md-3">{label}<br>Профиль пользователя</div>
	    					<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-3">{input}{error}</div>
	    							<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
	])->dropDownLIst($model->getShowOrNot())->hint('номер телефона указанный при указанный при регистрации не отображается в профиле пользователя'); ?>

<?= $form->field($model, 'bonus_for_user', [
    'template' => '<div class="row">
    						<div class="col-md-3">{label}<br>Бонус для нового зарегистрированного пользователя</div>
    						<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-3">{input}{error}</div>
	    							<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
])->textInput(['class' => 'form-control number_input']) ?>
<?= $form->field($model, 'bonus_to_the_user_for_entering_the_platform_once_a_day', [
    'template' => '<div class="row">
    						<div class="col-md-3">{label}<br>Бонус для пользователя</div>
    						<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-3">{input}{error}</div>
	    							<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
])->textInput(['class' => 'form-control number_input']) ?>
<?= $form->field($model, 'users_register_captcha',[
	'template' => '<div class="row">
    						<div class="col-md-3">{label}<br>Регистрация</div>
	    					<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-3">{input}{error}</div>
	    							<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
	])->dropDownLIst($model->getStatus());?>

<?= $form->field($model, 'users_register_passconfirm',[
	'template' => '<div class="row">
    						<div class="col-md-3">{label}<br>Регистрация</div>
	    					<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-3">{input}{error}</div>
	    							<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
	])->dropDownLIst($model->getStatus())->hint('отображать поле повторного ввода пароля в форме регистрации'); ?>

<?= $form->field($model, 'users_register_social_email_activation',[
	'template' => '<div class="row">
    						<div class="col-md-3">{label}<br>Регистрация</div>
	    					<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-3">{input}{error}</div>
	    							<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
	])->dropDownLIst($model->getStatus())->hint('отправлять письмо со ссылкой активации или SMS при авторизации  через соц. сеть
'); ?>

<?= $form->field($model, 'users_profile_phones', [
	'template' => '<div class="row">
    						<div class="col-md-3">{label}<br>Профиль пользователя</div>
    						<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-3">{input}{error}</div>
	    							<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
	])->textInput(['class' => 'form-control number_input']) ?>

<?= $form->field($model, 'users_settings_contacts',[
	'template' => '<div class="row">
    						<div class="col-md-3">{label}<br>Настройка профиля</div>
	    					<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-3">{input}{error}</div>
	    							<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
	])->dropDownLIst($model->getState()); ?>

<?= $form->field($model, 'users_settings_email_change',[
	'template' => '<div class="row">
    						<div class="col-md-3">{label}<br>Настройка профиля</div>
	    					<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-3">{input}{error}</div>
	    							<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
	])->dropDownLIst($model->getState()); ?>

<?= $form->field($model, 'users_email_temporary_check',[
	'template' => '<div class="row">
    						<div class="col-md-3">{label}<br>Регистрация, Настройка профиля</div>
	    					<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-3">{input}{error}</div>
	    							<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
	])->dropDownLIst($model->getStatus()); ?>

<?= $form->field($model, 'users_fake_email_template', [
	'template' => '<div class="row">
							<div class="col-md-3">{label}</div>
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-5">{input}{error}</div>
									<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
	])->hint('Шаблон эмаил адреса сгенерированных пользователей: <br>{name} - имя пользователя, {host} - домен проекта') ?>
<?= $form->field($model, 'users_settings_destroy',[
	'template' => '<div class="row">
    						<div class="col-md-3">{label}<br>Настройка профиля</div>
	    					<div class="col-md-8">
	    						<div class="row">
	    							<div class="col-md-3">{input}{error}</div>
	    							<div class="col-md-12">{hint}</div>
								</div>
							</div>
						</div>'
	])->dropDownLIst($model->getStatus())->hint('Пользователю доступно функция удаления своей учетной записи в настройках профиля. При этом аккаунт пользователя будет помечен как заблокированный.'); ?>


