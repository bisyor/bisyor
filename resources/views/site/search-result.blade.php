@extends('layouts.app')

@section('title'){!! $seo['items_all_category_title'] !!}@endsection
@section('meta_block')
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['items_all_category_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['items_all_category_keyword'] !!}">
    <link rel="canonical" href="{{ url()->full() }}" />
@endsection
@section('content')
    <section class="premium_ads_section items-list-class">
        <div class="container">
            <div class="sub_filter">
                @if ($catList)
                    @if (count($catList) > 20 && $allView != 1)
                        @foreach(array_splice($catList, 0, 20) as $category)
                            <a href="{{ route('site-search', $filtrDatas . '&keyword=' . $category['keyword'] ) }}">
                                {{ $category['title'] }} - <span style="font-weight: bold;">{{ $category['count'] }}</span>
                            </a>
                        @endforeach
                        <a href="{{ route('site-search', $filtrDatas . '&all=1' ) }}">
                            <span style="font-weight: bold;">{{ trans('messages.View all') }}</span>
                        </a>
                    @else
                        @foreach($catList as $category)
                            <a href="{{ route('site-search', $filtrDatas . '&keyword=' . $category['keyword'] ) }}">
                                {{ $category['title'] }} - <span style="font-weight: bold;">{{ $category['count'] }}</span>
                            </a>
                        @endforeach
                        {{--<a href="{{ route('site-search', $filtrDatas . '&all=0' ) }}">
                            <span style="font-weight: bold;">{{ 'Показать менше' }}</span>
                        </a>--}}
                    @endif
                @endif
            </div>
            <hr class="hr_title">
            @include('site.add.search-item-dynprop', [
                'currencies' => $currencies,
                'post' => $post,
                'keyword' => $keyword,
            ])
            <div class="naved_tit">
                <nav aria-label="breadcrumb" class="my_nav">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Search') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-12">
                    <h1 class="title">{{ trans('messages.Search by') .": ". request()->input('query') }}</h1>
                    @include('site.add.favorites-saved')
                    <div class="lasfert row" id="divScroll" data-page = {{ $page }}>
                        @if(!$is_result)
                            <div class="free_block items_list">
                                <img src="/images/free.png" alt="free">
                                <p>{{ str_replace(':query', request()->input('query'), trans('messages.Result not found')) }}</p>
                            </div>
                            <div class="col-md-12">
                                <h1 class="title last_ret">{{ trans('messages.New items') }}</h1>
                            </div>
                            @include('site.search_page')
                        @else
                            @include('site.search_page')
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
