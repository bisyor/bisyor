<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => "SEO"];
$this->params['breadcrumbs'][] = 'Пользователи';
?>
<?php $form = ActiveForm::begin(); ?>

<div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1">
    <div class="panel-heading p-0">
        <div class="panel-heading-btn m-r-10 m-t-10">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand" data-original-title="" title="" data-init="true"><i class="fa fa-expand"></i></a>
        </div>
        <div class="tab-overflow overflow-right">
            <ul class="nav nav-tabs nav-tabs-inverse">
                <li class="prev-button" style=""><a href="javascript:;" data-click="prev-tab" class="text-success"><i class="fa fa-arrow-left"></i></a></li>
                <li class="active"><a href="#nav-tab-1" data-toggle="tab" aria-expanded="false">Авторизация</a></li>
                <li class=""><a href="#nav-tab-2" data-toggle="tab" aria-expanded="false">Регистрация</a></li>
                <li class=""><a href="#nav-tab-3" data-toggle="tab" aria-expanded="false">Забыли пароль</a></li>
                <li class="next-button" style=""><a href="javascript:;" data-click="next-tab" class="text-success"><i class="fa fa-arrow-right"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="nav-tab-1">
            <?= $this->render('users/auth', [
                'langs' => $langs,
                'model' => $model,
                'titles' => $titles,
                'form' => $form,
            ]) ?>
        </div>
        <div class="tab-pane fade" id="nav-tab-2">
            <?= $this->render('users/registry', [
                'langs' => $langs,
                'model' => $model,
                'titles' => $titles,
                'form' => $form,
            ]) ?>
        </div>
        <div class="tab-pane fade" id="nav-tab-3">
            <?= $this->render('users/recovery', [
                'langs' => $langs,
                'model' => $model,
                'titles' => $titles,
                'form' => $form,
            ]) ?>
        </div>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
