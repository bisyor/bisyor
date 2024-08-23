<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Lang */
?>
<div class="lang-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'url:url',
            'local',
            'name',
            'image',
            'default',
            // 'create',
            [
                'attribute' => 'status',
                'value' => $model->getStatusType(),
            ],
            'date_update:date',
            'date_create:date',
        ],
    ]) ?>

</div>
