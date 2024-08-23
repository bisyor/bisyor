<?php 
use yii\helpers\Html;

?>
<div class="row">
	<div class="col-md-12">
		<div class="">
			<h4 class="block"><?= $model->name?></h4>
			<p class="">Голосов: &nbsp&nbsp&nbsp<?= $model->getVotes()?></p>
		</div>
	</div>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Пользователь</th>
            <th>Вариант</th>
        </tr>
    </thead>
    <tbody>
    	<?php $i= 1; foreach ($model->getUsersVote() as $key => $value):?>
	        <tr>
	            <td><?= $i ?></td>
	            <td><p class=""><?= $model->getUsersPersonal($value->id)?></p></td>
	            <td><p class=""><?= $value->item->title?></p></td>
	        </tr>
       	<?php $i++; endforeach; ?>
    </tbody>
</table>
<?= Html::a( 'Назад', ['index'],['class' => 'btn btn-inverse']) ?>