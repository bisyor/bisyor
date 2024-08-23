<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SocialNetworks */
?>
<div class="social-networks-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'icon',
            'status:boolean',
        ],
    ]) ?>

</div>
