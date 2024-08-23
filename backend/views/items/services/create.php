<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\shops\Services */

?>
<div class="services-create">
    <?= $this->render('_form', [
    	'title' => $this->title,
        'model' => $model,
        'langs' => $langs,
    ]) ?>
</div>
