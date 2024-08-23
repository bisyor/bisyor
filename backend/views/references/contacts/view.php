<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Contacts */
?>
<div class="contacts-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [ 
            [
                'attribute' => 'type',
                'value' => $model->getTypeDesc(),
            ],
            [
                'attribute' => 'user_id',
                'value' => $model->getUserFio(),
            ],
            'user_ip',
            'name',
            'email:email',
            'message:ntext',
            'useragent:ntext',
            [
                'attribute' => 'date_cr',
                'value' => $model->getDateCr(),
            ],
            [
                'attribute' => 'date_up',
                'value' => $model->getDateUp(),
            ],
            'viewed:boolean',

        ],
    ]) ?>

</div>
