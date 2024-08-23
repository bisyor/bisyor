<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopsRating */
?>
<div class="shops-rating-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ball',
            [
                'attribute' => 'user_id',
                'value' => function($data){
                    return $data->user->fio;
                }
            ],
            'date_cr',
        ],
    ]) ?>

</div>
