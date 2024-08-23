<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\shops\ShopsClaims */

$this->title = 'Create Shops Claims';
$this->params['breadcrumbs'][] = ['label' => 'Shops Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shops-claims-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
