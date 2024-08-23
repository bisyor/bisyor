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


<?= $form->field($model, 'view_similar_limit', ['template' => $templateInput])->textInput(['class' => 'form-control number_input']) ?>

<?= $form->field($model, 'view_comments',['template' => $templateDropdown2])->dropDownLIst($model->getState()); ?>

<?= $form->field($model, 'view_promote',['template' => $templateDropdown2])->dropDownLIst($model->getViewPromote()); ?>

<?= $form->field($model, 'view_statistic_available',['template' => $templateDropdown2])->dropDownLIst($model->getViewPromote()); ?>

<!-- Sarvar, [17.04.20 13:58]

Sarvar, [17.04.20 14:20]
отображать список объявлений на главной странице страны/региона/ города

Sarvar, [17.04.20 14:22]
Обновлять срок публикации объявления при обновлении данных о нем

Sarvar, [17.04.20 14:25]
В случае если для категории включено настройка шаблонов заголовка и описания она также будет применяться и для импортируемых в неё объявлений

Sarvar, [17.04.20 14:26]
Отображать ссылки на категории без объявлений в фильтре поиска -->