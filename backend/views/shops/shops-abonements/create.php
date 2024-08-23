<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopsAbonements */
$this->title = 'Создать';
?>
<div class="shops-abonements-create">
    <?= $this->render('form', [
    	'title' => $this->title,
        'model' => $model,
        'modelsPeriods' => $modelsPeriods,
        'modelsDisconts' => $modelsDisconts,
        'titles' => $titles,
        'langs' => $langs,
    ]) ?>
</div>
