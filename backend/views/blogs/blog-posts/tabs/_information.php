<?php

use yii\helpers\Html;
use backend\components\StaticFunction;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

$label = $model->attributeLabels();
?>
<?php Pjax::begin(['enablePushState' => false, 'id' => 'crud-datatable-pjax']) ?> 
<div class="row">
	<div class="col-md-12">
        <div class="table-responsive">
    		<table class="table table-bordered table-responsive">
       			<tbody>
            		<tr>
               			<td rowspan="5">
                   			<?=Html::img($model->getAvatar(), [
                        		'class' => '',
                        		'style' => 'object-fit: cover; width:165px; height:165px;', 'alt' => 'Avatar'
                   			])?>
                		</td>
            		</tr>
            		<tr>
            			<th>Категория</th>
            			<td><?=$model->blogCategories->name?></td>
            			<th>Наименование</th>
            			<td><?=$model->title?></td>
            			</tr>
            		<tr>
            			<th>Слуг</th>
            			<td>
                            <?=Html::a($model->getSlugLink() . ' <i class="fa fa-external-link"></i>', $model->getSlugLink(), ['target' => '_blank'])?>
                        </td>
            			<th>Создатель</th>
            			<td><?=$model->user->fio?></td>
            		</tr>
            		<tr>
            			<th>Дата создании</th>
            			<td><?=$model->getDateCr()?></td>
            			<th>Кол-во просмотров</th>
            			<td><?=$model->view_count?></td>
            		</tr>
            		<tr>
            			<th>Статус</th>
            			<td><?=$model->getStatusName()?></td>
            			<th>Короткое описание</th>
            			<td><?=$model->short_text?></td>
           			</tr>
       			</tbody>
    		</table>
        </div>
	</div>
</div>

<div class="form-group">
    <?=Html::a('<i class="fa fa-angle-double-left"></i> Назад', ['/blogs/blog-posts'], ['data-pjax' => '0', 'class' => 'btn btn-inverse', 'style' => ['margin' => '2px',]])?>
    <?=Html::a('<i class="glyphicon glyphicon-pencil"></i> Изменить', ['/blogs/blog-posts/update', 'id' => $model->id], ['data-pjax' => 1, 'class' => 'btn btn-info', 'style' => ['margin' => '2px',]])?>
</div>
<div class="row">
	<div class="col-md-12">
		<?=$model->text?>
 	</div>
 </div>
<?php Pjax::end() ?>
