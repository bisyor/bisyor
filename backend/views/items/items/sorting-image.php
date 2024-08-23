<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\items\Items;

?>

<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-inverse" data-sortable-id="ui-widget-1" data-init="true" style="">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
		</div>
		<h4 class="panel-title">Сортировка</h4>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<ul id="image-list1" class="sortable-list">
					<?php 
						$imageIdList = ""; 
						foreach ($upload_images as $key => $value): 
							if($imageIdList == '') $imageIdList = $key;
							else $imageIdList .= ';' . $key;
					?>
						<li id="<?=$key?>">
							<div class="image_preview_class">
								<span class="product_item">
									<img src="<?= Items::getImageAdress($value, "") ?>">
								</span>
							</div>
						</li>
					<?php endforeach ?>
				</ul>
				<div class="form-group">
			        <?= Html::submitButton('Сохранить сортировку', ['class' => 'btn btn-success']) ?>
			        <?= Html::a('Назад', ['update', 'id' => $model->id], ['data-pjax' => '0', 'title'=> 'Назад','class'=>'btn btn-inverse']); ?>
			    </div>
			</div>
		</div>
		<input type="hidden" name="idList" id="idList" value="<?=$imageIdList?>">
	</div>
</div>
<?php ActiveForm::end(); ?>

<style type="text/css">

ul#image-list1 {
    list-style: none;
    padding: 0;
}

.sortable-list li { 
    position: relative; 
    min-height: 12em;
    cursor: move;
    padding: .5em .5em .5em 2.5em;
    background: #eee;
    border: 1px solid #ccc;
    margin: .7em 0;
    border-radius: .25em;
    max-width: 28em;
    max-height: 14em;
}

.product_item>img {
    width: 100%;
    -o-object-fit: cover;
    object-fit: cover;
    height: 13em;
</style>

<script type="text/javascript">
	$('.sortable-list').sortable({
		connectWith: '.sortable-list',
	  	update: function(event, ui) {
	    	var changedList = this.id;
	    	var order = $(this).sortable('toArray');
	    	var positions = order.join(';');
	    	$('#idList').val(positions);
	    	console.log({
	      		id: changedList,
	      		positions: positions
	    	});
	  	}
	});
</script>