<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopsClaims */
?>
<div class="shops-claims-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'user_id',
                'value' => function($data){
                    if($data->user_id != null) return $data->user->fio;
                }
            ],
            [
                'attribute'=>'reason',
                'value' => function($data){
                    return $data->getReasonDescription();
                }
            ],
            [
                'attribute'=>'message',
                'value' => function($data){
                    return $data->message;
                }
            ],
            [
                'attribute'=>'item_id',
                'format' => 'raw',
                'value' => function($data){
                    $url = Url::to(['/items/items/view', 'id' => $data->item_id]);
                    return Html::a('#' . $data->item_id, $url, [
                        'role'=>'modal-remote','title'=> 'Просмотр', 
                        'data-toggle'=>'tooltip','class'=>'btn btn-link'
                    ]);
                },
            ],
            [
                'attribute'=>'viewed',
                'format' => 'raw',
                'value' => function($data){
                    return $data->getYesNo();
                }
            ],
            [
                'attribute'=>'date_cr',
                'format' => 'raw',
                'value' => function($data){
                    return $data->getDate();
                }
            ],
        ],
    ]) ?>
</div>
