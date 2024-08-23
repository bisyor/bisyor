<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\references\Currencies */

?>
<div class="currencies-create">
    <?= $this->render('_form', [
        'model' => $model,
        'titles' => $titles,
        'names' => $names,
        'langs' => $langs,
    ]) ?>
</div>
