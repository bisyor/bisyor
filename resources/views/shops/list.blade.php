@extends('layouts.app')
@section('title'){!! $currentCat == null ? $seo['shops_all_category_title'] : $seo['shops_category_title'] !!}@endsection
@section('meta_block')
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $currentCat == null ? $seo['shops_all_category_description'] : $seo['shops_category_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $currentCat == null ? $seo['shops_all_category_keyword'] : $seo['shops_category_keyword'] !!}">
    <meta property="og:url" content="{{ url()->full() }}" />
    <meta property="og:site_name" content="Bisyor.uz" />
    <meta property="og:image:width" content="800" />
    <meta property="og:image:height" content="665" />
    <meta property="og:locale" content="{{ app()->getLocale() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ asset('images/bisyor-cover.jpg') }}" />
@if($currentCat == null)
    <meta property="og:title" content="{!! $currentCat == null ? $seo['shops_all_category_title'] : $seo['shops_category_title'] !!}">
    <meta property="og:description" content="{!! $currentCat == null ? $seo['shops_all_category_description'] : $seo['shops_category_description'] !!}">
@else
    <meta property="og:title" content="{!! $currentCat == null ? $seo['shops_all_category_title'] : $seo['shops_category_title'] !!}">
    <meta property="og:description" content="{!! $currentCat == null ? $seo['shops_all_category_description'] : $seo['shops_category_description'] !!}">
@endif
@foreach($langs as $lang)
    <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}" />
@endforeach
    <link rel="canonical" href="{{ url()->full() }}" />
