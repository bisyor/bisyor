<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopsTariff */
?>
<div class="shops-tariff-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'abonement_id',
                'value' => function($data){
                    return $data['abonement']->title;
                }
            ],
            [
                'attribute'=>'date_cr',
                'value' => function($data){
                    return $data->getDate($data->date_cr);
                }
            ],
            [
                'attribute'=>'status',
                'format' => 'raw',
                'value' => function($data){
                    return $data->getStatusName();
                }
            ],
            [
                'attribute'=>'data_access',
                'value' => function($data){
                    return $data->getDate($data->data_access);
                }
            ],
            'price',
        ],
    ]) ?>

</div>
