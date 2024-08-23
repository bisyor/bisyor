<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Sitemap */
?>
<div class="sitemap-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sitemap_id',
            'name',
            'type',
            'keyword',
            'link',
            'target:boolean',
            'is_system:boolean',
            'allow_submenu:boolean',
            'enabled:boolean',
            'date_cr',
        ],
    ]) ?>

</div>
