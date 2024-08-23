<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\bills\Bills */
?>
<div class="bills-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'user_balance',
            'service_id',
            'svc_activate:boolean',
            'svc_settings:ntext',
            'item_id',
            'type',
            'psystem',
            'amount',
            'money',
            'currency_id',
            'date_cr',
            'date_pay',
            'status',
            'description:ntext',
            'details:ntext',
            'ip',
            'promocode_id',
        ],
    ]) ?>

</div>
