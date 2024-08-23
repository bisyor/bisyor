<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\Services */
$this->title = 'Изменить Пакет '.$model->title;

?>
<div class="services-update">

    <?= $this->render('_form', [
    	'title' => 'Изменить',
    	'modelsRegionalPrices' => $modelsRegionalPrices,
        'serviceModels' => $serviceModels,
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>
