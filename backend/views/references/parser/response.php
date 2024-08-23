<?php
/**
 * @var $this yii\web\View
 * @var $status
 */


?>

<div>
    <p class="center-block">
        <?= \yii\helpers\Html::a('Назад', '/references/parser', ['class' => 'btn btn-warning'])?>
        <div class="alert alert-<?= $status ? "success" : 'warning'?> fade in m-b-15">
        <?= $status ? "$status - объявлений были успешно скопированы" : 'Данные не найдены!'?>
        <span class="close" data-dismiss="alert">×</span>
    </div>
    </p>
</div>