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
    							<div class="input-group">{input}<span class="input-group-addon">объявлений</span></div>{hint}{error}
							</div>
						</div>';
	$templateWithLabel2 = '<div class="row">
    						<div class="col-md-3">{label}</div>
    						<div class="col-md-2">
    							<div class="input-group">{input}<span class="input-group-addon">на страницу</span></div>{hint}{error}
							</div>
						</div>';
?>
<?= $form->field($model, 'search_sphinx',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('Статус: поиск и индексирование работает'); ?>

<?= $form->field($model, 'search_list_type',['template' => $templateDropdown2])->dropDownLIst($model->getListType()); ?>

<?= $form->field($model, 'search_category_currency',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('не выполнять, цены в списках будут указываться в валюте  указанной пользователем'); ?>

<?= $form->field($model, 'search_pagesize', ['template' => $templateWithLabel2])->textInput(['class' => 'number_input form-control']) ?>

<?= $form->field($model, 'search_quick_limit', ['template' => $templateInput])->textInput(['class' => 'number_input form-control']) ?>

<?= $form->field($model, 'search_quick_category',['template' => $templateDropdown2])->dropDownLIst($model->getStatus()); ?>

<?= $form->field($model, 'search_filter_catslevel', ['template' => $templateInput])->textInput(['class' => 'number_input form-control']) ?>

<?= $form->field($model, 'search_premium_limit', ['template' => $templateWithLabel1])->textInput(['class' => 'number_input form-control']) ?>

<?= $form->field($model, 'search_premium_category',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('выводить объявления независимо от текущей категории поиска в фильтре'); ?>

<?= $form->field($model, 'search_premium_region',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('выводить объявления независимо от настроек текущего региона в фильтре'); ?>

<?= $form->field($model, 'search_premium_rand',['template' => $templateDropdown2])->dropDownLIst($model->getStatus())->hint('выводить премиум объявления в блоке в произвольном порядке'); ?>

<?= $form->field($model, 'search_rss_enabled',['template' => $templateDropdown2])->dropDownLIst($model->getStatus()); ?>

<?= $form->field($model, 'search_rss_limit', ['template' => $templateWithLabel1])->textInput(['class' => 'number_input form-control']) ?>
