@extends('layouts.app')
@section('title'){!! $seo['items_ads_title'] !!}@endsection
@section('meta_block')
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['items_ads_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['items_ads_keyword'] !!}">
    @foreach($langs as $lang)
        <link rel="alternate" hreflang="{{ $lang->url }}"
              href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}"/>
    @endforeach
    <meta property="og:title" content="{!! str_replace('"', '', $seo['items_ads_title']) !!}"/>
    <meta property="og:url" content="{{ url()->full() }}"/>
    <meta property="og:site_name" content="Bisyor.uz"/>
    @if(count($itemImages) > 0)
        <meta property="og:image" content="{{ $itemImages[0]->imageZ() }}"/>
    @else
        <meta property="og:image" content="{{ $item['image'] }}"/>
    @endif
    <meta property="og:image:width" content="800"/>
    <meta property="og:image:height" content="665"/>
    <meta property="og:locale" content="{{ app()->getLocale() }}"/>
    <meta property="og:type" content="website"/>
    <link rel="canonical" href="{{ url()->full() }}"/>
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('css/Chart.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('css/style3.css') }}">
    @endpush
@stop
@section('content')
    @php $lastCategoryKeyword = ''; @endphp
    <section class="estate">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                    @for($i = count($mainCategories) - 2; $i > -1; $i--)
                        @if($i == 0)
                            <li class="breadcrumb-item active"
                                aria-current="page">{{ $mainCategories[$i]['title'] }}</li>
                        @else
                            @php $lastCategoryKeyword = $mainCategories[$i]['keyword']; @endphp
                            <li class="breadcrumb-item">
                                <a href="{{ route('items-list', $mainCategories[$i]['keyword']) }}">{{ $mainCategories[$i]['title'] }}</a>
                            </li>
                        @endif
                    @endfor
                </ol>
            </nav>
            @if($noActualStatus == 1)
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning alert-dismissable custom-success-box">
                            <center>
                                <strong>
                                    {{ $itemErrosMsgText == 'moderating' ? trans('messages.Item in moderation') : trans('messages.Removed from publication') . $item['blocked_reason'] }}
                                    <a href="{{ route('items-list', $lastCategoryKeyword) }}">{{ trans('messages.See other ads in this category') }}</a>
                                </strong>
                            </center>
                        </div>
                    </div>
                </div>
            @endif
            <div class="estate_main estate_main_full">
                <div class="estate_main_left">
                    <div class="estete_swiper" itemscope itemtype="https://schema.org/Product" itemref="a">
                        @if(count($itemImages) > 0)
                            <div class="estete_swiper_left">
                                <div class="swiper-container gallery-top">
                                    <div class="swiper-wrapper">
                                        @foreach($itemImages as $image)
                                            <div class="swiper-slide"
                                                 style="background-image:url({{ $image->imageZ() }})">
                                                <a href="{{ $image->imageZ() }}" data-fancybox="gallery">
                                                    <img itemprop="image" src="{{ $image->imageZ() }}" alt="full">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next btn_swiper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="5.444" height="9.333"
                                             viewBox="0 0 5.444 9.333">
                                            <g transform="translate(-0.667 -0.333)">
                                                <path d="M1.036,0,0,1.1l3.365,3.57L0,8.237l1.036,1.1L5.444,4.667Z"
                                                      transform="translate(0.667 0.333)" fill="#8d9aaf"></path>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="swiper-button-prev btn_swiper">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="5.763" height="9.333"
                                             viewBox="0 0 5.763 9.333">
                                            <g transform="translate(-0.5 -0.333)">
                                                <path d="M-1.1,0,0,1.1l-3.562,3.57L0,8.237l-1.1,1.1L-5.763,4.667Z"
                                                      transform="translate(6.263 0.333)" fill="#8d9aaf"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                <div class="swiper-container gallery-thumbs">
                                    <div class="swiper-wrapper">
                                        @foreach($itemImages as $image)
                                            <div class="swiper-slide"
                                                 style="background-image:url({{ $image->imageZ() }})"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="estete_swiper_right" itemscope itemtype="https://schema.org/Offer"
                             itemprop="offers">
                            <h1 id="a" itemprop="name">{!! $item['title'] !!}
                                @if($item['shop_id'] != null)
                                    <a href="{{route('view-item-order' , $item['link'])}}"><i class="fa fa-shopping-basket"></i></a>
                                @endif
                                @if($item['verified'])
                                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <title>background</title>
                                            <rect fill="none" id="canvas_background" height="26" width="26" y="-1"
                                                  x="-1"/>
                                            <g display="none" overflow="visible" y="0" x="0" height="100%" width="100%"
                                               id="canvasGrid">
                                                <rect fill="url(#gridpattern)" stroke-width="0" y="1" x="1" height="400"
                                                      width="580"/>
                                            </g>
                                        </g>
                                        <g>
                                            <title>Layer 1</title>
                                            <g stroke="null" id="svg_8">
                                                <g stroke="null"
                                                   transform="matrix(0.31473841583413026,0,0,0.31473841583413026,0.6214128615470607,0.24038928926550263) "
                                                   id="svg_6">
                                                    <path stroke="null" fill="#17a2f2" id="svg_7"
                                                          d="m19.786233,41.744286c-0.173046,-0.186357 -0.32794,-0.386025 -0.461052,-0.593559c-0.133717,-0.208744 -0.250493,-0.43201 -0.346697,-0.663746c-0.321284,-0.765395 -0.408412,-1.591901 -0.27288,-2.380288c0.135532,-0.782942 0.491305,-1.531395 1.055217,-2.146737l0.205719,-0.211769c1.387392,-1.322046 3.491775,-1.568304 5.142366,-0.575408c0.235972,0.140978 0.461052,0.308578 0.671007,0.500381l0.020572,0.018757c1.168362,1.120563 3.145078,2.953276 4.442922,4.108327l1.113907,0.998947l13.63311,-14.300486c0.191803,-0.197853 0.402967,-0.375134 0.626232,-0.530029c0.228711,-0.157919 0.468918,-0.291637 0.716991,-0.399942c0.250493,-0.109515 0.515507,-0.195433 0.786572,-0.254728c0.27046,-0.0599 0.546365,-0.093784 0.820455,-0.099834l0.015731,0c0.27288,-0.003025 0.540315,0.016336 0.811379,0.062321c0.264409,0.044774 0.530029,0.116776 0.806539,0.223265c0.254728,0.097414 0.499171,0.219635 0.730302,0.365454c0.220845,0.139768 0.436245,0.306158 0.638939,0.497356l0.098019,0.088943c0.191198,0.189382 0.363638,0.395101 0.514297,0.613526c0.154894,0.223265 0.287401,0.463472 0.394496,0.712755c0.110725,0.250493 0.196643,0.515507 0.256544,0.785967c0.060506,0.265619 0.093179,0.541525 0.099834,0.822875l0,0.139163c-0.00242,0.241417 -0.025412,0.486465 -0.068976,0.728487c-0.047799,0.263199 -0.119801,0.522163 -0.2154,0.769026c-0.096809,0.252913 -0.220845,0.499171 -0.367269,0.732117c-0.144003,0.228106 -0.313419,0.447136 -0.503406,0.647409l-16.469005,17.280384c-0.193618,0.206929 -0.401152,0.388446 -0.618367,0.54334c-0.223265,0.159735 -0.464078,0.297082 -0.715781,0.412043c-0.252308,0.11375 -0.514902,0.203904 -0.779311,0.266224c-0.263199,0.062926 -0.537894,0.100439 -0.816825,0.113145l-0.075632,0.001815c-0.255938,0.005445 -0.508247,-0.009681 -0.750874,-0.047194l-0.061716,-0.012101c-0.251098,-0.042354 -0.49554,-0.10528 -0.729092,-0.187567c-0.254728,-0.090758 -0.504011,-0.207534 -0.741798,-0.347907l-0.038118,-0.024202c-0.224476,-0.135532 -0.433825,-0.288611 -0.624417,-0.456212l-0.038118,-0.036303c-0.955988,-0.887011 -1.994868,-1.789754 -3.045244,-2.702178c-1.819402,-1.58101 -4.343088,-3.861464 -5.855727,-5.4576l-0.005445,-0.004235l0,0zm16.367961,-41.134091c10.261741,0 19.560233,4.164597 26.291476,10.883133c6.718536,6.731242 10.882528,16.029735 10.882528,26.291476c0,10.262346 -4.164597,19.560838 -10.882528,26.292081c-6.730637,6.718536 -16.029735,10.882528 -26.291476,10.882528c-10.262346,0 -19.560838,-4.163992 -26.292081,-10.882528c-6.718536,-6.731242 -10.882528,-16.03034 -10.882528,-26.292686c0,-10.261136 4.163992,-19.559628 10.882528,-26.29087c6.731847,-6.718536 16.029735,-10.883133 26.292081,-10.883133l0,0zm21.454662,15.719946c-5.489668,-5.490273 -13.074644,-8.88524 -21.454662,-8.88524c-8.380623,0 -15.965599,3.394966 -21.455267,8.88524c-5.489668,5.489668 -8.884635,13.074644 -8.884635,21.454057c0,8.380623 3.394966,15.965599 8.884635,21.455267s13.074644,8.88524 21.455267,8.88524c8.380018,0 15.964994,-3.394966 21.454662,-8.88524s8.884635,-13.074644 8.884635,-21.455267c0,-8.379413 -3.394361,-15.964389 -8.884635,-21.454057l0,0z"/>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                @endif</h1>

                            <span class="swip_op">{{ trans('messages.Posted by') }}:</span>
                            <p itemprop="validFrom" class="swip_date_estate"
                               style="background-image: url('{{ asset('images/date.png') }}');">
                                {{ $item['date_cr_h'] }}
                            </p>
                            <div class="item-favorite-text">
                                <p class="swip_date_estate show_statistics"
                                   style="border-bottom: none; padding-bottom: 0; cursor: pointer;
                                       background-image: url('{{ asset('images/stat.png') }}')">
                                    @lang('messages.View statistics')
                                </p>
                            </div>
                            @if (Auth::check())
                                <div class="item-favorite-text">
                                    <div class="favoruites_product {{ $item['favorite'] ? 'active' : '' }}"
                                         data-url="{{ route('item-set-favorite',  [ 'id' => $item['id'], 'type' => 1]) }}"
                                         onclick="itemFavorite(this)"></div>
                                    <span>{{ trans('messages.Add to favourites') }}</span>
                                </div>
                                <div class="item-favorite-text">
                                    <p class="swip_date_estate open_form"
                                       style="border-bottom: none; background-image: url({{ $item_note ? "/images/add_note_on.png":"/images/add_note.png" }}); cursor: pointer">{{ trans('messages.Add to notes') }}</p>
                                </div>


                            @else
                                <div class="item-favorite-text">
                                    <div class="favoruites_product {{ $item['favorite'] ? 'active' : '' }}"
                                         data-url="{{ route('item-set-favorite-noauth', [ 'id' => $item['id'], 'type' => 1]) }}"
                                         onclick="itemFavorite(this)"></div>
                                    <span>{{ trans('messages.Add to favourites') }}</span>
                                </div>
                            @endif
                            @if ($item['price'] !== null)
                                <div class="price_est">
                                    <div class="torg_voz">
                                        <span>{{ trans('messages.Price') }}:</span>
                                        @if($item['price_ex'])<span>{{ $item['price_ex_title'] }}</span>@endif
                                    </div>
                                    <p><b itemprop="price">{{ $item['price'] }}</b></p>
                                </div>
                            @endif
                            <div class="adr">
                                <div class="torg_voz">
                                    <span>{{ trans('messages.Address') }}:</span>
                                    <div class="item_address_class">
                                        @if($item['map'])
                                            <a href="#">
                                                <span class="cart_ewr"
                                                      style="background-image: url(/images/in_cart.png);">
                                                    {{ trans('messages.On map') }}
                                                </span>
                                            </a>
                                        @endif
                                        <div class="item_map_view">
                                            <div id="map"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="address_product" itemprop="address">{{ $item['address'] }}</div>
                            </div>
                            <div class="number_ads_est">
                                <div class="torg_voz">
                                    <span>{{ trans('messages.Ad Number') }}:</span>
                                </div>
                                <p style="background-image: url(/images/id.png);">{{ $item['id'] }}</p>
                            </div>
                            <div class="number_ads_est">
                                <div class="torg_voz">
                                    <span>{{ trans('messages.Views') }}:</span>
                                </div>
                                <p style="background-image: url(/images/eye2.svg);">{{ $item['viewCount'] }}<span
                                        class="text-secondary font-weight-bold ml-1"
                                        title="{{trans('message.View in today')}}">(+{{ $item['today_view'] }})</span>
                                </p>
                            </div>
                            <div class="ya-share2 mt-2" data-curtain data-shape="round"
                                 data-services="vkontakte,facebook,odnoklassniki,telegram,twitter"></div>
                            <input type="hidden" id="coordinate_x" name="coordinate_x"
                                   value="{{ $item['coordinate_x'] }}"/>
                            <input type="hidden" id="coordinate_y" name="coordinate_y"
                                   value="{{ $item['coordinate_y'] }}"/>
                        </div>
                    </div>

                    @include('items.view.additional', ['item' => $item, 'dynpropValues' => $dynpropValues])

                    @include('items.view.contact', ['noActualStatus' => $noActualStatus])

                    @if($view_comments == 1)
                        @include('items.view.commentary', ['msgList' => $msgList, 'item' => $item, 'noActualStatus' => $noActualStatus])
                    @endif

                </div>
                <div class="estate_main_right">
                    @include('items.view.user-block', ['item' => $item, 'user' => $user, 'noActualStatus' => $noActualStatus,'users'=>$users])

                    @include('items.view.premium', ['premiumItems' => $premiumItems])
                </div>
            </div>
            @include('items.view.liked', ['likeItems' => $likeItems, 'title' => trans('messages.Other similar ads')])
            @if($user_items)
                @include('items.view.liked', ['likeItems' => $user_items, 'title' => trans('messages.User ads')])
            @endif
            <div class="pre_top aler">
                <div class="title">{{ trans('messages.New items') }}</div>
            </div>
            <section class="last_ads">
                <div class="lasts_main">
                    @include('items.view.gallery_page', ['itemsList' => $newItems])
                </div>
            </section>
        </div>
    </section>
    @include('items.view.modal')
    @include('items.view.show-phone')
    <div id="applications_form" class="close_black popup_moto" style="display: none; max-width: 500px">
        <div class="text-center">
            <p>@lang('messages.Leave an order')</p>
        </div>
        <form action="{{ route('to-order') }}" method="POST" class="form_ads niked" id="form_applications">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item['id'] }}">
            <div class="form-group">
                <label for="">@lang('messages.Full Name')</label>
                <input type="text" class="form-control" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="">@lang('messages.Phone number')</label>
                <input type="text" class="form-control" name="phone" placeholder="+998xx-xxx-xx-xx">
            </div>
            <div class="form-group">
                <label for="">@lang('messages.Address')</label>
                <input type="text" class="form-control" name="address">
            </div>
            <button type="submit" class="more_know blue">@lang('messages.Send')</button>
        </form>
    </div>
