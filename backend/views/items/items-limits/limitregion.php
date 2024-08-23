<?php
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 01.06.2020
 * Time: 16:26
 */

use yii\helpers\Html; ?>
<div class="col-md-12">
    <span>Регионалний стоимост</span>
    <?= Html::a(' Добавить регион <i class="fa fa-plus"></i>', ['reg-cat-create', 'id' => $model['id'], 'type'=>$model['shop']],
        ['role'=>'modal-remote','title'=> 'Добавить','class'=>'pull-right btn btn-xs btn-success'])?>
    <a href="javascript:;" onclick="$.ajax({
        url: '/items/items-limits/category',
        type: 'POST',
        data: {type: <?=$model['shop']?>},
        success: function(data) { if(data){$('#<?=$model['shop'] == 0 ? 'items':'shops'?>-cat-reg').html(data);}}
        });" class="pull-right btn btn-xs btn-warning">Назадь </a>
    <br>
    <br>
    <table class="table table-bordered">
        <tr>
            <th>Регионы</th>
            <th width="150px">Стоимость</th>
        </tr>
        <?php  $title = unserialize($model['title']);
            if($title['regs']):?>
            <tr>
                <td><?php $str = ''; foreach ($title['regs'] as $region){
                        $str .= $region['t'].", ";
                    } echo rtrim($str, ", "); ?></td>
                <td>От <?=$title['min']?> До <?=$title['max']?></td>
            </tr>
        <?php else:;?>
        <tr><td colspan="2" class="text-center">Ничего не найдено.</td></tr>
        <?php endif;?>
    </table>
</div>
