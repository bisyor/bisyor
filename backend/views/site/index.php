<?php

use backend\components\StaticFunction;
use dosamigos\chartjs\ChartJs;

/* @var yii\web\View $this */
/* @var   $users */
/* @var   $shops */
$this->title = 'Статистика';
$this->params['breadcrumbs'][] = $this->title;

?>
    <!-- begin row -->
    <div class="row">
        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-green">
                <div class="stats-icon"><i class="fa fa-desktop"></i></div>
                <div class="stats-info">
                    <h4>Объявления</h4>
                    <p><?= StaticFunction::getPriceFormat($items_count)?></p>
                </div>
                <div class="stats-link">
                    <a href="/items/items">Подробнее ... <i class="fa fa-arrow-circle-o-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-purple">
                <div class="stats-icon"><i class="fa fa-users"></i></div>
                <div class="stats-info">
                    <h4>Пользователи</h4>
                    <p><?= StaticFunction::getPriceFormat($users[0]) ?></p>
                </div>
                <div class="stats-link">
                    <a href="/users/users">Подробнее ... <i class="fa fa-arrow-circle-o-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-blue">
                <div class="stats-icon"><i class="fa fa-chain-broken"></i></div>
                <div class="stats-info">
                    <h4>Магазины</h4>
                    <p><?= StaticFunction::getPriceFormat($shops[0]) ?></p>
                </div>
                <div class="stats-link">
                    <a href="/shops/shops">Подробнее ... <i class="fa fa-arrow-circle-o-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-red">
                <div class="stats-icon"><i class="fa fa-clock-o"></i></div>
                <div class="stats-info">
                    <h4>Услуги</h4>
                    <p><?= StaticFunction::getPriceFormat($service_count); ?></p>
                </div>
                <div class="stats-link">
                    <a href="javascript:;">Подробнее ... <i class="fa fa-arrow-circle-o-right"></i></a>
                </div>
            </div>
        </div>
        <!-- end col-3 -->
    </div>
    <!-- end row -->
    <!-- begin row -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Объявление</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= ChartJs::widget([
                                'type' => 'doughnut',
                                'id' => 'structurePieItems',
                                'options' => [
                                    'height' => 200,
                                    'width' => 400,
                                ],
                                'data' => [
                                    'radius' =>  "90%",
                                    'labels' => $items_labels, // Your labels
                                    'datasets' => [
                                        [
                                            'data' => $items, // Your dataset
                                            'label' => '',
                                            'backgroundColor' => [
                                                '#80ac25',
                                                '#e7cb4d',
                                                '#e05d62',
                                                '#92cae3',
                                                '#9154bc',
                                                '#e23d41',
                                            ],
                                            'borderColor' =>  [
                                                '#fff',
                                                '#fff',
                                                '#fff',
                                                '#fff',
                                                '#fff',
                                                '#fff'
                                            ],
                                            'borderWidth' => 1,
                                            'hoverBorderColor'=>["#999","#999","#999"],
                                        ]
                                    ]
                                ],
                                'clientOptions' => [
                                    'legend' => [
                                        'display' => true,
                                        'position' => 'right',
                                        'labels' => [
                                            'fontSize' => 14,
                                            'fontColor' => "#425062",
                                            'data' => 'sasa'
                                        ]
                                    ],
                                    'tooltips' => [
                                        'enabled' => true,
                                        'intersect' => true
                                    ],
                                    'hover' => [
                                        'mode' => false
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            Новые за <a class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuLink" style="cursor:pointer;">
                                неделю <span class="fa fa-caret-down"></span>
                            </a>
                            <div class="pull-right">
                                <button id="click_item_line" class="btn btn-default btn-sm active"><span class="fa fa-line-chart"></button>
                                <button id="click_item_bar" class="btn btn-default btn-sm"><span class="fa fa-bar-chart"></button>
                            </div>
                            <ul class="dropdown-menu"  aria-labelledby="dropdownMenuButton">
                                <li><a id="week" class="select" style="cursor:pointer;">неделю</a></li>
                                <li><a id="month" class="select" style="cursor:pointer;">месяц</a></li>
                                <li><a id="kvartal" class="select" style="cursor:pointer;">квартал</a></li>
                                <li><a id="year" class="select" style="cursor:pointer;">год</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="items_chart" class="row">
                        <?= $this->render('chart_items',[
                            'label_line_chart' => $array_date['label'],
                            'count_line_chart' => $array_date['count']
                        ]);?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Пользователи</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= ChartJs::widget([
                                'type' => 'doughnut',
                                'id' => 'structurePieUsers',
                                'options' => [
                                    'height' => 200,
                                    'width' => 400,
                                ],
                                'data' => [
                                    'radius' =>  "90%",
                                    'labels' => ['Всего ('.$users[0].')', 'Активные ('.$users[1].')'], // Your labels
                                    'datasets' => [
                                        [
                                            'data' => $users, // Your dataset
                                            'label' => '',
                                            'backgroundColor' => [
                                                '#80ac25',
                                                '#e7cb4d',
                                            ],
                                            'borderColor' =>  [
                                                '#fff',
                                                '#fff',
                                            ],
                                            'borderWidth' => 1,
                                            'hoverBorderColor'=>["#999","#999"],
                                        ]
                                    ]
                                ],
                                'clientOptions' => [
                                    'legend' => [
                                        'display' => true,
                                        'position' => 'right',
                                        'labels' => [
                                            'fontSize' => 14,
                                            'fontColor' => "#425062",
                                            'data' => 'sasa'
                                        ]
                                    ],
                                    'tooltips' => [
                                        'enabled' => true,
                                        'intersect' => true
                                    ],
                                    'hover' => [
                                        'mode' => false
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            Новые за <a class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuLinkUsers" style="cursor:pointer;">
                                неделю <span class="fa fa-caret-down"></span>
                            </a>
                            <div class="pull-right">
                                <button id="click_users_line" class="btn btn-default btn-sm active"><span class="fa fa-line-chart"></button>
                                <button id="click_users_bar" class="btn btn-default btn-sm"><span class="fa fa-bar-chart"></button>
                            </div>
                            <ul class="dropdown-menu"  aria-labelledby="dropdownMenuButton">
                                <li><a id="week" class="select_user" style="cursor:pointer;">неделю</a></li>
                                <li><a id="month" class="select_user" style="cursor:pointer;">месяц</a></li>
                                <li><a id="kvartal" class="select_user" style="cursor:pointer;">квартал</a></li>
                                <li><a id="year" class="select_user" style="cursor:pointer;">год</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="users_chart" class="row">
                        <?= $this->render('chart_user',[
                            'label_user_chart' => $user_array['label'],
                            'count_user_chart' => $user_array['count']
                        ]);?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Магазины</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= ChartJs::widget([
                                'type' => 'doughnut',
                                'id' => 'structurePieShops',
                                'options' => [
                                    'height' => 200,
                                    'width' => 400,
                                ],
                                'data' => [
                                    'radius' =>  "90%",
                                    'labels' => ['Всего ('.$shops[0].')', 'Активные ('.$shops[1].')'], // Your labels
                                    'datasets' => [
                                        [
                                            'data' => $shops, // Your dataset
                                            'label' => '',
                                            'backgroundColor' => [
                                                '#80ac25',
                                                '#e7cb4d',
                                            ],
                                            'borderColor' =>  [
                                                '#fff',
                                                '#fff',
                                            ],
                                            'borderWidth' => 1,
                                            'hoverBorderColor'=>["#999","#999"],
                                        ]
                                    ]
                                ],
                                'clientOptions' => [
                                    'legend' => [
                                        'display' => true,
                                        'position' => 'right',
                                        'labels' => [
                                            'fontSize' => 14,
                                            'fontColor' => "#425062",
                                            'data' => 'sasa'
                                        ]
                                    ],
                                    'tooltips' => [
                                        'enabled' => true,
                                        'intersect' => true
                                    ],
                                    'hover' => [
                                        'mode' => false
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            Новые за <a class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuLinkShops" style="cursor:pointer;">
                                неделю <span class="fa fa-caret-down"></span>
                            </a>
                            <div class="pull-right">
                                <button id="click_shops_line" class="btn btn-default btn-sm active"><span class="fa fa-line-chart"></button>
                                <button id="click_shops_bar" class="btn btn-default btn-sm"><span class="fa fa-bar-chart"></button>
                            </div>
                            <ul class="dropdown-menu"  aria-labelledby="dropdownMenuButton">
                                <li><a id="week" class="select_shops" style="cursor:pointer;">неделю</a></li>
                                <li><a id="month" class="select_shops" style="cursor:pointer;">месяц</a></li>
                                <li><a id="kvartal" class="select_shops" style="cursor:pointer;">квартал</a></li>
                                <li><a id="year" class="select_shops" style="cursor:pointer;">год</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="shops_chart" class="row">
                        <?= $this->render('chart_shops',[
                            'label_shops_chart' => $array_shops['label'],
                            'count_shops_chart' => $array_shops['count']
                        ]);?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
                <?= $this->render('percent/percent',[
                    'label_percent_chart' => $user_percent['label'],
                    'count_percent_chart' => $user_percent['count']
                ]);?>
        </div>
        <div class="col-md-6">
            <?= $this->render('contacts/contact',[
                'label_contact_chart' =>$user_contact['label'],
                'count_contact_chart' => $user_contact['count']
            ]);?>
        </div>
        <div class="col-md-6 statistika_relative" >
            <?= $this->render('payments/payment',[
                'label_payment_chart' =>$user_payment['label'],
                'count_payment_chart' => $user_payment['count']
            ]);?>
        </div>
    </div>
        <!--    % in statistic    -->
<?php
$this->registerJsFile('/js/cookie.js');

$this->registerJs(<<<JS

$(document).ready(function(){

    active_chart = getCookie('type-chart');
    active_chart_users = getCookie('type-chart_users');
    active_chart_shops = getCookie('type-chart_shops');
    active_chart_percent = getCookie('type-chart_percent');
    active_chart_contact = getCookie('type-chart_contact');
    active_chart_payment = getCookie('type-chart_payment');
    
    if(!active_chart || active_chart == 'undefined')
        active_chart = 'line';
    if(!active_chart_users || active_chart_users == 'undefined')
        active_chart_users = 'line';
    if(!active_chart_shops || active_chart_shops == 'undefined')
        active_chart_shops = 'line';
    
    if(!active_chart_percent || active_chart_percent == 'undefined')
        active_chart_percent = 'line';
    
    if(!active_chart_contact || active_chart_contact == 'undefined')
        active_chart_contact = 'line';
    
    if(!active_chart_payment || active_chart_payment == 'undefined')
        active_chart_payment = 'line';
    
    $('#items_'+active_chart).removeClass('hide').addClass('show');
    $('#click_item_'+active_chart).addClass('active');
    $('#users_'+active_chart_users).removeClass('hide').addClass('show');
    $('#click_users_'+active_chart_users).addClass('active');
    $('#shops_'+active_chart_shops).removeClass('hide').addClass('show');
    $('#click_shops_'+active_chart_shops).addClass('active');
    
    $('#percent_'+active_chart_percent).removeClass('hide').addClass('show');
    $('#click_percent_'+active_chart_percent).addClass('active');
    
    $('#contact_'+active_chart_contact).removeClass('hide').addClass('show');
    $('#click_contact_'+active_chart_contact).addClass('active');
    
    $('#payment_'+active_chart_payment).removeClass('hide').addClass('show');
    $('#click_payment_'+active_chart_payment).addClass('active');

    $('#click_item_line').click(function(){
        setCookie('type-chart','line');
        $('#items_line').removeClass('hide').addClass('show');
        $('#items_bar').removeClass('show').addClass('hide');
        $(this).addClass('active');
    });
    
    $('#click_item_bar').click(function(){
        setCookie('type-chart','bar');
        $('#items_bar').removeClass('hide').addClass('show');
        $('#items_line').removeClass('show').addClass('hide');
        $(this).addClass('active');
    });
    
    $('#click_users_line').click(function(){
        setCookie('type-chart_users','line');
        $('#users_line').removeClass('hide').addClass('show');
        $('#users_bar').removeClass('show').addClass('hide');
        $(this).addClass('active');
    });
    $('#click_users_bar').click(function(){
        setCookie('type-chart_users','bar');
        $('#users_bar').removeClass('hide').addClass('show');
        $('#users_line').removeClass('show').addClass('hide');
        $(this).addClass('active');
    });
    
    $('#click_shops_line').click(function(){
        setCookie('type-chart_shops','line');
        $('#shops_line').removeClass('hide').addClass('show');
        $('#shops_bar').removeClass('show').addClass('hide');
        $(this).addClass('active');
    });
    
    $('#click_shops_bar').click(function(){
        setCookie('type-chart_shops','bar');
        $('#shops_bar').removeClass('hide').addClass('show');
        $('#shops_line').removeClass('show').addClass('hide');
        $(this).addClass('active');
    });
    
     $('#click_percent_line').click(function(){
        setCookie('type-chart_percent','line');
        $('#percent_line').removeClass('hide').addClass('show');
        $('#percent_bar').removeClass('show').addClass('hide');
        $(this).addClass('active');
    });
     
    $('#click_percent_bar').click(function(){
        setCookie('type-chart_percent','bar');
        $('#percent_bar').removeClass('hide').addClass('show');
        $('#percent_line').removeClass('show').addClass('hide');
        $(this).addClass('active');
    });
    
    
    $('#click_contact_line').click(function(){
        setCookie('type-chart_contact','line');
        $('#contact_line').removeClass('hide').addClass('show');
        $('#contact_bar').removeClass('show').addClass('hide');
        $(this).addClass('active');
    });
     
    $('#click_contact_bar').click(function(){
        setCookie('type-chart_contact','bar');
        $('#contact_bar').removeClass('hide').addClass('show');
        $('#contact_line').removeClass('show').addClass('hide');
        $(this).addClass('active');
    });
    
    $('#click_payment_line').click(function(){
        setCookie('type-chart_payment','line');
        $('#payment_line').removeClass('hide').addClass('show');
        $('#payment_bar').removeClass('show').addClass('hide');
        $(this).addClass('active');
    });
     
    $('#click_payment_bar').click(function(){
        setCookie('type-chart_payment','bar');
        $('#payment_bar').removeClass('hide').addClass('show');
        $('#payment_line').removeClass('show').addClass('hide');
        $(this).addClass('active');
    });
    
    
    
    $('.select').click(function(){
        var text = $(this).text() + '<span class="fa fa-caret-down"></span>';
       $('#dropdownMenuLink').html(text);
        active_chart = getCookie('type-chart');
        if(!active_chart || active_chart == 'undefined')
            active_chart = 'line';
        $.post('statistics/items-chart', {type: $(this).attr("id")}, function(data){ 
            $("#items_chart").html(data);
            $('#items_'+active_chart).removeClass('hide').addClass('show');
        });
    });
    
    
    $('.select_user').click(function(){
        var text = $(this).text() + '<span class="fa fa-caret-down"></span>';
       $('#dropdownMenuLinkUsers').html(text);
        active_chart_users = getCookie('type-chart_users');
        if(!active_chart_users || active_chart_users == 'undefined')
            active_chart_users = 'line';
        $.post('statistics/users-chart', {type: $(this).attr("id")}, function(data){ 
            $("#users_chart").html(data); 
            $('#users_'+active_chart_users).removeClass('hide').addClass('show');
        });
    });
    
    
    $('.select_shops').click(function(){
        var text = $(this).text() + '<span class="fa fa-caret-down"></span>';
       $('#dropdownMenuLinkShops').html(text);
        active_chart_shops =getCookie('type-chart_shops');
        if(!active_chart_shops || active_chart_shops == 'undefined')
            active_chart_shops = 'line';
        $.post('statistics/shops-chart', {type: $(this).attr("id")}, function(data){ 
            $("#shops_chart").html(data); 
            $('#shops_'+active_chart_shops).removeClass('hide').addClass('show');
        });
    });
    
     $('.select_percent').click(function(){
        var text = $(this).text() + '<span class="fa fa-caret-down"></span>';
       $('#dropdownMenuLinkPercent').html(text);
        active_chart_percent = getCookie('type-chart_percent');
        if(!active_chart_percent || active_chart_percent == 'undefined')
            active_chart_percent = 'line';
        $.post('statistics/percent-chart', {type: $(this).attr("id")}, function(data){ 
            $("#chart_percent").html(data); 
            $('#percent_'+active_chart_percent).removeClass('hide').addClass('show');
        });
    });
     
      $('.select_contact').click(function(){
        var text = $(this).text() + '<span class="fa fa-caret-down"></span>';
       $('#dropdownMenuLinkContact').html(text);
        active_chart_contact = getCookie('type-chart_contact');
        if(!active_chart_contact || active_chart_contact == 'undefined')
            active_chart_contact = 'line';
        $.post('statistics/contact-chart', {type: $(this).attr("id")}, function(data){ 
            $("#chart_contact").html(data); 
            $('#contact_'+active_chart_contact).removeClass('hide').addClass('show');
        });
    });
      
      
    $('.select_payment').click(function(){
        var text = $(this).text() + '<span class="fa fa-caret-down"></span>';
       $('#dropdownMenuLinkPayment').html(text);
        active_chart_payment = getCookie('type-chart_payment');
        if(!active_chart_payment || active_chart_payment == 'undefined')
            active_chart_payment = 'line';
        $.post('statistics/payment-chart', {type: $(this).attr("id")}, function(data){ 
            console.log('dada');
            $("#chart_payment").html(data); 
            $('#payment_'+active_chart_payment).removeClass('hide').addClass('show');
        });
    });
     
     
});
JS
)?>



