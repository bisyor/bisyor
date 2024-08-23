<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopSlider */
?>
<div class="shop-slider-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'format' => 'raw',
                'attribute' => 'image',
                'value' => function($data){
                    return $data->getImg('100px','100px');
                }
            ],
            'title',
            'text:ntext',
            'link',
        ],
    ]) ?>

</div>
