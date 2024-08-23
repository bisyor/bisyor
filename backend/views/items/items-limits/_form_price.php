<?php
/**
 * Created by PhpStorm.
 * Project: bisyor.loc
 * User: Umidjon <t.me/zoxidovuz>
 * Date: 25.12.2020
 * Time: 16:09
 * @var $item
 */

use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(['id' => 'item_price_form']); ?>
   <div class="row">
       <div class="col-md-2">
           <input type="checkbox" name="checked" <?= $item['checked'] ? 'checked' : ''?>>
           <label for="">Статус</label>
       </div>
       <div class="col-md-5 d-flex">
           <label for=""><input class="form-control input-sm" type="number" name="items" value="<?= $item['items'] ?>"> обявления</label>
       </div>
       <div class="col-md-5 d-flex">
           <input class="form-control input-sm" type="number" name="price" value="<?= $item['price'] ?>">
           <label for="">сум</label>
       </div>
   </div>
<?php ActiveForm::end();?>