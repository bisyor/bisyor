<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopsAbonements */
$this->title = 'Изменить';

?>
<div class="shops-abonements-update">
    <?= $this->render('form', [
        'model' => $model,
        'langs' => $langs,
    	'title' => $this->title,
        'modelsDisconts' => $modelsDisconts,
        'modelsPeriods' => $modelsPeriods,
    ]) ?>
</div>
