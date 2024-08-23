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
						'/shops/shop-categories/change-active-cat?id='+id,function(success){
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
	<td style="width: 20%;">
		<img src="<?=\backend\models\shops\ShopCategories::getImageAddress($category['icon_b'])?>" style="width:20%;">
	</td>
	<td>
		<?=$category['title']?>
	<?php if (isset($category['childs'])): ?>
		</td>
		<td style="width: 9%; ">
			<?=\backend\models\shops\ShopCategories::getStatusTemplate($category['enabled'],$category['id'])?>
		</td>
		<td>
			<?=\yii\helpers\Html::a(
		        \backend\models\shops\ShopCategories::getShopsCount($category['id']), 
		        ['/shops/shops/index','id'=>$category['id']],['data-pjax'=>0,
	        ]);?>
		</td>

		<td style="width: 15%; ">
			<?php 
			echo \yii\helpers\Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/shops/shop-categories/create', 'id' => $category['id']], ['role'=>'modal-remote','title'=> 'Добавить cуб категория','data-toggle'=>'tooltip','class'=>'btn btn-primary']);
			 ?>
		</td>
		<td style="width: 2%;">
			<?=\yii\helpers\Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/shops/shop-categories/view','id' => $category['id']],['data-pjax' => 0,'title'=> 'Просмотр','data-toggle'=>'tooltip','class'=>'btn btn-xs btn-primary'])
	        ?>
	        <?php  $url = \yii\helpers\Url::to(['/shops/shop-categories/sorting', 'id' => $category['id']]);
	        	echo \yii\helpers\Html::a('<span class="glyphicon glyphicon-sort"></span>', $url, ['data-pjax'=>'0','title'=>'Сортировка', 'data-toggle'=>'tooltip','class'=>'btn btn-xs btn-warning']);
	        ?>
	        <?=\yii\helpers\Html::a(
	                        '<span class="glyphicon glyphicon-trash"></span>', 
	                        ['/shops/shop-categories/delete','id'=>$category['id']],[
	                            'role'=>'modal-remote','title'=>'Удалить', 
		                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
		                        'data-request-method'=>'post',
		                        'data-toggle'=>'tooltip',
		                        'data-confirm-title'=>'Подтвердите действие',
		                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?','class'=>'btn btn-xs btn-danger',
	                        ]);
	        ?>
		</td>
	</tr>
	<tr>
		<td colspan="7">
			<div class="panel" style="display:none;" id="category<?=$category['id']?>" style="margin:0 0 0 0;padding:0 0 0 0;" >
	            <div class="panel-heading" style="height: 30px;">
	                <b>Суб Категория</b>
	            </div>
	            <div class="panel-body" style="margin:10px 0 0 0;padding:0 0 0 7px;">
	           		<table class="table table-bordered">
						<tr>
						    <th style="">
						       № 
						    </th>
				            <th style="width:2%;">
				                        
				            </th>
				            <th style="width: 20%; ">
						        Фото
						    </th>
						    <th style="">
		                        Названия
		                    </th>
	                        <th style="width: 9%; ">
		                        Статус
		                    </th>
		                    <th>
		                        Магазины
		                    </th>
						    <th style="width: 10%; ">
						    	Суб-категория
						    </th>
						    <th style="width: 5%;">
						        Действия
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

	<td style="width: 9%; ">
		<?=\backend\models\shops\ShopCategories::getStatusTemplate($category['enabled'],$category['id'])?>
	</td>
	<td>
		<?=\yii\helpers\Html::a(
	        \backend\models\shops\ShopCategories::getShopsCount($category['id']), 
	        ['/shops/shops/index','id'=>$category['id']],['data-pjax'=>0,
	            // 'style'=>'font-size:20px;'
        ]);?>
	</td>
	<td style="width: 15%; ">
		<?php 
		echo \yii\helpers\Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/shops/shop-categories/create', 'id' => $category['id']], ['role'=>'modal-remote','title'=> 'Добавить cуб категория','data-toggle'=>'tooltip','class'=>'btn btn-primary']);
		 ?>
	</td>
	<td style="width: 2%;">
		<?=\yii\helpers\Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/shops/shop-categories/view','id' => $category['id']],['data-pjax' => 0,'title'=> 'Просмотр','data-toggle'=>'tooltip','class'=>'btn btn-xs btn-primary'])
        ?>
        <?=\yii\helpers\Html::a(
                        '<span class="glyphicon glyphicon-trash"></span>', 
                        ['/shops/shop-categories/delete','id'=>$category['id']],[
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
