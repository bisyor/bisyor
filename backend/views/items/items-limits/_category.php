<?php
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 03.06.2020
 * Time: 11:11
 */

use yii\helpers\Html; ?>
<div class="col-md-12">
    <?= Html::a('Добавить категорию <i class="fa fa-plus"></i>', ['create-cat-reg', 'type' => $type],
        ['role'=>'modal-remote','title'=> 'Добавить','class'=>'pull-right btn btn-xs btn-success'])?>
    <br><br>
    <table class="table table-bordered">
        <tr>
            <th>Категория</th>
            <th>Стоимость</th>
            <th  width="60px;">	Активно</th>
            <th  width="150px;">Действия</th>
        </tr>
        <?php foreach ($model as $cat):
            $title = unserialize($cat->title);?>
            <tr>
                <td><?=$cat->category->title ?></td>
                <td>От <?=$title['min']?> До <?=$title['max']?></td>
                <td><input type="checkbox" <?=$cat->enabled == 1 ? 'checked=""':''?> onchange="$.post('/items/items-limits/set-enabled-regions', {id:<?=$cat->id?>}, function(data) {});"></td>
                <td><a href="javascript:;" onclick="$.ajax({
                        url: '/items/items-limits/cat-reg',
                        type: 'POST',
                        data: {id : <?=$cat->id?>},
                        success: function(data) { if(data){$('#<?=$type == 0 ? 'items':'shops'?>-cat-reg').html(data);}}
                        });" class="btn btn-xs btn-inverse"><span class="glyphicon glyphicon-globe"></span></a>
                    <?=Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update-cat-reg', 'id' => $cat['id']], ['class' => 'btn btn-xs btn-info', 'role' => 'modal-remote'])?>
                    <?=Html::a('<span class="glyphicon glyphicon-trash"></span>', ['region-del', 'id' => $cat['id']], ['role'=>'modal-remote','title'=>'Удалить', 'class' => 'btn btn-danger btn-xs',
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-toggle'=>'tooltip',
                        'data-confirm-title'=>'Подтвердите действие',
                        'data-confirm-message'=>'Вы уверены что хотите удалить этого элемента?',
                    ])?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
</div>
