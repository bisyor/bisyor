<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Vacancies */
/* @var $translation_title */
/* @var $titles */
/* @var $langs */
/* @var $description */
?>
<div class="vacancies-update">

    <?= $this->render('_form', [
        'model' => $model,
        'titles' => $titles,
        'langs' => $langs,
        'description' => $description,

    ]) ?>

</div>
