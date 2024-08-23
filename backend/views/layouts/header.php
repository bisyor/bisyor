<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use backend\models\chats\ChatList;
$session = Yii::$app->session;
if($session['type'] == null) $session['type'] = 1;
$usersList = Yii::$app->user->identity->id == 1 ?  ChatList::getUsersListHeaderChat(1) : [];
$countNewMessage = array_sum(array_column($usersList, 'countNewMessage'));
$countItemClaims = \backend\models\items\ItemsClaim::getItemsClaimCount();
 ?>

<div id="header" class="header navbar navbar-inverse navbar-fixed-top">
            <!-- begin container-fluid -->
            <div class="container-fluid">
                <!-- begin mobile sidebar expand / collapse button -->
                <div class="navbar-header">
                    <a href="<?= Yii::$app->homeUrl ?>" class="navbar-brand"><span class="navbar-logo"></span> <?= Yii::$app->name ?></a>
                    <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- end mobile sidebar expand / collapse button -->
                
                <!-- begin header navigation right -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- <li>
                        <form class="navbar-form full-width">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Enter keyword" />
                                <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                    </li> -->
                    <li>
                        <a href="<?=Yii::$app->params['site_name']?>" target="_blank" class="dropdown-toggle f-s-14">
                            <span class="btn btn-info btn-xs m-r-5">Сайт<span class=" fa fa-arrow-right"></span></span>
                            
                        </a>
                    </li>
                    <li>
                        <a href="/items/items-claim" class="dropdown-toggle f-s-14"   title="Жалобы">
                            <i class="fa fa-file-text"></i>
                            <span class="label"><?= $countItemClaims?></span>
                        </a>
                    </li>
                    <li class="dropdown">
                        
                        <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">
                            <i class="fa fa-comments"></i>
                            <span class="label"><?= $countNewMessage?></span>
                        </a>
                        
                        <ul class="dropdown-menu media-list pull-right animated fadeInDown" style="max-height: 400px; overflow-x: auto; width: 350px;" >
                            <li class="dropdown-header">Сообщении (<?= $countNewMessage?>)</li>
                            <?php foreach ($usersList as $key => $value): ?>
                                <li class="media"  onclick="chatTypeChange();">
                                    <a href="/chats/index?chat_id=<?= $value['chatId']?>&type=1">
                                        <div class="media-left"><img src="<?= $value['image']?>" class="media-object" alt=""></div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><?= $value['login']?></h6>
                                            <p><?= mb_substr($value['lastMessage'], 0,25) . "..."?> <span class="badge badge-danger"><?= $value['countNewMessage']?></span></p>
                                            <div class="text-muted f-s-11"><?= date('H:i d.m.Y' , strtotime($value['date_cr']))?></div>
                                        </div>
                                    </a>
                                </li>   
                            <?php endforeach ?>
                            <li class="dropdown-footer text-center">
                                <a href="/chats/index?type=1">Посмотрить все</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown navbar-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?=$model->getAvatar()?>" alt="" /> 
                            <span class="hidden-xs"><?=$model->fio?></span> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu animated fadeInLeft">
                            <li class="arrow"></li>
                            <li><?= Html::a('<span class="fa fa-user"></span> Профиль', ['/users/users/profile'], []); ?></li>
                            <li class="divider"></li>
                            <li><?= Html::a(
                                    '<span class="fa fa-sign-out"></span> Выйти',
                                    ['/site/logout'], 
                                    ['data-method' => 'post',]   
                                ) ?></li>

                        </ul>
                    </li>
                </ul>
                <!-- end header navigation right -->
            </div>
            <!-- end container-fluid -->
        </div>
