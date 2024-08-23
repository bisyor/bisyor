<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\Shops */
$this->title = 'Изменить';
?>
<div class="shops-update">
	<?= $this->render('_form', [
    	'title' => $this->title,
        'model' => $model,
        'modelNetworks' => $modelNetworks
    ]) ?>
</div>