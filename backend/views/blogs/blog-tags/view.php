<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BlogTags */
?>
<div class="blog-tags-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
