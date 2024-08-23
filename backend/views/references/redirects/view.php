<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Currencies */
?>
<div class="redirects-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'from_uri',
            'to_uri',
            'status',
            'is_relative',
            'add_extra:boolean',
            'add_query:boolean',
            'enabled:boolean',
            'date_cr',
            'date_up',
            'user_id',
            'user_ip',
            'joined',
            'joined_module',
        ],
    ]) ?>

</div>
