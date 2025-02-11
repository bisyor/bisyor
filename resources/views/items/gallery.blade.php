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
@section('content')

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
    var page = {{ $page ?: 1 }};
    var flag = false;
    function infiniteLoad() { flag = false; }

    $(window).scroll(function () {
        if(flag) return;
        var footer = $('#footerId').get(0);
        var raznitsa = $(document).height() - $(window).height() - footer.scrollHeight;

        if ($(window).scrollTop() > raznitsa ) {
            flag = true; page++;
            $.ajax({
                url: "{{ route('item-page-gallery') }}",
                type: 'GET',
                data: { keyword : "{{ $keyword }}", page : page },
                dataType: 'JSON',
                success: function (data) {
                    $('#divScroll').append(data.msg);
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
<section class="premium_ads_section">
    <div class="container">
        <div class="sub_filter">
            @if($keywordParent !== null)
                <a href="{{ route('items-gallery', $keywordParent) }}" class="active" >
                    << {{ $currentCategory['title'] }}
                </a>
            @endif
            @foreach($topCategories as $category)
                <a href="{{ route('items-gallery', $category['keyword']) }}">
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
            @include('items.item-header-list', ['active' => 3, 'keyword' => $keyword, 'address' => $address, 'urlParams' => $urlParams])
        </div>
    </div>
</section>

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

<section class="last_ads">
    <div class="container">
        @if($currentCategory !== null)
            <div class="pre_top aler">
                <h1 class="title">{{ $currentCategory['title'] }}</h1><br>
            </div>
            @else
                <div class="pre_top aler">
                    <h1 class="title">{{ trans('messages.Items List') }}</h1>
                </div>
        @endif
        <div class="lasts_main" id="divScroll">
            @foreach($itemsList as $key => $item)
                <div class="product_mains col-md-3 col-sm-4 col-6">
                    @if(array_key_exists('is_banner', $item))
                        {!! $item['code'] !!}
                    @else
                        <a href="{{ route('view-item', $item['link']) }}" class="product_item">
                            @if($key < 10)
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                            @else
                                <img class="lazy" src="{{ config('app.noImage') }}" data-src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                            @endif
                            <div class="product_text" @if($item['serviceMarked']) style="background-color: {{ $item['serviceMarkedColor'] }}" @endif >
                                <span>{{ $item['categoryName'] }}</span>
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
                <a class="btn-success__border mr-auto ml-auto" href="{{ route('items-gallery', ['page' => $page, 'keyword' => $currentCategory['keyword'] ?? '']) }}">{{ trans('messages.More view') }}</a>
            </div>
        </noscript>
    </div>
</section>

<section class="rubrica" id="rubrica">
    <div class="rubrica_top">
        <div class="container">
            <h4>{{ trans('messages.Main categories') }}</h4>
            <div class="rubrica_top_links">
                @for($i = count($mainCategories) - 1; $i > -1; $i--)
                    <a href="{{ $keyword == $mainCategories[$i]['keyword'] ? 'javascript:void(0)' : route('items-gallery', $mainCategories[$i]['keyword']) }}">
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
