@extends('layouts.app')
@section('title') {!! $seo['items_ads_favorites_title'] !!} @endsection
@section('meta_block')
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['items_ads_favorites_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['items_ads_favorites_keyword'] !!}">
    <link rel="canonical" href="{{ url()->full() }}"/>
    <meta property="og:url" content="{{ url()->full() }}" />
    <meta property="og:site_name" content="Bisyor.uz" />
    <meta property="og:image:width" content="800" />
    <meta property="og:image:height" content="665" />
    <meta property="og:locale" content="{{ app()->getLocale() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://bisyor.uz/images/bisyor-cover.jpg" />
    <meta property="og:title" content="{!! $seo['items_ads_favorites_title'] !!}">
    <meta property="og:description" content="{!! $seo['items_ads_favorites_description'] !!}">
@stop
@section('content')
    <section class="premium_ads_section items-list-class">
        <div class="container">
            <div class="sub_filter">
                @if ($catList)
                    @if($currentCategory !== null)
                        <a href="{{ route('noauth-user-favorites-list') }}" >
                            << {{ trans('messages.All items') }}
                        </a>
                    @endif
                    @foreach($catList as $category)
                        <a href="{{ route('noauth-user-favorites-list', ['keyword' => $category['keyword']]) }}" class={{ $category['keyword'] === $keyword ? "active" : '' }} >
                            {{ $category['title'] }} - <span style="font-weight: bold;">{{ $category['count'] }}</span>
                        </a>
                    @endforeach
                @endif
            </div>
            <div class="naved_tit">
                <nav aria-label="breadcrumb" class="my_nav">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Favorites List') }}</li>
                    </ol>
                </nav>
            </div>
            <hr class="hr_title">
            <div class="row">
                <div class="col-12">
                    @if($currentCategory !== null)
                        <h1>{{ $currentCategory->title }}</h1><br>
                        @else
                            <div class="title last_ret">
                                {{ trans('messages.Favorites List')}}
                                <a href="{{ route('noauth-user-delete-favorites') }}">
                                    <span style="float:right; color:red;">{{ trans('messages.Clear favorites') }} <i class="fas fa-trash-alt" style="color:red" aria-hidden="true"></i></span>
                                </a>
                            </div>
                    @endif
                    <div class="lasfert row" id="divScroll" data-page = {{ $page }}>
                        @include('site.search_page')
                        @if(count($itemsList) == 0)
                            <div class="free_block items_list">
                                <img src="/images/free.png" alt="free">
                                <p>{{ trans('messages.Ads not found') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('extra-js')
    <script>
        var flag = false;
        if(!$('#divScroll').data('page')) flag = true;
        function infiniteLoad() { flag = false; }

        $(window).scroll(function () {
            if(flag) return;
            var footer = $('#footerId').get(0);
            var raznitsa = $(document).height() - $(window).height() - footer.scrollHeight -250/* - phones.scrollHeight*/;

            if ($(window).scrollTop() > raznitsa ) {
                flag = true; page = $('#divScroll').data('page');
                $.ajax({
                    url: page,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (data) {
                        $('#divScroll').append(data.msg);
                        $('.favoruites_product').on('click', function() {
                            $(this).toggleClass('active');
                            /*var toggle = $(this).attr('data-toggle');
                            if(toggle != 'modal') $(this).toggleClass('active');*/
                        });
                        if(data.page){
                            infiniteLoad();
                            $('#divScroll').data('page', data.page);
                        }
                    }
                });
            }
        });
    </script>
@endsection
