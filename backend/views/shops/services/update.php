<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\Services */
$this->title = 'Изменить';

?>
<div class="services-update">

    <?= $this->render('_form', [
    	'title' => $this->title,
    	'modelsRegionalPrices' => $modelsRegionalPrices,
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>
