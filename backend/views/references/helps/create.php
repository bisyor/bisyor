<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Helps */
$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => "Вопросы", 'url' => ['/references/helps/index', 'help_id' => $model->helps_categories_id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="helps-create">
    <?= $this->render('_form', [
        'model' => $model,
        'textes' => $textes,
        'names' => $names,
        'post' => $post,
        'langs' => $langs,
    ]) ?>
</div>
