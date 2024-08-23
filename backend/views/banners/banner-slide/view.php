<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BannersItems */
?>
<div class="banners-items-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'banner_id',
            'type',
            'type_data:ntext',
            'img',
            'sitemap_id:ntext',
            'category_id:ntext',
            'locale:ntext',
            'url_match:ntext',
            'url_match_exact:boolean',
            'click_url:ntext',
            'url:url',
            'show_start',
            'show_finish',
            'show_limit',
            'title',
            'description:ntext',
            'alt',
            'enabled',
            'date_cr',
            'list_pos',
            'target_blank:boolean',
            'sorting_number',
            'time:datetime',
        ],
    ]) ?>

</div>
