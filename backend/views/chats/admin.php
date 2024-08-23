<?php
/**
 * Created by PhpStorm.
 * User: Abdulloh Olimov
 * Date: 22.11.2020
 * Time: 13:37
 */
/* @var $chat_id */
/* @var $item_id */
/* @var $pagination */
/* @var $usersList */

/* @var $type */
?>

<div class="content-frame-right" style=" height: 100vh; overflow-y: auto; ">
    <div class="list-group list-group-contacts border-bottom push-down-10">
        <?php foreach ($usersList['results'] as $value) {
            $color = "";
                if(isset($value['chat_id'])){
                    if($value['chat_id'] == $chat_id) $color = "#00acac";
                }
            ?>
            <a href="#" onclick="window.location.href='/chats/index?chat_id=<?= $value['chat_id'];?>&page=<?=$pagination?>&type=<?=$type?>'" class="list-group-item btnSetUsername"  style="background-color: <?=$color?>;">
                <div class="list-group-status status-online"></div>
                <img src="<?=$value['to_user']['image']?>" class="pull-left" style="width: 48px; height: 48px; object-fit: cover; margin-right: 5px;">
                <span class="contacts-title">
                              <b><?=$value['to_user']['userFIO']?></b>
                            </span>
                <?php if($value['message']['count'] != 0):?>
                    <span class="btn btn-danger btn-icon btn-circle btn-xs">
                                <?= $value['message']['count'] ?>
                              </span>
                <?php endif; ?>
                <p>
                    <?= $value['message']['last_message'] != null ? $value['message']['last_message'] : "&nbsp" ?>
                </p>
            </a>
        <?php } ?>
    </div>
    <?= \yii\widgets\LinkPager::widget([
        'pagination' => $usersList['pagination'],
        'maxButtonCount'=>5,
    ]) ?>
</div>
