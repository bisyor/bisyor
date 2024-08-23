<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\Shops */
?>
<div class="shops-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'user_id',
            'name',
            'logo',
            'keyword',
            'status',
            'description:ntext',
            'district_id',
            // 'address:ntext',
            // 'coordinate_x',
            // 'coordinate_y',
            'phone',
            'phones:ntext',
            'site',
            'blocked_reaseon:ntext',
            'admin_comment:ntext',
            'social_networks:ntext',
            'date_cr',
            'date_up',
        ],
    ]) ?>

</div>
