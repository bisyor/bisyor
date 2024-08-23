<?php
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopsClaims */
?>
<div class="shops-claims-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'shop_id',
                'value' => function($data){
                    return $data->shop->name;
                }
            ],
            [
                'attribute' => 'user_id',
                'value' => function($data){
                    return $data->user_id ? $data->user->fio : 'не задано';
                }
            ],
            [
                'attribute'=>'reason',
                'value' => function($data){
                    if($data->reason == 3)
                        return $data->message;
                    return $data->getReasonDescription();
                },
            ],
            [
                'attribute' => 'date_cr',
                'value' => function($data){
                    return $data->getDate();
                }
            ]
        ],
    ]) ?>
</div>
