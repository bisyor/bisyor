<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Polls */

?>
<div class="polls-create">
    <?= $this->render('_form', [
        'model' => $model,
        'values'=>$values,
    ]) ?>
</div>
