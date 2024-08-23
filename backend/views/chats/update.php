<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Chats */
?>
<div class="chats-update">
	<?php 
		if($step == 1){
		    $this->render('_form', [
		        'model' => $model,
		    ]); 
		}
	?>

</div>
