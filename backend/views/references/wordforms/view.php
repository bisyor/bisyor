<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Wordforms */
?>
<div class="wordforms-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sinonim',
            'original',
        ],
    ]) ?>

</div>
