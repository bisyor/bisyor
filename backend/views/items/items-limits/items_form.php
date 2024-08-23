<?php
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 03.06.2020
 * Time: 12:32
 */

use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(['id' => 'itemForm']); ?>
    <?=$form->field($model, 'count')->textInput(['type' => 'number'])?>
    <?=$form->field($model, 'price')->textInput(['type' => 'number'])?>
    <?=$form->field($model, 'check')->checkbox()?>
<?php ActiveForm::end();?>