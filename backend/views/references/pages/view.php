<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\references\Pages */
?>
<div class="pages-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'filename',
            'changed_id',
            'date_cr',
            'date_up',
            'noindex:boolean',
            'title',
            'description:ntext',
            'mtitle:ntext',
            'mkeywords:ntext',
            'mdescription:ntext',
        ],
    ]) ?>
    
</div>

<?php 
$this->registerJs(<<<JS
    var prevFocus;

    $("input").on("focus",function() {
        prevFocus = $(this);
    });

    $("textarea").on("focus",function() {
        prevFocus = $(this);
    });

    $(".tag").on("click",function(){
        
        oldValue = prevFocus.val();
        arr = oldValue.split(' ');
        newValue = '{' + $(this).html() + '}';
        if(arr.indexOf(newValue) != -1){
            new_arr = arr.splice(arr.indexOf(newValue),1);
            console.log('deleted');
            console.log(new_arr);
        }else{
            arr.push(newValue);
            console.log('add');
            console.log(arr);
        }
        value = arr.join(' ');
        prevFocus.val(value);
    });

    $("div").each(function( index ) {
       $( this ).removeClass('form-group');
    });

JS
)
?>
