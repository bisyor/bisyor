<?php
/**
 * @var $this yii\web\View
 * @var $status
 * @var $failed
 * @var $type
 */
?>

<div>
    <p class="center-block">
        <?= \yii\helpers\Html::a('Назад', '/references/parser' . ($type == 2 ? "/olx-business" : "/olx"), ['class' => 'btn btn-warning'])?>
        <div class="alert alert-<?= $status ? "success" : 'warning'?> fade in m-b-15">
        <?= $status ? "$status - объявлений были успешно скопированы" : 'Данные не найдены!'?>
        <span class="close" data-dismiss="alert">×</span>
    </div>
    <p class="center-block">
        <?php if($failed):?>
            <div class="alert alert-danger fade in m-b-15">
                Неудачные попытки
                <?php foreach ($failed as $link):?>
                    <p><?= $link ?></p>
                <?php endforeach;?>
                <span class="close" data-dismiss="alert">×</span>
            </div>
        <?php endif;?>
    </p>
</div>