<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\shops\Shops */
$this->title = 'Создать';
?>
<div class="shops-create">
    <?= $this->render('_form', [
    	'title' => $this->title,
        'model' => $model,
        'modelNetworks' => $modelNetworks
    ]) ?>
</div>
