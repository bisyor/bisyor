<?php
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 26.05.2020
 * Time: 11:53
 */

use backend\models\references\Regions;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\references\Districts;
/* @var $this yii\web\View */
/* @var $model backend\models\items\ItemsLimits */
/* @var $form yii\widgets\ActiveForm */
/* @var $items_sum */
?>

    <?php $form = ActiveForm::begin(['id' => 'region_form', 'method' => 'post']);?>
    <div class="row">
        <div class="col-md-2">Категория:</div>
        <div class="col-md-8">
            <b><?php if($model->cat_id == 0) echo 'Все категории';
                else echo $model->category->title;?></b>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-2">Стоимость:</div>
        <div class="col-md-8">
            <?php if ($model->isNewRecord):?>
                <?php foreach ($items_sum as $value):?>
                    <p><input type="checkbox" name="check_<?=$value['id']?>" <?= $value['checked'] ? 'checked':''?>> <?=$value['items']?> обявления-  <input class="form-control input-sm" type="number" name="value_<?=$value['id']?>"  value="<?=$value['price']?>" style="width: 100px; display: inline"> сум</p>
                <?php endforeach;?>
            <?php else:;?>
                <?php foreach ($model->settings as $item):?>
                    <p><input type="checkbox" name="check_<?=$item['id']?>" <?=$item['checked'] ? 'checked':''?>> <?=$item['items']?> обявления- <input class="form-control input-sm" type="number" name="value_<?=$item['id']?>" value="<?=$item['price']?>" style="width: 100px; display: inline"> сум</p>
                <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>
<div class="row">
    <div class="col-md-12">
        <?=$form->field($model, 'regions')->widget(Select2::className(), [
            'data' => ArrayHelper::map(Regions::find()->asArray()->all(), 'id', 'name'),
            'language' => 'ru',
            'options' => [
                'multiple'=> true,
                'placeholder' => 'Выберите роль...',
                'autocomplete' => 'off',
            ],
            'pluginOptions' => [
                'allowClear' => false,
            ],
        ])?>
        <?= $form->field($model, 'enabled')->checkbox(['label' => 'Включена']) ?>
    </div>
</div>
    <?php ActiveForm::end();?>
