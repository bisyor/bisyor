@extends('layouts.app')
@section('title'){!! $seo['items_user_title'] !!} @endsection
@section('meta_block')
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
                    <li class="breadcrumb-item active" aria-current="page">{{ $user->getUserFio() }}</li>
                </ol>
            </nav>
            <div class="aler">
                <h1 class="title">{!! $seo['items_user_title_h1'] !!}</h1>
                <br>
            </div>
            <div class="estate_main">
                <div class="estate_main_left">
                    <div class="">
                        <div class="row lasts_main user-items-list-content" id="mm_656656">
                            @include('items.view.page')
                        </div>
                        <noscript>
                            <div class="row col-12 mb-3">
                                <a class="btn-success__border mr-auto ml-auto"
                                   href="{{ route('user-items', ['page' => $page, 'login' => $user->getUserLogin()]) }}">
                                    {{ trans('messages.More view') }}</a>
                            </div>
                        </noscript>
                    </div>
                </div>
                @include('items.view.right')
                @include('items.view.show-phone')

            </div>
        </div>
    </section>
@endsection
@section('extra-js')
    <script>
        function copyToClipboard(){
            window.alert("@lang('messages.Phone copied to clipboard')");
            const el = document.createElement('textarea');
            el.value = $('.to_numb').html();
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        }
        $(document).on('click', '#open_openiun_block', function(){
            $('#form_op').slideToggle()
        });
        $(document).on('submit', '.popup_moto_form', function (event) {
            event.preventDefault();
            const action = $(this).attr('action');
            console.log('ts')
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
                    $.fancybox.close();
                    $.fancybox.open({src: "#show_phone_popup_thanks", type : 'inline'});
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

        var page = {{ $page ?: 1 }};
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
    </script>
@endsection
