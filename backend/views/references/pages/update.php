<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Pages */

$this->title = 'Изменить';
$this->params['breadcrumbs'][] = ['label' => "Страницы", 'url' => ['/references/pages']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="pages-update">

    <?= $this->render('_form', [
        'model' => $model,
        'description' => $description,
        'langs' => $langs,
        'mkeywords' => $mkeywords,
        'mdescription' => $mdescription,
        'mtitle' => $mtitle,
        'title' => $title,
    ]) ?>

</div>
