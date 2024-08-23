<?php
use \yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\switchery\Switchery;
$session = Yii::$app->session;
$this->params['breadcrumbs'][] = ['label' => "Группы", 'url' => ['index']];
$this->title = 'Доступ группы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">
            Доступ группы
        </h4>
    </div>
    <div class="panel-body">
        <?php  ActiveForm::begin(['method' => 'post'])?>
        <div class="panel panel-default panel-with-tabs" data-sortable-id="ui-unlimited-tabs-2">
            <div class="panel-heading p-0">
                <div class="panel-heading-btn m-r-10 m-t-10">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-inverse" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                </div>
                <!-- begin nav-tabs -->
                <div class="tab-overflow">
                    <ul class="nav nav-tabs">
                        <li class="prev-button"><a href="javascript:;" data-click="prev-tab" class="text-inverse"><i class="fa fa-arrow-left"></i></a></li>
                        <li class=""><a href="#collapseBbs" data-toggle="tab"><?=$bbs[0]['title']?></a></li>
                        <li class=""><a href="#collapseShops" data-toggle="tab"><?=$shops[0]['title']?></a></li>
                        <li class=""><a href="#collapseUsers" data-toggle="tab"><?=$users[0]['title']?></a></li>
                        <li class=""><a href="#collapseBills" data-toggle="tab"><?=$bills[0]['title']?></a></li>
                        <li class=""><a href="#collapseBanners" data-toggle="tab"><?=$banners[0]['title']?></a></li>
                        <li class=""><a href="#collapseInternalMail" data-toggle="tab"><?=$internalmail[0]['title']?></a></li>
                        <li class=""><a href="#collapseBlog" data-toggle="tab"><?=$blog[0]['title']?></a></li>
                        <li class=""><a href="#collapseHelp" data-toggle="tab"><?=$help[0]['title']?></a></li>
                        <li class=""><a href="#collapseSitePages" data-toggle="tab"><?=$sitepages[0]['title']?></a></li>
                        <li class=""><a href="#collapseContacts" data-toggle="tab"><?=$contacts[0]['title']?></a></li>
                        <li class=""><a href="#collapseSendMail" data-toggle="tab"><?=$sendmail[0]['title']?></a></li>
                        <li class=""><a href="#collapseSiteMap" data-toggle="tab"><?=$sitemap[0]['title']?></a></li>
                        <li class=""><a href="#collapseSite" data-toggle="tab"><?=$site[0]['title']?></a></li>
                        <li class=""><a href="#collapseSeo" data-toggle="tab"><?=$seo[0]['title']?></a></li>
                        <li class=""><a href="#collapsePolls" data-toggle="tab"><?=$polls[0]['title']?></a></li>
                        <li class=""><a href="#collapseAlerts" data-toggle="tab"><?=$alerts[0]['title']?></a></li>
                        <li class=""><a href="#collapseSocial" data-toggle="tab"><?=$social[0]['title']?></a></li>
                        <li class=""><a href="#collapseSubscribe" data-toggle="tab"><?=$subscribe[0]['title']?></a></li>
                        <li class=""><a href="#collapseDesktop" data-toggle="tab"><?=$desktop[0]['title']?></a></li>
                        <li class=""><a href="#collapsePromocodes" data-toggle="tab"><?=$promocodes[0]['title']?></a></li>
                        <li class=""><a href="#collapseBrands" data-toggle="tab"><?=$brands[0]['title']?></a></li>
                        <li class=""><a href="#collapseRss" data-toggle="tab"><?=$rss[0]['title']?></a></li>
                        <li class=""><a href="#collapseBlackList" data-toggle="tab"><?=$black_list[0]['title']?></a></li>
                        <li class=""><a href="#collapseVacancies" data-toggle="tab"><?=$vacancies[0]['title']?></a></li>
                        <li class=""><a href="#collapseVacancyCategory" data-toggle="tab"><?=$vacancy_category[0]['title']?></a></li>
                        <li class=""><a href="#collapseParser" data-toggle="tab"><?=$parser[0]['title']?></a></li>
                        <li class="next-button"><a href="javascript:;" data-click="next-tab" class="text-inverse"><i class="fa fa-arrow-right"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade" id="collapseBbs">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($bbs as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'bbs'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Bbs',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false,
                                                    'size' => 'small'
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false,
                                                    'size' => 'small'
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseShops">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($shops as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'shops'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Shops',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseUsers">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($users as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'users'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Users',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseBills">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($bills as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'bills'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Bills',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseBanners">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($banners as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'banners'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Banners',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseInternalMail">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($internalmail as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'internalmail'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'InternalMail',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseBlog">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($blog as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'blog'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Blog',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseHelp">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($help as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'help'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Help',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseSitePages">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($sitepages as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'site-pages'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'SitePages',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseContacts">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($contacts as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'contacts'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Contacts',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseSendMail">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($sendmail as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'sendmail'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'SendMail',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseSiteMap">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($sitemap as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'sitemap'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'SiteMap',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseSite">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($site as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'site'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Site',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseSeo">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($seo as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'seo'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Seo',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapsePolls">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($polls as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'polls'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Polls',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseAlerts">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($alerts as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'alerts'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Alerts',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseSocial">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($social as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'social-networks'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Social',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseSubscribe">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($subscribe as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'subscribers'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Subscribe',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseDesktop">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($desktop as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'desktop'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Desktop',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapsePromocodes">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($promocodes as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'promocodes'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Promocodes',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="collapseBrands">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($brands as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'brands'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Brands',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="collapseRss">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($rss as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'rss'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Rss',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="collapseBlackList">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($black_list as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'black-list'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'BlackList',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>


                <div class="tab-pane fade" id="collapseVacancies">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($vacancies as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'vacancies'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Vacancies',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="collapseVacancyCategory">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($vacancy_category as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'vacancy-category'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'VacancyCategory',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="collapseParser">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Модуль</th>
                                <th style="width:10%;">Доступ</th>
                            </tr>
                            <?php foreach ($parser as $value):?>
                                <tr>
                                    <?php if ($value['method'] == 'parser'):?>
                                        <td><b><?= $value['title']?></b> (Полный доступ)</td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'id' => 'Parser',
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php else:?>
                                        <td><?= $value['title']?></td>
                                        <td>
                                            <?= Switchery::widget([
                                                'name' => $value['id'],
                                                'checked' => $value['value'],
                                                'options' => [
                                                    'label' => false
                                                ],
                                                'clientOptions' => [
                                                    'color' => '#5FBEAA',
                                                    'secondaryColor' => '#CCCCCC',
                                                    'jackColor' => '#FFFFFF',
                                                ]
                                            ]); ?>
                                        </td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                        </table>
                    </div>
                </div>

            </div>
            <div class="form-group pull-left " style="margin-top: 25px">
                <?= Html::a('Назад', 'index', ['class' => 'btn btn-inverse'])?>
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success '])?>
            </div>
        </div>
        <?php ActiveForm::end()?>
    </div>
</div>
<?php
$this->registerJs(<<<JS

$(document).ready(function(){
    let tab = sessionStorage.getItem("tab$id");
    if(tab != "undefined" && tab !== null){
        $("[href='" + tab + "']").parent().addClass('active');
        $(tab).addClass('active in');
    }else{
       $("[href='#collapseBbs']").parent().addClass('active');
        $("#collapseBbs").addClass('active in');
    }
    $('.nav-tabs li a').click(function(){
        var value =$(this).attr('href');
        sessionStorage.setItem("tab$id", value);
    });
    var methods = ['Bbs', 'Shops', 'Users', 'Bills', 'Banners', 'InternalMail', 'Blog', 'Help', 'SitePages', 'Contacts', 'SendMail', 'SiteMap', 'Seo','Polls','Alerts','Social','Subscribe','Site' ,'Desktop','Promocodes','Brands','Rss','BlackList','Vacancies','VacancyCategory','Parser'];
   $(document).on('change', 'input[type="checkbox"]', function(){
      if(methods.includes($(this).attr("id"))){
          var id = $(this).attr("id");
          var a = $('#collapse' + id).find('span');
          if($(this).is(':checked')){
            $.each(a, function(value) {
                  $(this).attr("style", 'box-shadow: rgb(204, 204, 204) 0px 0px 0px 0px inset; border-color: rgb(204, 204, 204); background-color: rgb(204, 204, 204); transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;');
                  $(this).children().attr("style", 'left: 0px; transition: background-color 0.4s ease 0s, left 0.2s ease 0s;');
                  $(this).prev().removeAttr("checked", "checked");
              });
          }else{
              $.each(a, function(value) {
                $(this).attr("style", 'background-color: rgb(95, 190, 170); border-color: rgb(95, 190, 170); box-shadow: rgb(95, 190, 170) 0px 0px 0px 0px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;');
                $(this).children().attr("style", 'left: 20px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;');
                $(this).prev().attr("checked", "checked");
              });
          }
      }else{
          $.each($(this).closest('table').find('span'), function(value){
               if(methods.includes($(this).prev().attr('id'))){
                  $(this).attr("style", 'box-shadow: rgb(204, 204, 204) 0px 0px 0px 0px inset; border-color: rgb(204, 204, 204); background-color: rgb(204, 204, 204); transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;');
                  $(this).children().attr("style", 'left: 0px; transition: background-color 0.4s ease 0s, left 0.2s ease 0s;');
                  $(this).prev().removeAttr("checked", "checked");               
               }                   
          });
      }
      });
});
JS
);
?>