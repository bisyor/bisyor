<?php

use yii\helpers\Html;
use backend\components\StaticFunction;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/**
 * @var $model backend\models\banners\Banners
 */

?>
<?php Pjax::begin(['enablePushState' => false, 'id' => 'crud-datatable-pjax']) ?> 
<div class="row">
	<div class="col-md-12">
        <div class="table-responsive">
    		<table class="table table-bordered table-responsive">
       			<tbody> 
            		<tr>
            			<th>Наименование рекламы</th>
            			<td><?=$model->title?></td>
            		</tr>
            		<tr>
            			<th>Ключ</th>
            			<td><?=$model->keyword?></td>
                    </tr>
                    <tr>
            			<th>Статус</th>
            			<td><?=$model->getStatusName()?></td>
            		</tr>
            		<tr>
            			<th>Ширина</th>
                        <td><?=$model->width?></td>
                    </tr>
                    <tr>
            			<th>Высота</th>
                        <td><?=$model->height?></td>
            		</tr>
            		<tr>
            			<th>Скрывать для авторизованных пользователей</th>
            		    <td><?=$model->getStatusList()?></td>
           			</tr>
       			</tbody>
    		</table>
        </div>
	</div>
</div>

    <?=Html::a('<i class="fa fa-angle-double-left"></i> Назад', ['/banners/banner'], ['data-pjax' => '0', 'class' => 'btn btn-inverse'])?>
    <?=Html::a('<i class="glyphicon glyphicon-pencil"></i> Изменить', ['/banners/banner/update', 'id' => $model->id], ['data-pjax' => '0', 'class' => 'btn btn-info'])?>
 
<?php Pjax::end() ?>
