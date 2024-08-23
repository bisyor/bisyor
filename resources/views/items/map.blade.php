@extends('layouts.app')
@section('title'){!! $currentCategory == null ? $seo['seo_translation_name_categories_title'] : $seo['items_category_title'] !!}@endsection
@section('meta_block')
<meta name="description" lang="{{ app()->getLocale() }}" content="{!! $currentCategory == null ? $seo['seo_translation_name_categories_description'] : $seo['items_category_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $currentCategory == null ? $seo['seo_translation_name_categories_keyword'] : $seo['items_category_keyword'] !!}">
    <link rel="canonical" href="{{ url()->full() }}"/>
    <meta property="og:url" content="{{ url()->full() }}" />
    <meta property="og:site_name" content="Bisyor.uz" />
    <meta property="og:image:width" content="800" />
    <meta property="og:image:height" content="665" />
    <meta property="og:locale" content="{{ app()->getLocale() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://bisyor.uz/images/bisyor-cover.jpg" />
@if($currentCategory == null)
    <meta property="og:title" content="{!! $currentCategory == null ? $seo['seo_translation_name_categories_title'] : $seo['items_category_title'] !!}">
    <meta property="og:description" content="{!! $currentCategory == null ? $seo['seo_translation_name_categories_description'] : $seo['items_category_description'] !!}">
@else
    <meta property="og:title" content="{!! $currentCategory == null ? $seo['seo_translation_name_categories_title'] : $seo['items_category_title'] !!}">
    <meta property="og:description" content="{!! $currentCategory == null ? $seo['seo_translation_name_categories_description'] : $seo['items_category_description'] !!}">
@endif
@foreach($langs as $lang)
    <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}" />
@endforeach
    <script type="application/ld+json">
        {
          "@context": "https://schema.org/",
          "@type": "WebSite",
          "name": "{!! $currentCategory == null ? $seo['seo_translation_name_categories_title'] : $seo['items_category_title'] !!}",
          "url": "https://bisyor.uz",
          "potentialAction": {
            "@type": "SearchAction",
            "target": "https://bisyor.uz/search?query={search_term_string}&utm_source=google&utm_medium=search&utm_campaign=search_organic",
            "query-input": "required name=search_term_string"
          }
        }
    </script>
@stop
@section('extra-js')
    <script src="https://api-maps.yandex.ru/2.1/?lang={{ app()->getLocale() ==='oz'? 'uz' : app()->getLocale() }}"></script>
    <script async defer>
        ymaps.ready(init);
        var map;
        function init() {
            // Подключаем поисковые подсказки к полю ввода.
            var cord_x = {{ config('app.coordinate_x') }} * 1;
            var cord_y = {{ config('app.coordinate_y') }} * 1;
            // Указывается идентификатор HTML-элемента.
            if (!map){
                map = new ymaps.Map('map_fert', {
                    zoom: 10,
                    center: [cord_x, cord_y],
                    controls: ['zoomControl', 'fullscreenControl']
                });
            }
            var objectManager = new ymaps.ObjectManager({ clusterize: true });
            objectManager.add(setMarkers());
            map.geoObjects.add(objectManager);
        }

        // Adds markers to the map.
        function setMarkers() {
            const cordX = document.getElementsByName('coordinateX[]');
            const cordY = document.getElementsByName('coordinateY[]');
            const itemTitles = document.getElementsByName('itemTitles[]');
            const itemImages = document.getElementsByName('itemImages[]');
            const itemDates = document.getElementsByName('itemDates[]');
            const itemCategories = document.getElementsByName('itemCategories[]');
            const itemPrices = document.getElementsByName('itemPrices[]');
            const itemUrls = document.getElementsByName('itemUrls[]');

            const collection = {
                type: "FeatureCollection",
                features: []
            }

            for (let i = 0; i < cordX.length; i++) {
                const cord_x = cordX[i].value * 1;
                const cord_y = cordY[i].value * 1;
                const itemImage = itemImages[i].value,
                    itemTitle = itemTitles[i].value,
                    itemCategory = itemCategories[i].value,
                    itemDate = itemDates[i].value,
                    itemPrice = itemPrices[i].value,
                    itemUrl = itemUrls[i].value;

                const content = "<div class='map_info_wrapper'><a href="+itemUrl+"><div class='img_wrapper'><img style='max-width:100%;' src="+itemImage+" alt='Map'></div>"+
                    "<div class='property_content_wrap'>"+
                    "<div class='property_title'>"+
                    "<span>"+itemCategory+"</span>"+
                    "</div>"+

                    "<div class='property_price'>"+
                    "<span>"+itemTitle+"</span>"+
                    "</div>"+

                    "<div class='property_listed_date'>"+
                    "<b>"+itemPrice+"</b>"+
                    "<span>"+itemDate+"</span>"+
                    "</div>"+
                    "</div></a></div>";
                collection.features.push({
                    type: "Feature",
                    id: i + 1,
                    geometry: {
                        type: "Point",
                        coordinates: [cord_x, cord_y]
                    },
                    properties: {
                        balloonContent: content
                    }
                });
            }
            return collection;
        }
    </script>

    <script>
        var page = {{ $page ?: 1 }};
        var flag = false;
        function infiniteLoad() { flag = false; }

        $(window).scroll(function () {
            if(flag) return;
            var footer = $('#footerId').get(0);
            var rubrica = $('#rubrica').get(0);
            var raznitsa = $(document).height() - $(window).height() - footer.scrollHeight - rubrica.scrollHeight;

            if ($(window).scrollTop() > raznitsa ) {
                flag = true; page++;
                $.ajax({
                    url: "{{ route('item-page-map') }}",
                    type: 'GET',
                    data: { keyword : "{{ $keyword }}", page : page },
                    dataType: 'JSON',
                    success: function (data) {
                        $('#divScroll').append(data.msg);
                        ymaps.ready(init);
                        $('.favoruites_product').on('click', function() {
                            $(this).toggleClass('active');
                            /*var toggle = $(this).attr('data-toggle');
                            if(toggle != 'modal') $(this).toggleClass('active');*/
                        });
                        if(data.itemCount > 0) infiniteLoad();
                    }
                });
            }
        });
    </script>

