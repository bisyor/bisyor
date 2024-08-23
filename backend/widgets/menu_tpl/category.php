<tr>
	<td style="width: 1%;font-weight: bold;">
		<?=$i?>
	</td>
	<?php if (isset($category['childs'])): ?>
		<td style="width:1%;text-align: center">
			<a href="javascript:;" onclick="
				var id = <?=$category['id']?>;
				var span = $(this).children('span');
				$.post(
						'/items/categories/change-active-cat?id='+id,function(success){
							if(success == 'deleted'){
								span.removeClass('glyphicon-collapse-down');
								span.addClass('glyphicon-expand');
							}else{
								span.removeClass('glyphicon-expand');
								span.addClass('glyphicon-collapse-down');
							}
					});
				$('#category'+id).toggle(200); 
				" 
				class="btn" id="ahref<?=$category['id']?>">
				<span class="glyphicon glyphicon-expand"></span>
			</a>
		</td>
	<?php else: ?>
		<td></td>
	<?php endif ?>
	<td>
		<?=$category['title']?>
	<?php if (isset($category['childs'])): ?>
		</td>
		<td>
            <?=$category['items_count']?>
		</td>
		<td style="width: 6%;">
			<?php if ($category['address']): ?>
				<i class="fa fa-lg fa-check"></i>
			<?php endif ?>	
		</td>
		<td style="width: 6%;">
			<?php if ($category['price']): ?>
				<i class="fa fa-lg fa-check"></i>
			<?php endif ?>	
		</td>
		<td style="width: 10%;">
			
			<?=\yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/items/categories/update','id' => $category['id']],['data-pjax' => 0,'title'=> 'Изменить','data-toggle'=>'tooltip','class'=>'btn btn-xs btn-primary'])
	        ?>
	        <?=\yii\helpers\Html::a('<span class="fa fa-cogs"></span>', ['/items/categories/settings','id' => $category['id'],'name' => $category['title']],['data-pjax' => 0,'title'=> 'Настройки','data-toggle'=>'tooltip','class'=>'btn btn-xs btn-warning'])
	        ?>
	        <?php  $url = \yii\helpers\Url::to(['/items/categories/sorting', 'id' => $category['id']]);
	        	echo /*\yii\helpers\Html::a('<span class="glyphicon glyphicon-sort"></span>', $url, ['data-pjax'=>'0','title'=>'Сортировка', 'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-warning'])*/"";
	        ?>
 
 	        <?= \yii\helpers\Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/items/categories/create', 'id' => $category['id']], ['data-pjax'=>0,'title'=> 'Добавить cуб категория','data-toggle'=>'tooltip','class'=>'btn btn-xs btn-success']);
			 ?>
		</td>
	</tr>
	<tr>
		<td colspan="7" style="height: 0px !important;margin:0px !important; padding: 0px !important;">
			<div class="panel" style="display:none;" id="category<?=$category['id']?>" style="margin:0 0 0 0;padding:0 0 0 0;" >
	            <div class="panel-heading">
					<h4 class="panel-title"><b>Суб Категория</b></h4>
				</div>
	            <div class="panel-body" style="margin:10px 0 0 0;padding:0 0 0 7px;">
	           		<table class="table table-bordered">
						<tr>
						    <th style="">
						       № 
						    </th>
				            <th style="width:2%;">
				            </th>
						    <th style="">
		                        Названия
		                    </th>
		                    <th>
		                        Объявления
		                    </th>
		                    <th style="width: 5%; ">
		                        Карта 
		                    </th>
		                    <th style="width: 5%; ">
		                        Цена 
		                    </th>
						    <th style="width: 8%;">
						        <!-- Действия -->
								<?php  $url = \yii\helpers\Url::to(['/items/categories/sorting','id' => $category['id']]);
									echo \yii\helpers\Html::a('<span class="glyphicon glyphicon-sort"></span>  Сортировка', $url, [
										'data-pjax'=>'0',
										'title'=>'Сортировка',
										'data-toggle' => 'tooltip',
										'class' => 'btn btn-xs btn-warning',
										'style' => 'margin-top:0px;'
										]);?>
						    </th>
						</tr>
							<?= $this->getMenuHtml($category['childs']) ?>
						</table>
	            </div>      
	        </div>
		</td>
	</tr>
    <?php else: ?>
	</td>
	<td>
        <?=$category['items_count']?>
	</td>
	<td style="width: 6%;">
		<?php if ($category['address']): ?>
				<i class="fa fa-lg fa-check"></i>
		<?php endif ?>
	</td>
	<td style="width: 6%;">
		<?php if ($category['price']): ?>
				<i class="fa fa-lg fa-check"></i>
		<?php endif ?>	
	</td>
	<td style="width: 10%;">
		
		<?=\yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/items/categories/update','id' => $category['id']],['data-pjax' => 0,'title'=> 'Изменить','data-toggle'=>'tooltip','class'=>'btn btn-xs btn-primary'])
        ?>
		<?=\yii\helpers\Html::a('<span class="fa fa-cogs"></span>', ['/items/categories/settings','id' => $category['id'],'name' => $category['title']],['data-pjax' => 0,'title'=> 'Настройки','data-toggle'=>'tooltip','class'=>'btn btn-xs btn-warning'])
        ?>
        <?= \yii\helpers\Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/items/categories/create', 'id' => $category['id']], ['data-pjax'=>0,'title'=> 'Добавить cуб категория','data-toggle'=>'tooltip','class'=>'btn btn-xs btn-success']);
		 ?>
        <?=\yii\helpers\Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>', 
                        ['/items/categories/delete','id'=>$category['id']],[
                            'role'=>'modal-remote','title'=>'Удалить', 
							'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
							'data-request-method'=>'post',
							'data-toggle'=>'tooltip',
							'data-confirm-title'=>'Подтвердите действие',
							'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
							'class'=>'btn btn-xs btn-danger',
                        ]);
        ?>
	</td>
	<?php endif ?>
</tr>
<script type="text/javascript">
	var s = "<?=Yii::$app->session['categories']?>";
	if(s != "") {
		arr = s.split(',');
		for(i =0; i< arr.length; i++)
		{
			var el = document.getElementById('category' + arr[i]);
			if(el)
				el.style = 'display : block';
			var a = document.getElementById('ahref' + arr[i]);
			var span = a.getElementsByTagName("span")[0];
			a.innerHTML = '<span class="glyphicon glyphicon-collapse-down"></span>';
		}
	}
</script>
