<?php 
use yii\widgets\DetailView;
use backend\components\StaticFunction;
use yii\helpers\Html;
?>
<div class="row">
	<div class="col-md-7 text-center">
		<?= DetailView::widget([
	        'model' => $model,
	        'attributes' => [
	            [
	                  'attribute' => 'fio',
	                  'label' => 'Пользователь',
	                  'value' => function($data){
	                        return $data->getUserFio();
	                  }
	            ],
	            [
	                  'label' => 'Магазин',
	                  'format' => 'raw',
	                  'value' => function($data){
	                        return $data->getUserShop();
	                  }
	            ],
	            [	
	            	  'attribute' => 'balance',
	                  'format' => 'raw',
	                  'value' => function($data){
	                        return $data->balance." Сум";
	                  }
	            ],
	            'phone',
	            'email',
	            [
	            	'attribute' => 'registry_date',
	            	'value' => function($data){
	            		return date("H:i d.m.Y", strtotime($data->registry_date));
	            	}
				],
	            [
	            	'attribute' => 'district_id',
	            	'value' => function($data){
	            		return $data->district_id ? $data->district->name : '';
	            	}
	            ],
	            [
	            	'attribute' => 'phones',
	            	'value' => function($data){
	            		return StaticFunction::getHistoryType($data->phones);
	            	}
	            ]
	        ],
      	]) ?>
	</div>
	<div class="col-md-5 text-center">
		<img src="<?=$model->getAvatarForSite()?>" style="width: 85%;">
	</div>
</div>
<div class="row">
	<div class="col-md-7 text-center">
		<?=Html::a('<i class="fa fa-pencil"></i> написать сообщение',['/chats/new-chats','id'=>$model->id],['class'=>'btn btn-sm btn-default pull-left'])?>
		<?=Html::a('<i class="fa fa-tasks"></i> объявления('.$model->getItemsCount().')',['/items/items/index','user_id'=>$model->id],['class'=>'btn btn-sm btn-default pull-right','style' => 'margin-right:6px;'])?>	
	</div>
	<div class="col-md-5 text-center" >
		<?php if ($model->status == 1): ?>
			<button type="button" onclick="$.post('/bills/bills/change-status-user?id=' + <?=$model->id?> + '&status=2',function(success){location.reload(true);})" class="btn btn-sm btn-danger centered"><i class="fa fa-lock"></i> заблокировать</button>
		<?php else: ?>
			<button type="button" onclick="$.post('/bills/bills/change-status-user?id=' + <?=$model->id?> + '&status=1',function(success){location.reload(true);})" class="btn btn-sm btn-success centered"><i class="fa fa-unlock"></i> разблокировать</button>
		<?php endif ?>
	</div>		
</div>