{{--    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.geo_maps_googleKey') }}&v=3.exp&language={{ app()->getLocale() }}&libraries=places&callback=initMap"></script>--}}

@endsection
@section('content')
<section class="premium_ads_section">
    <div class="container">
        <div class="sub_filter">
            @if($keywordParent !== null)
                <a href="{{ route('items-map', $keywordParent) }}" class="active" >
                    << {{ $currentCategory['title'] }}
                </a>
            @endif
            @foreach($topCategories as $category)
                <a href="{{ route('items-map', $category['keyword']) }}">
                    {{ $category['title'] }} - <span style="font-weight: bold;">{{ $category['count'] }}</span>
                </a>
            @endforeach
        </div>
        <hr class="hr_title">
        @if($currentCategory != null)
            @include('items.category-dynprop', [
                'dynpropSearch' => $dynpropSearch,
                'currencies' => $currencies,
                'post' => $post,
                'actionFilterRoute' => $actionFilterRoute,
                'currentCategory' => $currentCategory
            ])
        @endif
        <hr class="hr_title">
        <div class="naved_tit">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                    @if($currentCategory != null)
                        <li class="breadcrumb-item"><a href="{{ route('items-list') }}">{{ trans('messages.Ads') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $currentCategory['title']}}</li>
                    @else
                        <li class="breadcrumb-item">{{ trans('messages.Ads') }}</li>
                    @endif
                </ol>
            </nav>
            @include('items.item-header-list', ['active' => 1, 'keyword' => $keyword, 'address' => $address, 'urlParams' => $urlParams])
        </div>
        <div class="row">
            <div class="col-12">
                @if(isset($banners['item_list']))
                    <section class="phones">
                        <div class="container">
                            @if($banners['item_list']['type'] == 1)
                            <div class="phones_main" style="background-image: url({{ $banners['item_list']['img'] }});" alt="{{ $banners['item_list']['alt'] }}">
                                <h2>{{ $banners['item_list']['title'] }}</h2>
                                <a href="{{ route('banner-item', $banners['item_list']['id'] ) }}" rel="nofollow" class="more_know">{{ trans('messages.Details') }}</a>
                            </div>
                            @else
                                <div class="">
                                <br>
                                    {!! $banners['item_list']['type_data'] !!}
                                </div>
                            @endif
                        </div>
                    </section>
                @endif
            </div>
            <div class="col-lg-6 col-12">
                @if($currentCategory !== null)
                    <!-- <div class="title"> -->
                        <h1 class="title last_ret">{{ $currentCategory['title'] }}</h1>
                    <!-- </div> -->
                    @else
                        <h1 class="title last_ret">{{ trans('messages.Items List') }}</h1>
                @endif
                <div class="lasfert" id="divScroll">
                    @foreach($itemsList as $key => $item)
                        <div class="product_horizontal">
                            @if(array_key_exists('is_banner', $item))
                                {!! $item['code'] !!}
                            @else
                                <a href="{{ route('view-item', $item['link']) }}" class="product_item">
                                    @if($key < 5)
                                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                                    @else
                                        <img class="lazy" src="{{ config('app.noImage') }}" data-src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                                    @endif
                                    <div class="product_text" @if($item['serviceMarked']) style="background-color: {{ $item['serviceMarkedColor'] }}" @endif >
                                        <div class="elt_title">
                                            <span>{{ $item['categoryName'] }}</span>
                                            <div class="elt_date">{{ $item['date_cr'] }}</div>
                                        </div>
                                        <div class="product_text_h4">{!! $item['title'] !!}</div>
                                        <div class="price_product">
                                            <b>{{ $item['price'] }}</b>
                                            <i>{{ $item['oldPrice'] }}</i>
                                        </div>
                                        <p class="negotiat">@if($item['price_ex']){{ $item['price_ex_title'] }}@endif</p>
                                        <div class="address_product">{{ $item['address'] }}</div>
                                    </div>
                                </a>
                                @if (Auth::check())
                                    <div class="favoruites_product {{ $item['favorite'] ? 'active' : '' }}" data-url="{{ route('item-set-favorite', [ 'id' => $item['id'], 'type' => 1]) }}" onclick="itemFavorite(this)"></div>
                                @else
                                    <div class="favoruites_product {{ $item['favorite'] ? 'active' : '' }}" data-url="{{ route('item-set-favorite-noauth', [ 'id' => $item['id'], 'type' => 1]) }}" onclick="itemFavorite(this)"></div>
                                    <!-- <div class="favoruites_product" data-toggle="modal" data-target="#loginModal"></div> -->
                                @endif
                                @if($item['servicePremium'])
                                    <div class="premium premium_item_border"><img src="/images/premium.png" alt="premium">{{ trans('messages.Premium') }}</div>
                                @endif
                                @if($item['serviceFixed'])
                                    <div class="fastening"><img src="/images/fastening.png" alt="fastening">{{ trans('messages.Fix') }}</div>
                                @endif
                                @if($item['serviceQuick'])
                                    <div class="premium ups_pre"><img src="/images/premium.png" alt="premium">{{ trans('messages.Quick') }}</div>
                                @endif
                                <input type="hidden" name="coordinateX[]" value="{{ $item['coordinate_x'] }}">
                                <input type="hidden" name="coordinateY[]" value="{{ $item['coordinate_y'] }}">
                                <input type="hidden" name="itemTitles[]" value="{{ $item['title'] }}">
                                <input type="hidden" name="itemDates[]" value="{{ $item['date_cr'] }}">
                                <input type="hidden" name="itemCategories[]" value="{{ $item['categoryName'] }}">
                                <input type="hidden" name="itemPrices[]" value="{{ $item['price'] }}">
                                <input type="hidden" name="itemImages[]" value="{{ $item['image'] }}">
                                <input type="hidden" name="itemUrls[]" value="{{ route('view-item', $item['link']) }}">
                            @endif
                        </div>
                    @endforeach
                    @if(count($itemsList) == 0)
                        <div class="free_block">
                            <img src="/images/free.png" alt="free">
                            <p>{{ trans('messages.Ads not found') }}</p>
                        </div>
                    @endif
                </div>
                <noscript>
                    <div class="row col-12 mb-3">
                        <a class="btn-success__border mr-auto ml-auto" href="{{ route('items-map', ['page' => $page, 'keyword' => $currentCategory['keyword'] ?? '']) }}">{{ trans('messages.More view') }}</a>
                    </div>
                </noscript>
            </div>
            <div class="col-lg-6 col-12 map_wdith">
                <div class="title last_ret">{{ trans('messages.Map') }}</div>
                <div id="map_fert" class="map_ft"></div>
            </div>
        </div>
    </div>
</section>
<section class="rubrica" id="rubrica">
    <div class="rubrica_top">
        <div class="container">
            <h4>{{ trans('messages.Main categories') }}</h4>
            <div class="rubrica_top_links">
                @for($i = count($mainCategories) - 1; $i > -1; $i--)
                    <a href="{{ $keyword == $mainCategories[$i]['keyword'] ? 'javascript:void(0)' : route('items-map', $mainCategories[$i]['keyword']) }}">
                        {{ $mainCategories[$i]['title'] }}
                    </a>
                @endfor
            </div>
        </div>
    </div>
    <div class="container">
        <ul>
            @foreach($itemInRegion as $region)
                <!-- <li><a href="#">{{ $region['name'] }} - <span>{{ $region['count'] }}</span></a></li> -->
                <li>
                    <a href="{{ route('global-region', ['key' => $region['keyword'], 'time' => time()]) }}">
                        {{ $region['name'] }} - <span>{{ $region['count'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="container no-ul">
        {!! $seo['items_category_seo_text'] !!}
    </div>
</section>
@endsection
