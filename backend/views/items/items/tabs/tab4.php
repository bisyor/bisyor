<?php $q = 1; ?>
<table class="table table-bordered">
    <tbody>
    	<?php if (strtotime($model->svc_up_date) > time()){ ?>
    		<tr>
    			<td style="width: 20%;">Поднято</td>
				<th>
					<?=date('d.m.Y',strtotime($model->svc_up_date))?>
				</th>
    		</tr>
		<?php $q = 0; } ?>
       	<?php if (strtotime($model->svc_premium_to) > time()){ ?>
    		<tr>
    			<td style="width: 20%;">Премиум до </td>
				<th>
					<?=date('d.m.Y',strtotime($model->svc_premium_to))?>
				</th>
    		</tr>
		<?php $q = 0; } ?>
		<?php if (strtotime($model->svc_fixed_to) > time()){ ?>
    		<tr>
    			<td style="width: 20%;">Закрепление</td>
				<th>
					<?=date('d.m.Y',strtotime($model->svc_fixed_to))?>
				</th>
    		</tr>
		<?php $q = 0; } ?>
		<?php if (strtotime($model->svc_marked_to) > time()){ ?>
    		<tr>
    			<td style="width: 20%;">Выделение</td>
				<th>
					<?=date('d.m.Y',strtotime($model->svc_marked_to))?>
				</th>
    		</tr>
		<?php $q = 0; } ?>
		<?php if (strtotime($model->svc_quick_to) > time()){ ?>
    		<tr>
    			<td style="width: 20%;">Срочно</td>
				<th>
					<?=date('d.m.Y',strtotime($model->svc_quick_to))?>
				</th>
    		</tr>
		<?php $q = 0; } ?>
		<?php if (strtotime($model->svc_press_date) > time()){ ?>
    		<tr>
    			<td style="width: 20%;">Публикация в прессе</td>
				<th>
					<?=date('d.m.Y',strtotime($model->svc_press_date))?>
				</th>
    		</tr>
		<?php $q = 0; } ?>
    </tbody>
</table>
<?php if ( $q == 1 ): ?>
<p class="text-muted">Нет активированных на текущий момент услуг</p>
<?php endif ?>
<br>
<a href="<?=\yii\helpers\Url::to(['/bills/bills/index', 'item_id' => $model->id])?>">История активации услуг объявления № <?=$model->id?></a>