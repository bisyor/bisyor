@extends('layouts.app')
@section('title'){!! $seo['items_user_title'] !!} @endsection
@section('meta_block')
@foreach($langs as $lang)
    <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}"/>
@endforeach
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['items_user_desctiption'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['items_user_keyword'] !!}">
    <link rel="canonical" href="{{ url()->full() }}"/>
@stop
@section('content')
    <section class="estate">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('user-items', ['login' => $user->getUserLogin()]) }}">{{ $user->getUserFio() }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans("messages.All $type") }}</li>
                </ol>
            </nav>
            <div class="aler">
                <h1 class="title">{{ trans("messages.All $type") }}</h1>
                <br>
            </div>
            <div class="estate_main">
                <div class="estate_main_left">
                    <div class="">
                        <div class="row lasts_main user-items-list-content" id="mm_656656">
                            @foreach($subscribers as $subscribe)
                                <div class="col-md-4 col-sm-4 col-6">
                                    <div class="product_mains">
                                        <a href="{{ route('user-items', $subscribe->{$type}->getUserLogin()) }}"
                                           class="product_item">
                                            <img src="{{ $subscribe->{$type}->getAvatar() }}"
                                                 alt="{{ $subscribe->{$type}->getUserFio() }}">
                                            <div class="product_text">
                                                <span></span>
                                                <h4>{{ $subscribe->{$type}->getUserFio() }}</h4>
                                                @if($subscribe->district !== "")
                                                    <div class="address_product">{{ $subscribe->district }}</div>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @include('items.view.right')
            </div>
        </div>
    </section>
    {{--    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script>
            var page = 1;
            var flag = false;

            function infiniteLoad() {
                flag = false;
            }

            $(window).scroll(function () {
                if (flag) return;
                var footer = $('#footerId').get(0);
                var raznitsa = $(document).height() - $(window).height() - footer.scrollHeight - 250/* - phones.scrollHeight*/;

                if ($(window).scrollTop() > raznitsa) {
                    flag = true;
                    page++;
                    $.ajax({
                        url: "{{ route('items-users-page') }}",
                        type: 'GET',
                        data: {
                            page: page,
                            login: '{{ $user->getUserLogin()  }}',
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            $('#mm_656656').append(data.msg);
                            if (data.itemCount > 0) infiniteLoad();
                        }
                    });
                }
            });
        </script>--}}
@endsection
