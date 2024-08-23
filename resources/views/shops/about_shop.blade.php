@extends('layouts.app')
@section('title'){!! $seo['shops_view_title'] !!}@endsection
@section('meta_block')
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['shops_view_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['shops_view_keyword'] !!}">
    <link rel="canonical" href="{{ url()->full() }}"/>
    @foreach($langs as $lang)
        <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}"/>
    @endforeach
    <meta property="og:title" content="{!! $seo['shops_view_title'] !!}">
    <meta property="og:description" content="{!! $seo['shops_view_description'] !!}">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:site_name" content="{{ $seo['shops_view_site_name'] }}">
    <meta property="og:locale" content="{{ app()->getLocale() }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $shop['logo'] }}"/>
    <meta property="og:image:width" content="800"/>
    <meta property="og:image:height" content="665"/>
@endsection
@push('before-styles')
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
@endpush
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">@endpush
@section('content')
    <section class="marks">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('shops-list') }}">{{ trans('messages.Shops') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{!! $shop['name'] !!}</li>
                </ol>
            </nav>
            <div class="bren_mag_main">
                <div class="bren_mag_left">
                    <div class="mapmar">
                        <div id="map"></div>
                        <p>@lang('messages.Store Address'):</p>
                        <b>{{ $shop['address'] }}</b>
                        <input type="hidden" id="coordinate_x" name="coordinate_x" value="{{ $shop['coordinate_x'] }}"/>
                        <input type="hidden" id="coordinate_y" name="coordinate_y" value="{{ $shop['coordinate_y'] }}"/>
                        <input type="hidden" id="shopName" name="shopName" value="{{ $shop['name'] }}"/>
                    </div>
                    @includeWhen(!empty($banner), 'shops.banner', ['banner' => $banner])
                </div>
                <div class="bren_mag_right">
                    <div class="rest">
                        @include('shops.shop_top')
                        <div class="rest_bottom">
                            <div class="tabs_rest">
                                <ul class="link_tab">
                                    <li><a href="{{ route('shops-view', ['keyword' => $shop['keyword']]) }}">@lang('messages.Products')</a></li>
                                    <li><a href="javascript:void(0);" class="active">@lang('messages.About brend')</a></li>
                                    <li><a href="{{ route('shops-portfolio', ['keyword' => $shop['keyword']]) }}">@lang('messages.Portfolio')</a></li>
                                </ul>
                                <ul class="link_social">
                                    @foreach($shop['getSocial'] as $social)
                                        <li>
                                            <a href="{{ $social['value'] }}" rel="nofollow" target="_blank">
                                                <i class="{{ $social['icon'] }}"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                    {{--<li><a href="#"><img src="images/facebook_png.png" alt=""></a></li>--}}
                                </ul>
                            </div>
                            <div class="tab_rest_body">
                                <div class="about_products">
                                    <h5>
                                        {{ $shop['name'] }}
                                    </h5>
                                    <p>{{ $shop['description'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('shops.popup')
@endsection
@section('extra-js')
    <script
        src="https://api-maps.yandex.ru/2.1/?lang={{ app()->getLocale() ==='oz'? 'uz' : app()->getLocale() }}"></script>
    <script>
        function copy(that) {
            var inp = document.createElement('input');
            document.body.appendChild(inp)
            inp.value = that.getAttribute("data-url")
            inp.select();
            document.execCommand('copy', false);
            inp.remove();
            alert("@lang('messages.Shops shared text')");
        }

        $('.modal-review__rating-order-wrap > span').click(function () {
            $(this).addClass('active').siblings().removeClass('active');
            $(this).parent().attr('data-rating-value', $(this).data('rating-value'));
            $('input[name=rating]').val($(this).data('rating-value'));
            $('#send_rating').attr('disabled', false);
        });
        setTimeout(() => ymaps.ready(init), 2000);

        function init() {
            // Подключаем поисковые подсказки к полю ввода.
            let map, placemark;

            const cord_x = {{ config('app.coordinate_x') }} *
            1;
            const cord_y = {{ config('app.coordinate_y') }} *
            1;
            // Указывается идентификатор HTML-элемента.
            map = new ymaps.Map('map', {
                zoom: 15,
                center: [cord_x, cord_y],
                controls: ['zoomControl', 'fullscreenControl']
            });

            placemark = new ymaps.Placemark(map.getCenter(), {}, {
                preset: 'islands#redDotIconWithCaption',
                draggable: false
            });

            map.geoObjects.add(placemark);


        }
    </script>

    {{--    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('settings.geo_maps_googleKey') }}&v=3.exp&language={{ app()->getLocale() }}&libraries=places&callback=initMap"></script>--}}
    <script>
        $(document).on('click', '#claim_form input[name="reason"]', function (e) {
            if (parseInt(this.value) === 3) {
                $('#comment').show("slow");
                $('#comment textarea').attr('required', true);
            } else {
                $('#comment').hide("slow");
                $('#comment textarea').attr('required', false);
            }
        });
    </script>
@stop
