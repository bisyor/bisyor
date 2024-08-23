<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $itemsInput backend\models\items\ItemsLimits */
/* @var $itemsCat backend\models\items\ItemsLimits */
/* @var $itemsPrice backend\models\items\ItemsLimits */
/* @var $itemsRegions backend\models\items\ItemsLimits */
/* @var $shopsInput backend\models\items\ItemsLimits */
/* @var $shopsCat backend\models\items\ItemsLimits */
/* @var $shopsRegions backend\models\items\ItemsLimits */
/* @var $shopsPrice */
/* @var $catRegShops */

$this->title = 'Лимиты';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
    <div class="items-limits-index">
        <div class="panel panel-inverse user-index">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default"
                       data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success"
                       data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                       data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                       data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Список</h4>
            </div>
            <div class="panel-body" style="padding: 0">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#default-tab-1" data-toggle="tab">Объявления</a></li>
                    <li><a href="#default-tab-2" data-toggle="tab">Магазины</a></li>
                    <li><a href="#default-tab-3" data-toggle="tab">Настройки</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="default-tab-1">
                        <p>Общий лимит бесплатных во <input type="number"
                                                            onchange="$.post('/items/items-limits/set-value', {id:<?= $itemsInput->id ?>, value: $(this).val(), type:'items'}, function(data) {});"
                                                            class="form-control input-sm"
                                                            style="width: 100px; display: inline"
                                                            value="<?= $itemsInput->items ?>"> всех категориях, если не
                            указано конкретно:</p>
                        <?= Html::a(
                            'Добавить категорию <i class="fa fa-plus"></i>',
                            ['create', 'type' => 0],
                            [
                                'role' => 'modal-remote',
                                'title' => 'Добавить',
                                'class' => 'pull-right btn btn-xs btn-success'
                            ]
                        ) ?>
                        <br>
                        <div class="ajaxCrudDatatable">
                            <?= GridView::widget(
                                [
                                    'id' => 'crud-datatable',
                                    'dataProvider' => $itemsCat,
                                    'filterModel' => false,
                                    'tableOptions' => ['class' => 'table table-bordered'],
                                    'pjax' => true,
                                    'columns' => require(__DIR__ . '/_columns.php'),
                                    'striped' => true,
                                    'condensed' => true,
                                    'responsive' => true,
                                    'responsiveWrap' => true,
                                    'pager' => [
                                        'firstPageLabel' => 'Первый',
                                        'lastPageLabel' => 'Последный'
                                    ],
                                    'panelBeforeTemplate' => false,
                                    'panel' => [
                                        'headingOptions' => ['style' => 'display: none;'],
                                        'after' => '<div class="clearfix"></div>',
                                    ]
                                ]
                            ) ?>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><b>Общая стоимость сверх лимита:</b>во всех категориях, всех регионах,
                                если не указано <br>
                                <a href="javascript:;" id="button-items"><span class="glyphicon glyphicon-globe"></span>
                                    Региональная стоимость</a>
                            </div>
                            <div class="col-md-4">
                                <?php
                                foreach ($itemsPrice as $item) : ?>
                                    <p><input type="checkbox" <?= $item['checked'] == 1 ? 'checked' : '' ?>
                                              onchange="$.post('/items/items-limits/set-value', {id:<?= $item['id'] ?>, type:'price_check'}, function(data) {});"> <?= $item['items'] ?>
                                        обявления- <input class="form-control input-sm" type="number"
                                                          value="<?= $item['price'] ?>"
                                                          onchange="$.post('/items/items-limits/set-value', {id:<?= $item['id'] ?>, value: $(this).val(), type:'price_val'}, function(data) {});"
                                                          style="width: 100px; display: inline"> сум <?= Html::a(
                                            '<i class="fa fa-edit"></i>',
                                            ['update-price-limit', 'id' => $item['id'], 'type' => 0],
                                            [
                                                'role' => 'modal-remote',
                                                'title' => 'Изменит',
                                                'class' => 'pull-right btn btn-xs btn-success'
                                            ]
                                        ) ?></p>
                                <?php
                                endforeach; ?>
                            </div>
                            <div class="col-md-5"> <?= Html::a(
                                    'Добавить лимит <i class="fa fa-plus"></i>',
                                    ['add-item', 'type' => 0],
                                    [
                                        'role' => 'modal-remote',
                                        'title' => 'Добавить',
                                        'class' => 'pull-right btn btn-xs btn-success'
                                    ]
                                ) ?></div>
                        </div>
                        <div class="row hide" id="regions-items">
                            <div class="col-md-12">
                                <?= Html::a(
                                    'Добавить регион <i class="fa fa-plus"></i>',
                                    ['region-create', 'type' => 0],
                                    [
                                        'role' => 'modal-remote',
                                        'title' => 'Добавить',
                                        'class' => 'pull-right btn btn-xs btn-success'
                                    ]
                                ) ?>
                                <br><br>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Регионы</th>
                                        <th>Стоимость</th>
                                        <th width="60px;"> Активно</th>
                                        <th width="60px;">Действия</th>
                                    </tr>
                                    <?php
                                    foreach ($itemsRegions as $region) :
                                        $title = unserialize($region->title);
                                        ?>
                                        <tr>
                                            <td><?php
                                                foreach ($title['regs'] as $key => $item) {
                                                    echo $item['t'] . ", ";
                                                } ?></td>
                                            <td>От <?= $title['min'] ?> До <?= $title['max'] ?></td>
                                            <td><input type="checkbox" <?= $region->enabled == 1 ? 'checked=""' : '' ?>
                                                       onchange="$.post('/items/items-limits/set-enabled-regions', {id:<?= $region->id ?>}, function(data) {});">
                                            </td>
                                            <td>
                                                <?= Html::a(
                                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                                    ['region-edit', 'id' => $region->id],
                                                    ['class' => 'btn btn-xs btn-info', 'role' => 'modal-remote']
                                                ) ?>
                                                <?= Html::a(
                                                    '<span class="glyphicon glyphicon-trash"></span>',
                                                    ['region-del', 'id' => $region->id],
                                                    [
                                                        'role' => 'modal-remote',
                                                        'title' => 'Удалить',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'data-confirm' => false,
                                                        'data-method' => false, // for overide yii data api
                                                        'data-request-method' => 'post',
                                                        'data-toggle' => 'tooltip',
                                                        'data-confirm-title' => 'Подтвердите действие',
                                                        'data-confirm-message' => 'Вы уверены что хотите удалить этого элемента?',
                                                    ]
                                                ) ?>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach; ?>
                                </table>
                            </div>
                        </div>
                        <div id="items-cat-reg" class="row">
                            <div class="col-md-12">
                                <?= Html::a(
                                    'Добавить категорию <i class="fa fa-plus"></i>',
                                    ['create-cat-reg', 'type' => 0],
                                    [
                                        'role' => 'modal-remote',
                                        'title' => 'Добавить',
                                        'class' => 'pull-right btn btn-xs btn-success'
                                    ]
                                ) ?>
                                <br><br>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Категория</th>
                                        <th>Стоимость</th>
                                        <th width="60px;"> Активно</th>
                                        <th width="150px;">Действия</th>
                                    </tr>
                                    <?php
                                    foreach ($catReg as $cat) :
                                        $title = unserialize($cat->title); ?>
                                        <tr>
                                            <td><?= $cat->category->title ?></td>
                                            <td>От <?= $title['min'] ?> До <?= $title['max'] ?></td>
                                            <td><input type="checkbox" <?= $cat->enabled == 1 ? 'checked=""' : '' ?>
                                                       onchange="$.post('/items/items-limits/set-enabled-regions', {id:<?= $cat->id ?>}, function(data) {});">
                                            </td>
                                            <td><a href="javascript:;" onclick="$.ajax({
                                                        url: '/items/items-limits/cat-reg',
                                                        type: 'POST',
                                                        data: {id : <?= $cat->id ?>},
                                                        success: function(data) {
                                                        if(data){
                                                        $('#items-cat-reg').html(data);
                                                        }
                                                        }
                                                        });" class="btn btn-xs btn-inverse"><span
                                                            class="glyphicon glyphicon-globe"></span></a>
                                                <?= Html::a(
                                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                                    ['update-cat-reg', 'id' => $cat['id']],
                                                    ['class' => 'btn btn-xs btn-info', 'role' => 'modal-remote']
                                                ) ?>
                                                <?= Html::a(
                                                    '<span class="glyphicon glyphicon-trash"></span>',
                                                    ['region-del', 'id' => $cat['id']],
                                                    [
                                                        'role' => 'modal-remote',
                                                        'title' => 'Удалить',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'data-confirm' => false,
                                                        'data-method' => false, // for overide yii data api
                                                        'data-request-method' => 'post',
                                                        'data-toggle' => 'tooltip',
                                                        'data-confirm-title' => 'Подтвердите действие',
                                                        'data-confirm-message' => 'Вы уверены что хотите удалить этого элемента?',
                                                    ]
                                                ) ?>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="default-tab-2">
                        <p>Общий лимит бесплатных во <input type="number"
                                                            onchange="$.post('/items/items-limits/set-value', {id:<?= $shopsInput->id ?>, value: $(this).val(), type:'items'}, function(data) {});"
                                                            class="form-control input-sm"
                                                            style="width: 100px; display: inline"
                                                            value="<?= $shopsInput->items ?>"> всех категориях, если не
                            указано конкретно:</p>
                        <?= Html::a(
                            'Добавить категорию <i class="fa fa-plus"></i>',
                            ['create', 'type' => 1],
                            [
                                'role' => 'modal-remote',
                                'title' => 'Добавить',
                                'class' => 'pull-right btn btn-xs btn-success'
                            ]
                        ) ?>
                        <br>
                        <div class="ajaxCrudDatatable">
                            <?= GridView::widget(
                                [
                                    'id' => 'datatable-shops',
                                    'dataProvider' => $shopsCat,
                                    'filterModel' => false,
                                    'tableOptions' => ['class' => 'table table-bordered'],
                                    'pjax' => true,
                                    'columns' => require(__DIR__ . '/_columns.php'),
                                    'striped' => true,
                                    'condensed' => true,
                                    'responsive' => true,
                                    'responsiveWrap' => true,
                                    'pager' => [
                                        'firstPageLabel' => 'Первый',
                                        'lastPageLabel' => 'Последный'
                                    ],
                                    'panelBeforeTemplate' => false,
                                    'panel' => [
                                        'headingOptions' => ['style' => 'display: none;'],
                                        'after' => '<div class="clearfix"></div>',
                                    ]
                                ]
                            ) ?>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><b>Общая стоимость сверх лимита:</b>во всех категориях, всех регионах,
                                если не указано <br>
                                <a href="javascript:;" id="button-shops"><span class="glyphicon glyphicon-globe"></span>
                                    Региональная стоимость</a>
                            </div>
                            <div class="col-md-4">
                                <?php
                                foreach ($shopsPrice as $item) : ?>
                                    <p><input type="checkbox" <?= $item['checked'] == 1 ? 'checked' : '' ?>
                                              onchange="$.post('/items/items-limits/set-value', {id:<?= $item['id'] ?>, type:'price_check_shop'}, function(data) {});"> <?= $item['items'] ?>
                                        обявления- <input class="form-control input-sm" type="number"
                                                          value="<?= $item['price'] ?>"
                                                          onchange="$.post('/items/items-limits/set-value', {id:<?= $item['id'] ?>, value: $(this).val(), type:'price_val_shop'}, function(data) {});"
                                                          style="width: 100px; display: inline"> сум  <?= Html::a(
                                            '<i class="fa fa-edit"></i>',
                                            ['update-price-limit', 'id' => $item['id'], 'type' => 1],
                                            [
                                                'role' => 'modal-remote',
                                                'title' => 'Изменит',
                                                'class' => 'pull-right btn btn-xs btn-success'
                                            ]
                                        ) ?></p>
                                <?php
                                endforeach; ?>
                            </div>
                            <div class="col-md-5"><?= Html::a(
                                    'Добавить лимит <i class="fa fa-plus"></i>',
                                    ['add-item', 'type' => 1],
                                    [
                                        'role' => 'modal-remote',
                                        'title' => 'Добавить',
                                        'class' => 'pull-right btn btn-xs btn-success'
                                    ]
                                ) ?></div>
                        </div>
                        <div class="row hide" id="regions-shop">
                            <div class="col-md-12">
                                <?= Html::a(
                                    'Добавить регионы <i class="fa fa-plus"></i>',
                                    ['region-create', 'type' => 1],
                                    [
                                        'role' => 'modal-remote',
                                        'title' => 'Добавить',
                                        'class' => 'pull-right btn btn-xs btn-success'
                                    ]
                                ) ?>
                                <br>
                                <br>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Регионы</th>
                                        <th>Стоимость
                                        <th width="60px;"> Активно</th>
                                        <th width="60px;">Действия</th>
                                    </tr>
                                    <?php
                                    foreach ($shopsRegions as $region) :
                                        $title = unserialize($region->title);
                                        ?>
                                        <tr>
                                            <td><?php
                                                foreach ($title['regs'] as $key => $item) {
                                                    echo $item['t'] . ", ";
                                                } ?></td>
                                            <td>От <?= $title['min'] ?> До <?= $title['max'] ?></td>
                                            <td><input type="checkbox" <?= $region->enabled == 1 ? 'checked=""' : '' ?>
                                                       onchange="$.post('/items/items-limits/set-enabled-regions', {id:<?= $region->id ?>}, function(data) {});">
                                            </td>
                                            <td>
                                                <?= Html::a(
                                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                                    ['region-edit', 'id' => $region->id],
                                                    ['class' => 'btn btn-xs btn-info', 'role' => 'modal-remote']
                                                ) ?>
                                                <?= Html::a(
                                                    '<span class="glyphicon glyphicon-trash"></span>',
                                                    ['region-del', 'id' => $region->id],
                                                    [
                                                        'role' => 'modal-remote',
                                                        'title' => 'Удалить',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'data-confirm' => false,
                                                        'data-method' => false, // for overide yii data api
                                                        'data-request-method' => 'post',
                                                        'data-toggle' => 'tooltip',
                                                        'data-confirm-title' => 'Подтвердите действие',
                                                        'data-confirm-message' => 'Вы уверены что хотите удалить этого элемента?',
                                                    ]
                                                ) ?>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach; ?>
                                </table>
                            </div>
                        </div>
                        <div id="shops-cat-reg" class="row">
                            <div class="col-md-12">
                                <?= Html::a(
                                    'Добавить категорию <i class="fa fa-plus"></i>',
                                    ['create-cat-reg', 'type' => 1],
                                    [
                                        'role' => 'modal-remote',
                                        'title' => 'Добавить',
                                        'class' => 'pull-right btn btn-xs btn-success'
                                    ]
                                ) ?>
                                <br><br>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Категория</th>
                                        <th>Стоимость</th>
                                        <th width="60px;"> Активно</th>
                                        <th width="150px;">Действия</th>
                                    </tr>
                                    <?php
                                    foreach ($catRegShops as $cat) :
                                        $title = unserialize($cat->title); ?>
                                        <tr>
                                            <td><?= $cat->category->title ?></td>
                                            <td>От <?= $title['min'] ?> До <?= $title['max'] ?></td>
                                            <td><input type="checkbox" <?= $cat->enabled == 1 ? 'checked=""' : '' ?>
                                                       onchange="$.post('/items/items-limits/set-enabled-regions', {id:<?= $cat->id ?>}, function(data) {});">
                                            </td>
                                            <td><a href="javascript:;" onclick="$.ajax({
                                                        url: '/items/items-limits/cat-reg',
                                                        type: 'POST',
                                                        data: {id : <?= $cat->id ?>},
                                                        success: function(data) { if(data){$('#shops-cat-reg').html(data);}}
                                                        });" class="btn btn-xs btn-inverse"><span
                                                            class="glyphicon glyphicon-globe"></span></a>
                                                <?= Html::a(
                                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                                    ['update-cat-reg', 'id' => $cat['id']],
                                                    ['class' => 'btn btn-xs btn-info', 'role' => 'modal-remote']
                                                ) ?>
                                                <?= Html::a(
                                                    '<span class="glyphicon glyphicon-trash"></span>',
                                                    ['region-del', 'id' => $cat['id']],
                                                    [
                                                        'role' => 'modal-remote',
                                                        'title' => 'Удалить',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'data-confirm' => false,
                                                        'data-method' => false, // for overide yii data api
                                                        'data-request-method' => 'post',
                                                        'data-toggle' => 'tooltip',
                                                        'data-confirm-title' => 'Подтвердите действие',
                                                        'data-confirm-message' => 'Вы уверены что хотите удалить этого элемента?',
                                                    ]
                                                ) ?>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="default-tab-3">
                        <?=
                        $this->render(
                            'settings',
                            ['settings' => $settings]
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
Modal::begin(
    [
        "id" => "ajaxCrudModal",
        "footer" => "", // always need it for jquery plugin
    ]
) ?>
<?php
Modal::end(); ?>
<?php
$this->registerJs(
    <<<JS
$(document).ready(function(){
      $('#button-items').click(function(){;
        if($('#regions-items').hasClass('hide')){
            $('#regions-items').addClass('show').removeClass('hide');
        }else{
            $('#regions-items').removeClass('show').addClass('hide');
        }        
      });
      $('#button-shops').click(function(){;
        if($('#regions-shop').hasClass('hide')){
            $('#regions-shop').addClass('show').removeClass('hide');
        }else{
            $('#regions-shop').removeClass('show').addClass('hide');
        }        
      });
});
JS
); ?>