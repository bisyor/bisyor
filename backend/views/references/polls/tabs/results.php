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
<br><br>
<?php $i = 1;$prosent =""; foreach ($model->getPollsItemsList() as  $value): ?>
	<?php  $prosent = $model->getVoteItemprosent($value->id); ?>
	<div class="row">
		<div class="col-md-2">
			<?php if($i == 1): ?>
				<h5><b><?=$model->attributeLabels()['varinat_otver'];?></b></h5>
			<?php endif; ?>
		</div>
		<div class="col-md-9">
			<p><dt><?= $value->title?></dt></p>
			<div class="progress progress-striped active">
                <div class="progress-bar progress-bar-info" style="width: <?=$prosent?>%"><?= $prosent ?>%</div>
            </div>
			
		</div>
	</div>
<?php $i++; endforeach; ?>
 <?= Html::a( 'Назад', ['index'],['class' => 'btn btn-inverse']) ?>