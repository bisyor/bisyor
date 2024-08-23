<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\promocodes\PromocodesUsage */
?>
<div class="promocodes-usage-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fio',
            'balance',
            'phone',
            'email',
            'registry_date',
            'last_seen',
        ],
    ]) ?>

</div>
