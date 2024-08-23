<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Chats */
?>
<div class="chats-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'date_cr',
            'type',
            'course_id',
        ],
    ]) ?>

</div>
