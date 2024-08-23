<?php
/**
 * Created by PhpStorm.
 * User: Abdulloh Olimov
 * Date: 18.11.2020
 * Time: 15:06
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(['options' => ['method' => 'post', 'autocomplete'=>"off" ]]); ?>
<div class="row">
    <div class="col-md-3">
        <?=  \kartik\select2\Select2::widget([
            'data' =>  \backend\models\bills\Bills::getStatistics(),
            'name' => 'type',
            'value' => isset($post['type']) ? $post['type'] : 1,
            'options' => ['placeholder' => 'Пожалуйста выберите']
        ]);?>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>


