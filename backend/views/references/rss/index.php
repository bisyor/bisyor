<?php

$this->title = 'RSS';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-inverse" data-sortable-id="ui-general-1">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand" data-original-title="" title="" data-init="true"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload" data-original-title="" title="" data-init="true"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">RSS</h4>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#default-tab-1" data-toggle="tab" aria-expanded="true"> Категория </a></li>
                <li class=""><a href="#default-tab-2" data-toggle="tab" aria-expanded="false"> Пользователи </a></li>
                <li class=""><a href="#default-tab-3" data-toggle="tab" aria-expanded="false"> Магазины </a></li>
                <li class=""><a href="#default-tab-4" data-toggle="tab" aria-expanded="false"> Магазин </a></li>
                <li class=""><a href="#default-tab-5" data-toggle="tab" aria-expanded="false"> Блоги </a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="default-tab-1">
                    <h5> 
                    <b>Ссылка: </b>
                        <a href="https://bisyor.uz/rss/categories?cat=3&region=2&district=1&page=1&lang=uz" data-pjax = "0" target="_blank">https://bisyor.uz/rss/categories?region=3&cat=2&district=1&page=1&lang=uz</a>
                    </h5><br>
                    <h5>
                        <p><b>1) cat :</b> Категория объявления { Недвижимость - 2, Транспорт - 3, Знакомства - 4 ... }<a href="/items/categories/"> <i class="fa fa-external-linkfa fa-external-link"></i></a></p>
                        <p><b>2) region :</b></b></b></b> Область {(не задано) - Весь Узбекистан, Ташкентская область - 12, Самаркандская область - 9, Андижанская область - 1 ... }<a href="/references/regions/"> <i class="fa fa-external-link"></i></a></p>
                        <p><b>3) district :</b></b></b> Район { Юнусабадский район - 173, Чиланзарский район - 181, Мирзо-Улугбекский район - 174 ... }<a href="/references/regions/"> <i class="fa fa-external-link"></i></a></p>
                        <p><b>4) page :</b> Страница { 1, 2, 3 ... }<a href="/references/pages/"> <i class="fa fa-external-link"></i></a></p>
                        <p><b>5) lang :</b> Язык { ru,uz,oz }<a href="/references/language/"> <i class="fa fa-external-link"></i></a></p>
                    </h5>
                    </div>
                    <div class="tab-pane fade" id="default-tab-2">
                    <h5> 
                        <b>Ссылка: </b>
                        <a href="https://bisyor.uz/rss/users?user=1&page=1&lang=uz" data-pjax = "0" target="_blank">https://bisyor.uz/rss/users?user=1&page=1&lang=uz</a>
                    </h5><br>
                    <h5>
                        <p><b>1) users :</b> id Пользователя { Erkin Mavlyanov - 4803, Гидромаркет Hydromarket - 4800, Uzbek - 4797 ... }<a href="/users/users/"> <i class="fa fa-external-link"></i></a></p>
                        <p><b>2) page :</b> Страница { 1, 2, 3 ... }<a href="/references/pages/"> <i class="fa fa-external-link"></i></a></p>
                        <p><b>3) lang :</b> Язык { ru,uz,oz }<a href="/references/language/"> <i class="fa fa-external-link"></i></a></p> 
                    </h5>
                    </div>
                    <div class="tab-pane fade" id="default-tab-3">
                    <h5> 
                        <b>Ссылка: </b>
                        <a href="https://bisyor.uz/rss/shops?page=1&lang=uz" data-pjax = "0" target="_blank">https://bisyor.uz/rss/shops?page=1&lang=uz</a>
                    </h5><br>
                    <h5>
                        <p><b>1) page :</b> Страница { 1, 2, 3 ... }<a href="/references/pages/"> <i class="fa fa-external-link"></i></a></p>
                        <p><b>2) lang :</b> Язык { ru,uz,oz }<a href="/references/language/"> <i class="fa fa-external-link"></i></a></p> 
                    </h5>
                    </div>
                    <div class="tab-pane fade" id="default-tab-4">
                        <h5> 
                            <b>Ссылка: </b>
                            <a href="https://bisyor.uz/rss/shop?id=12&page=1&lang=uz" data-pjax = "0" target="_blank">https://bisyor.uz/rss/shop?id=12&page=1&lang=uz</a>
                        </h5><br>
                        <h5>
                            <p><b>1) shop :</b> Магазин { J-MARKET - 109, SATURN - 112, Зоомагазин - 103 ... }<a href="/shops/shops/"> <i class="fa fa-external-link"></i></a></p>
                            <p><b>2) page :</b> Страница { 1, 2, 3 ... }<a href="/references/pages/"> <i class="fa fa-external-link"></i></a></p>
                            <p><b>3) lang :</b> Язык { ru,uz,oz }<a href="/references/language/"> <i class="fa fa-external-link"></i></a></p> 
                        </h5>
                    </div>
                    <div class="tab-pane fade" id="default-tab-5">
                    <h5> 
                        <b>Ссылка: </b>
                        <a href="https://bisyor.uz/rss/blogs?page=1&lang=uz" data-pjax = "0" target="_blank">https://bisyor.uz/rss/blogs?page=1&lang=uz</a>
                    </h5><br>
                    <h5>
                        <p><b>1) page :</b> Страница { 1, 2, 3 ... }<a href="/references/pages/"> <i class="fa fa-external-link"></i></a></p>
                        <p><b>2) lang :</b> Язык { ru,uz,oz }<a href="/references/language/"> <i class="fa fa-external-link"></i></a></p>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
