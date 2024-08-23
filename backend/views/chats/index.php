<?php

use backend\models\chats\Chats;
use backend\models\chats\ChatUsers;
use backend\models\users\RoleMethods;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use yii\widgets\LinkPager;
/* @var $chat_id */
/* @var $items */
/* @var $pagination */
/* @var $usersList */

/* @var $chat_id */
/* @var $chat_live */
/* @var $user_id */
/* @var $delete_but */
/* @var $item_id */
/* @var $check_all_items */


$first = '';
$second = '';
$third = '';
$foo = '';
$five = '';
$name_chat = '';
if (Yii::$app->session['type'] === null || Yii::$app->session['type'] == '1') {
    $first = 'bold';
    $name_chat = "Сообщения с админом";
}
if (Yii::$app->session['type'] == '3') {
    $third = 'bold';
    $name_chat = "Комментария блога";
}
if (Yii::$app->session['type'] == '4') {
    $foo = 'bold';
    $name_chat = "Комментария объявлении";
}
if (Yii::$app->session['type'] == '6') {
    $five = 'bold';
    $name_chat = "Сообщения с объявлении";
}

$type = Yii::$app->session['type'];
$check_chat = false;
if ($chat_id) {
    $chat_user = ChatUsers::find()->where(['chat_id' => $chat_id, 'user_id' => $user_id])->one();
    if (!$chat_user  && ($type == 6 || $type == 1)) {
        $check_chat = true;
    }
    if ($check_chat) {
        $roles = RoleMethods::getUsersRole();
        $spy = RoleMethods::getAccess($roles, 'internalmail', 'spy');
        if (!$spy && $type == 1) $check_chat = false;
    }
}
CrudAsset::register($this);
?>
<script type="text/javascript">
    function submitChat() {
        if (form1.uname.value == '' || form1.msg.value == '') alert("Пожалуйста введите текст");
        else {
            form1.uname.readyState = true;
            form1.uname.style.border = 'none';
            var uname = encodeURIComponent(form1.uname.value);
            var msg = encodeURIComponent(form1.msg.value);
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    //document.getElementById('chatLogs').innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open('GET', '/chats/send-message?uname=' + uname + '&msg=' + msg, true);
            xmlhttp.send();
            document.getElementById('msg').value = null;
            $.pjax.reload({
                container: '#crud-datatable-pjax',
                async: false
            });

            $("div#List").scrollTop(999999999999999999);

        }
    }

    $(document).keypress(function(e) {
        if (e.which == 13) {
            submitChat();
            e.preventDefault();
        }
    });

    $('#form1').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            submitChat();
            e.preventDefault();
            return false;
        }
    });
