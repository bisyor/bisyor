<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\references\Vacancies */
/* @var $titles */
/* @var $post */
/* @var $langs */
/* @var $description */
?>
<div class="vacancies-create">
    <?= $this->render('_form', [
        'model' => $model,
        'titles' => $titles,
        'langs' => $langs,
        'description' => $description,
    ]) ?>
</div>
