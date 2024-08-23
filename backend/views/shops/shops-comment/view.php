<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopsComment */
?>
<div class="shops-comment-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'enabled:boolean',
            'text:ntext',
            'user_ip',
            'fio'
        ],
    ]) ?>

</div>
