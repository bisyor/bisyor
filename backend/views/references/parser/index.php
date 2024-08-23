<?php

use johnitvn\ajaxcrud\CrudAsset;
use yii\helpers\Html;
/**
 * @var $this yii\web\View
 * @var $categories
 */

$this->title = 'Парсинг';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?php echo  Html::a('Выгрузить все', ['/references/parser/parsing-crone'], ['data-pjax'=>0,'title'=> 'Выгрузить','class'=>'btn btn-xs btn-success','data-toggle' => 'tooltip']); 
            ?>
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default"
               data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success"
               data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i
                        class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i
                        class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Список</h4>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped m-b-0">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Наименование</th>
                    <th>Категория</th>
                    <th width="1%"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $key => $category):?>
                <tr>
                    <td><?=$key?></td>
                    <td>Бандлик ва меҳнат муносабатлари вазирлигининг миллий вакансиялар базаси</td>
                    <td><?= $category['name']?></td>
                    <td class="with-btn" nowrap="">
                        <?= Html::a('Начать', ['/references/parser/parsing', 'category' => $key],
                                                 ['class' => 'btn btn-sm btn-primary width-60 m-r-2'])?>
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
