<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => "SEO"];
$this->params['breadcrumbs'][] = 'Настройки';
?>
<div class="panel panel-inverse" data-sortable-id="ui-widget-7" data-init="true">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Настройки</h4>
    </div>
    <div class="panel-body">
        <ul class="nav nav-tabs">
			<li class="active"><a href="#default-tab-1" data-toggle="tab" aria-expanded="true">Robots.txt</a></li>
			<li class=""><a href="#default-tab-2" data-toggle="tab" aria-expanded="false">Sitemap.xml</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade active in" id="default-tab-1">
				<?php $form = ActiveForm::begin(); ?>
					<textarea name='text' class='form-control' rows='30' style='width: 80%;' value=''><?= $text?></textarea>
					<br>
					<?= Html::submitButton('Сохранить' , ['class' =>'btn btn-success']) ?>
				<?php ActiveForm::end(); ?>
			</div>
			<div class="tab-pane fade" id="default-tab-2">
				<p>Файл <b style="color:#66a3ff">Sitemap.xml</b> обновляется автоматически раз в сутки.</p>
				<p>Последнее обновление: <b><?=$lastChange?></b></p>
				<a href="/references/seo/run-handle" class="btn btn-info">Обновить принудительно</a>
			</div>
		</div>
	</div>
</div>