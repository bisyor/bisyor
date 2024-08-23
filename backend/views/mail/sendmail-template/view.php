<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\mail\SendmailTemplate */
?>
<div class="sendmail-template-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'content:ntext',
            'is_html:boolean',
            'num',
            'date_cr',
            'date_up',
        ],
    ]) ?>

</div>
