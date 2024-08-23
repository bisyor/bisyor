<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\chats\Chats;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

?>

<div class="chats-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'check_user')->dropDownList($model->getTypeUser(),['prompt'=>'Выберите'])?>
        <?= $form->field($model, 'message')->textarea(['rows' => 3]) ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php
$this->registerJs(<<<JS

$(document).ready(function(){
  
    $("#search_users_button").on('click',function(){
        $("#search_users_input").toggle(300);
    });

    $("#search_users_input").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".list-group .list-group-item").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $("#select_all").on('change',function(){
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    })

});
JS
);
?>