</script>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-inverse" data-sortable-id="index-4">
            <div class="panel-heading">
                <h4 class="panel-title">Список Сообщении
                    <div class="btn-group pull-right" style="<?= $type == 6 && $check_all_items  ? 'display:none' : ''; ?>">
                        <button type="button" class="btn btn-success btn-xs"><?= $name_chat ?></button>
                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="#" style="font-weight: <?= $first ?>" onclick="$.get('/chats/set-tab', {'value':'1'}, function(data){} );">Сообщения с админом</a>
                            </li>
                            <li>
                                <a href="#" style="font-weight: <?= $third ?>" onclick="$.get('/chats/set-tab', {'value':'3'}, function(data){} );">Комментария блога</a>
                            </li>
                            <li>
                                <a href="#" style="font-weight: <?= $foo ?>" onclick="$.get('/chats/set-tab', {'value':'4'}, function(data){} );">Комментария объявлении</a>
                            </li>
                            <li>
                                <a href="#" style="font-weight: <?= $five ?>" onclick="$.get('/chats/set-tab', {'value':'6'}, function(data){} );">Сообщения с объявлении</a>
                            </li>
                        </ul>
                    </div>
                </h4>
            </div>
            <?php
            if ($type == 1) {
                echo $this->render('admin', [
                    'usersList' => $usersList,
                    'chat_id' => $chat_id,
                    'type' => $type,
                    'pagination' => $pagination,
                ]);
            }
            if (in_array($type, [4, 3])) {
                echo $this->render('comment', [
                    'usersList' => $usersList,
                    'chat_id' => $chat_id,
                    'type' => $type,
                    'pagination' => $pagination,
                ]);
            }

            if ($type == 6 && $check_all_items) {
                echo $this->render('items', [
                    'usersList' => $usersList,
                    'chat_id' => $chat_id,
                    'type' => $type,
                    'pagination' => $pagination,
                    'item_id' => $item_id,
                ]);
            } elseif ($type == 6 && !$check_all_items) {
                echo $this->render('items-all', [
                    'usersList' => $usersList,
                    'chat_id' => $chat_id,
                    'type' => $type,
                    'pagination' => $pagination,
                    'item_id' => $item_id,
                ]);
            }
            ?>
        </div>
    </div>
    <?php Pjax::begin(['enablePushState' => false, 'id' => 'crud-datatable-pjax']) ?>
    <div class="col-md-8">
        <div class="panel panel-inverse" data-sortable-id="index-2">
            <div class="panel-heading">
                <h4 class="panel-title">Сообщения
                    <?php if ($items != null) : ?>
                        <a href="<?= $items['url'] ?>" data-pjax="0" class="btn btn-success btn-xs m-r-5 pull-right"><b><?= $items['id'] ?></b> <?= $items['title'] ?> <i class="glyphicon glyphicon-link"></i> </a>
                    <?php endif; ?>
                    <?php if ($type == 1) : ?>
                        <a href="/chats/send-multiple" role="modal-remote" class="btn btn-warning btn-xs m-r-5 pull-right">Рассылка <i class="fa fa-send"></i> </a>
                    <?php endif; ?>
                    <?php if ($type == 1 && $currentUser) : ?>
                        <a href="/users/users/view?id=<?= $currentUser->id ?>" data-pjax="0" class="btn btn-success btn-xs m-r-5 pull-right"><b>User ID: <?= $currentUser->id ?></b> | <?= $currentUser->getUserFio() ?> <i class="glyphicon glyphicon-link"></i> </a>
                    <?php endif; ?>
                </h4>
            </div>
            <div class="panel-body bg-silver" id="pastga">
                <div class="slimScrollDiv">
                    <div data-scrollbar="true" data-height="225px" data-init="true" id="List" style="overflow-y: auto; width: auto; height: 100vh; ">
                        <ul class="chats">
                            <?php
                            if ($chat_live != null) {
                                foreach ($chat_live['messagesList'] as $value) {
                                    $msg = str_replace("\n", "<br>", $value['message']);
                                    if ($value['user_id'] == $user_id) {
                                        $class = 'right';
                                    } else {
                                        $class = 'left';
                                    }
                            ?>
                                    <?php if ($msg != null && $msg != '') : ?>
                                        <li class="<?= $class ?>" id="<?= $value['id'] ?>">
                                            <span class="date-time"><?= $value['date_cr']; ?></span>
                                            <a href="javascript:;" class="name"><?= $value['user']['userFIO'] ?></a>
                                            <a href="javascript:;" class="image"><img alt="" src="<?= $value['user']['image'] ?>" style="width: 48px; height: 48px; object-fit: cover;"></a>
                                            <div class="message">
                                                <?= $msg ?>
                                            </div>

                                            <a href="#" class="btn btn-xs btn-danger pull-right" onclick="$.get('/chats/delete-message', {'id':<?= $value['id'] ?>}, function(data){$('#<?= $value['id'] ?>').hide();} );">
                                                <i class="glyphicon glyphicon-trash pull-right" title="Удалить"></i>
                                            </a>

                                            <a class="btn btn-xs btn-success pull-right" href="/chats/update-msg?id=<?= $value['id'] ?>" title="Изменить" role="modal-remote" data-toggle="tooltip" data-original-title="Изменить">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </a>
                                            <?php if (Yii::$app->session['type'] == 4) : ?>
                                                <?php if ($value['is_moderated'] != 1) : ?>
                                                    <a class="btn btn-xs btn-warning pull-right" href="/chats/update-odob?id=<?= $value['id'] ?>" title="Одобрить" role="modal-remote" data-toggle="tooltip" data-original-title="Одобрить">
                                                        <span class="fa fa-cubes"></span>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </li>
                                    <?php endif ?>

                                <?php } ?>
                                <?= \yii\widgets\LinkPager::widget([
                                    'pagination' => $chat_live['pagination'],
                                    'maxButtonCount' => 5,
                                ]) ?>
                            <?php
                            } else { ?>
                                <div style="font-weight: bold; font-size: 20px; text-align: center; height: 450px; display: -webkit-flex; display: -moz-flex; display: -ms-flex; display: -o-flex; display: flex; -ms-align-items: center; align-items: center; justify-content: center;">
                                    Выберите, кому хотели бы написать...
                                </div>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php if ($chat_id != null) : ?>
                    <div class="panel-footer" style="<?= $check_chat  ? 'display:none' : ''; ?>">
                        <form data-id="message-form" name="form1" autocomplete="off" method='post' enctype='multipart/form-data'>
                            <input type="hidden" name="uname" id="uname" value="<?= $chat_id ?>">
                            <div class="input-group">
                                <textarea type="text" class="form-control input-sm" name="msg" id="msg" placeholder="Enter your message here." rows="1"> </textarea>
                                <span class="input-group-btn">
                                    <a href="#" class="btn btn-primary btn-sm" onclick="submitChat()" type="button"><i class="fa fa-send"></i></a>
                                </span>
                            </div>
                        </form>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <?php Pjax::end() ?>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "options" => [
        "tabindex" => false,
    ],
    "footer" => "",
]) ?>
<?php Modal::end(); ?>
<?php
$this->registerJs(
    <<<JS

$('#msg').keydown(function (e) {

  if ((e.keyCode == 10 || e.keyCode == 13) && e.ctrlKey) {
    var text = $(this).val();
    val = text + "\\n";
    text = text +"\\n";
    $(this).val(text);
  }
});

$(document).ready(function(){
     $("div#List").scrollTop(9999999999999999);
});


$(document).ready(function(){
  
  $("#seacrh_users_button").on('click',function(){
     $("#seacrh_users").toggle();
  })

  $('#inputFile_submit').change(function(){ 
     var data = new FormData() ; 
     data.append('file', $( '#inputFile_submit' )[0].files[0]) ; 
     data.append('uname', $( '#uname' ).val()) ; 
     $.ajax({
     url: '/live-chat/send-file',
     type: 'POST',
     data: data,
     processData: false,
     contentType: false,
      success: function(data){ 
        
      }
     });
    return false;
  });
});
JS
);
?>