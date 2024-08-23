<?php

$this->title = 'Статистика просмотров';
$this->params['breadcrumbs'][] = $this->title;

/**
 * @var  $result
 * @var  $searchModel
 */
?>


<div class="panel panel-inverse user-index">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" id="search_colapse" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i <?=(empty($post)) ? 'class="fa fa-plus"' : 'class="fa fa-minus"'?>></i></a>
        </div>
        <h4 class="panel-title">Поиск </h4>
    </div>
    <div class="panel-body" id="search_panel">
        <?=$this->render('users/filter', ['searchModel' => $searchModel]);?>
    </div>
</div>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <!--<a href="/statistics/items-views?parent_id=<?php // $parent_id ?>" class="btn btn-xs btn-warning"><b>Назадь</b></a>-->
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Статистика просмотров контактов в категории</h4>
    </div>
    <div class="panel-body">
        <table class="table table-bordered" id="data-table">
            <thead>
            <tr>
                <th><span class="fa fa-list"></span> Категория</th>
                <th><span class="fa fa-eye"></span> Просмотр объявления</th>
                <th><span class="fa fa-phone"></span> Просмотр контакт</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($result as $value):?>
                <tr>
                    <td><a href="/statistics/items-views?parent_id=<?= $value['id'] ?>"><b><?= $value['title']?></b></a></td>
                    <td><?= number_format($value['item_views'], 0, '.', ' ') ?></td>
                    <td><?= number_format($value['contacts_views'], 0, '.', ' ') ?></td>
                </tr>

            <?php endforeach; ?>
            <tr>
                <td  style="background-color: #80d4ff">
                    <b>* * *</b>
                </td>
                <td style="background-color: #80d4ff">
                    <b>
                        <?= number_format(array_sum(array_column($result,'item_views')), 0, '.', ' ') ?>
                    </b>
                </td>
                <td style="background-color: #80d4ff">
                    <b>
                        <?= number_format(array_sum(array_column($result,'contacts_views')), 0, '.', ' ') ?>
                    </b>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