@endsection
@section('content')
    <section class="magazin_section">
        <div class="container">
            <div class="naved_tit">
                @if($currentCat !== null)
                    <h1 class="title last_ret">{!! $seo['shops_category_title'] !!}</h1>
                @else
                    <h1 class="title last_ret">{!! $seo['shops_all_category_titleh1'] !!}</h1>
                @endif
                <div class="ad_toggle_link">
                    <a href="{{ Route::currentRouteName() == 'shops-map' ? 'javascript:void(0)' : route('shops-map', $parameters ) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g><g><path d="M5.354 12.757l-4.357 2.49a.667.667 0 0 1-.997-.58V4.002c0-.24.128-.46.336-.579L4.993.762a.663.663 0 0 1 .65-.018l5.003 2.501 4.357-2.49a.667.667 0 0 1 .997.58V12c0 .24-.128.46-.336.579l-4.656 2.66a.664.664 0 0 1-.652.018zm-4.02-8.37v9.132l3.333-1.905v-9.13zm13.333 7.227v-9.13l-3.334 1.904v9.13zM6 2.413v9.176l4 2V4.413z" /></g></g>
                        </svg>
                        @lang('messages.On map')
                    </a>
                    <a href="{{ Route::currentRouteName() == 'shops-list' ? 'javascript:void(0)' : route('shops-list', $parameters ) }}" class="active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                            <g><g><path d="M6.22 14.269c0-.366.298-.663.667-.663h7.777c.369 0 .667.297.667.663a.664.664 0 0 1-.667.662H6.887a.664.664 0 0 1-.667-.662zm0-1.802c0-.365.298-.662.667-.662h7.777c.369 0 .667.297.667.662a.664.664 0 0 1-.667.662H6.887a.664.664 0 0 1-.667-.662zm0-3.802c0-.366.298-.662.667-.662h7.777c.369 0 .667.296.667.662a.664.664 0 0 1-.667.662H6.887a.664.664 0 0 1-.667-.662zm0-1.801c0-.366.298-.662.667-.662h7.777c.369 0 .667.296.667.662a.664.664 0 0 1-.667.662H6.887a.664.664 0 0 1-.667-.662zm0-3.402c0-.366.298-.663.667-.663h7.777c.369 0 .667.297.667.663a.664.664 0 0 1-.667.662H6.887a.664.664 0 0 1-.667-.662zm0-1.913c0-.365.298-.662.667-.662h7.777c.369 0 .667.297.667.662a.664.664 0 0 1-.667.662H6.887a.664.664 0 0 1-.667-.662zm-6 11.857a2.23 2.23 0 0 1 2.231-2.228 2.23 2.23 0 0 1 2.231 2.228 2.23 2.23 0 0 1-2.23 2.227A2.23 2.23 0 0 1 .22 13.406zm3.129 0a.896.896 0 0 0-.898-.894c-.496 0-.898.4-.898.894 0 .493.402.893.898.893s.898-.4.898-.893zM.22 7.926A2.23 2.23 0 0 1 2.451 5.7a2.23 2.23 0 0 1 2.231 2.228 2.23 2.23 0 0 1-2.23 2.227A2.23 2.23 0 0 1 .22 7.927zm3.129 0a.896.896 0 0 0-.898-.893c-.496 0-.898.4-.898.894 0 .493.402.893.898.893s.898-.4.898-.893zM.22 2.449A2.23 2.23 0 0 1 2.451.22a2.23 2.23 0 0 1 2.231 2.228 2.23 2.23 0 0 1-2.23 2.227A2.23 2.23 0 0 1 .22 2.448zm3.129 0a.896.896 0 0 0-.898-.894c-.496 0-.898.4-.898.894 0 .493.402.893.898.893s.898-.4.898-.893z" /></g></g>
                        </svg>
                        @lang('messages.List')
                    </a>
                </div>
                <div class="sort">
                    <span>@lang('messages.Sorting') : </span>
                    <div class=" dropdown_popup">
                        <a href="#" class=""><span>{{ $sortingName }}</span></a>
                        <div class="dropdown_popup_body">
                            @php $new = $parameters; $new['sorting'] = 'new'; @endphp
                            <a href="{{ route('shops-list', $new ) }}"><span>@lang('messages.New shops')</span></a>
                            @php $popular = $parameters; $popular['sorting'] = 'popular'; @endphp
                            <a href="{{ route('shops-list', $popular ) }}"><span>@lang('messages.Popular shops')</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-xl-3 col-md-4">
                    <div class="cabinet_left">
                        <ul>
                            <li>
                                <a href="{{ route('shops-list') }}"
                                   class="{{ $catKey ?: 'active' }}">
                                    {!! file_get_contents('images/icons/home.svg') !!}
                                    <span>@lang('messages.All categories')</span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('shops-list', ['category' => $category['keyword'] ]) }}"
                                       class="{{ $catKey == $category['keyword'] ? 'active' : '' }}">
                                        {!! file_get_contents('images/icons/' . $category['keyword'] . '.svg') !!}
                                        <span>{{ $category['title'] }} - <span>{{ $category['shopsCount'] }}</span></span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-9 col-md-8">
                    <div class="block_new_mag">
                        @include('shops.pagination.pagination_list')
                    </div>
                    @if($shopsList)
                        <noscript>
                            <div class="row col-12 mb-3">
                                <a class="btn-success__border mr-auto ml-auto"
                                   href="{{ route('shops-list', ['page' => $page, 'category' => $currentCat->keyword ?? null]) }}">
                                    {{ trans('messages.More view') }}</a>
                            </div>
                        </noscript>
                    @endif
                </div>
            </div>
        </div>
    </section>
<section class="most_popular_brands">
    <div class="container">
        <h3>@lang('messages.Popular brands')</h3>
        <div class="swiper-container">
            <div class="swiper-wrapper">
            @foreach($brands as $brand)
                <div class="swiper-slide" style="background-image: url({{ $brand->getLogo() }})"></div>
            @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
@section('extra-js')
    <script>
        var page = {{ $page ?: 1 }}; var flag = false;
        function infiniteLoad() { flag = false; }

        $(window).scroll(function () {
            if(flag) return;
            var footer = $('#footerId').get(0);
            var mostPopular = $('.most_popular_brands').get(0);
            var raznitsa = $(document).height() - $(window).height() - footer.scrollHeight - mostPopular.scrollHeight -200/* - phones.scrollHeight*/;

            if ($(window).scrollTop() > raznitsa ) {
                flag = true; page++;
                $.ajax({
                    url: "{{ route('shops-page') }}",
                    type: 'GET',
                    data: {
                        type : 'list',
                        page : page,
                        category : '{{ $catKey ? $catKey : 'all' }}',
                        sorting : '{{ request()->sorting ? request()->sorting : 'new' }}',
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        $('.block_new_mag').append(data.msg);
                        if(data.itemCount > 0) infiniteLoad();
                    }
                });
            }
        });
    </script>
@stop