@endsection
@section('extra-js')
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
    <script src="https://yastatic.net/share2/share.js"></script>
    <script
        src="https://api-maps.yandex.ru/2.1/?lang={{ app()->getLocale() ==='oz'? 'uz' : app()->getLocale() }}"></script>
    <script>

        function copyToClipboard() {
            window.alert("@lang('messages.Phone copied to clipboard')");
            const el = document.createElement('textarea');
            el.value = $('.to_numb').html();
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        }

        $(document).on('click', '#open_openiun_block', function () {
            $('#form_op').slideToggle()
        })

        function setContactView(that) {
            var url = that.getAttribute("data-url");
            $.ajax(url, {type: 'GET'});
        }

        ymaps.ready(init);

        function init() {
            // Подключаем поисковые подсказки к полю ввода.
            let map, placemark;

            const coordinate_x = $('#coordinate_x').val() * 1;
            const coordinate_y = $('#coordinate_y').val() * 1;
            // Указывается идентификатор HTML-элемента.
            map = new ymaps.Map('map', {
                zoom: 10,
                center: [coordinate_x, coordinate_y],
                controls: ['zoomControl', 'fullscreenControl']
            });

            placemark = new ymaps.Placemark(map.getCenter(), {}, {
                preset: 'islands#redDotIconWithCaption',
                draggable: false
            });

            map.geoObjects.add(placemark);
        }

        $(document).on('click', '#claim', (event) => {
            $('#auto_up').modal();
        });

        $(document).on('click', '.open_form', function () {
            $('.add_notes').modal('show');
        });

        $(document).on('submit', '.popup_moto_form', function (event) {
            event.preventDefault();
            const action = $(this).attr('action');
            $.ajax({
                url: action,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: new FormData(event.target),
                processData: false,
                contentType: false,
                success: function (success) {
                    console.log(success)
                    $.fancybox.close();
                    $.fancybox.open({src: "#show_phone_popup_thanks", type: 'inline'});
                },
                error: function (error) {
                },
                cache: false,
                xhr: function () {
                    myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        return myXhr;
                    }
                }
            });

        });

        $.mask.definitions['9'] = '';
        $.mask.definitions['n'] = '[0-9]';
        $('input[name=phone]').mask("+998nn-nnn-nn-nn");

        $(document).on('submit', '#form_applications', function (event) {
            event.preventDefault();
            const action = $(this).attr('action');
            $('#form_applications .help-block').remove();
            $('#form_applications input').removeClass('is-invalid');
            $.ajax({
                url: action,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: new FormData(event.target),
                processData: false,
                contentType: false,
                success: function () {
                    $.fancybox.close();
                    $.fancybox.open({src: "#applications_form_thanks", type: 'inline'});
                    $('#form_applications')[0].reset();
                },
                error: function ({responseJSON}) {
                    const errors = responseJSON.errors;
                    for (const errorsKey in errors) {
                        const input = $(`input[name=${errorsKey}]`);
                        input.addClass('is-invalid');
                        input.parent().append(`<div class="help-block"><strong>${errors[errorsKey]}</strong></div>`);
                    }
                },
                cache: false,
                xhr: function () {
                    myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        return myXhr;
                    }
                }
            });
        });

        const message = $('textarea[name="message"]').text();
        let alert = false;
        if (message.length > 0) {
            alert = true;
            $('header')
                .next()
                .prepend('<div class="alert alert-success alert-dismissable custom-success-box" id="alert_note" style="margin: 15px;"><strong> ' + message + '</strong></div>');
        }


        $(document).on('submit', '#note-form', function (event) {
            event.preventDefault();
            const action = $(this).attr('action');
            $.ajax({
                url: action,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: new FormData(event.target),
                processData: false,
                contentType: false,
                success: function (success) {
                    $('.open_form').css('backgroundImage', "url(/images/add_note_on.png)");
                    $('.add_notes').modal('hide');
                    $('.success_save').modal('show');
                    if (alert) {
                        $('#alert_note').html("<b>" + success + "</b>");
                    } else {
                        $('header')
                            .next()
                            .prepend('<div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;"><strong> ' + success + '</strong></div>');
                    }
                },
                error: function (error) {
                },
                cache: false,
                xhr: function () {
                    myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        return myXhr;
                    }
                }
            });
        });

        $(document).on('click', '#claim_form input[name="reason"]', function (e) {
            if (parseInt(this.value) === {{ $another_reason }}) {
                $('#comment').show("slow");
                $('#comment textarea').attr('required', true);
            } else {
                $('#comment').hide("slow");
                $('#comment textarea').attr('required', false);
            }
        });

        $(document).on('click', '.show_statistics', function (event) {
            $.ajax({
                url: '{{ route('item-statistics', ['item' => $item['id']]) }}',
                type: 'GET',
                processData: false,
                contentType: false,
                success: function (success) {
                    $('#content').html(success);
                    $('.price_comparison').modal('show');
                },
                error: function (error) {
                },
                cache: false,
            });
        });
    </script>

@endsection
