<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\shops\Services */
$this->title = 'Создать';

?>
<div class="services-create">
    <?= $this->render('_form', [
    	'title' => $this->title,
    	'modelsRegionalPrices' => $modelsRegionalPrices,
        'serviceModels' => $serviceModels,
        'model' => $model,
        'langs' => $langs,
    ]) ?>
</div>
