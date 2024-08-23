<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Helps */
$this->title = 'Изменить';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="helps-update">

    <?= $this->render('_form', [
        'model' => $model,
        'textes' => $textes,
        'names' => $names,
        'post' => $post,
        'langs' => $langs,
    ]) ?>

</div>
