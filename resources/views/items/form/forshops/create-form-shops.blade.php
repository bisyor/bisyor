@extends('layouts.app')
@section('title'){!! $seo['items_add_ads_title'] !!}@endsection
@section('meta_block')
<meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['items_add_ads_description'] !!}">
<meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['items_add_ads_keyword'] !!}">
<link rel="canonical" href="{{ url()->full() }}"/>
@foreach($langs as $lang)
    <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}" />
@endforeach
<meta property="og:url" content="{{ url()->full() }}" />
<meta property="og:site_name" content="Bisyor.uz" />
<meta property="og:image:width" content="800" />
<meta property="og:image:height" content="665" />
<meta property="og:locale" content="{{ app()->getLocale() }}" />
<meta property="og:type" content="website" />
<link rel="canonical" href="{{ url()->full() }}" />
@stop

@section('content')
    <section class="ads">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Create items') }}</li>
                </ol>
            </nav>
            <div class="place_main">
                <h1>{!! $seo['items_add_ads_title_h1'] !!}</h1>
                <div class="place_tab">
                    <a href="{{ route('create-item') }}">{{ trans('messages.Private person') }}</a>
                    <a class="active">{{ trans('messages.Shops') }}</a>
                </div>
                <form action="{{ route('items-save-shops') }}" method="POST" autocomplete="off"
                      enctype="multipart/form-data" class="form_ads niked" id="items-form">
                    @csrf
                    @if($errors->any())
                        @include('items.form.error')
                    @endif
                    <div class="form-group required">
                        <label for="title" class="control-label">{{ trans('messages.Title') }}</label>
                        <input name="title" type="text"
                               class="form-control @error('title') is-invalid @enderror nativ-required"
                               placeholder="{{ trans('messages.Title') }}" value="{{ old('title') }}">
                        <span class="help-block">@if ($errors->has('title'))
                                <strong>{{ $errors->first('title') }}</strong>@endif</span>
                    </div>
                    <div class="form-group required">
                        <label for="shop_id" class="control-label">{{ trans('messages.Select Shops') }}</label>
                        <select name="shop_id" class="js-select2" id="shop_id" onchange="validated($(this))">
                            <option disabled selected>{{ trans('messages.Select') }}...</option>
                            @foreach($shopList as $shop)
                                <option
                                    value="{{ $shop['id'] }}" @if(old('shop_id') == $shop['id']) @endif>{{ $shop['name'] }}</option>
                            @endforeach
                        </select>
                        <span class="help-block">@if ($errors->has('shop_id'))
                                <strong>{{ $errors->first('shop_id') }}</strong>@endif</span>
                    </div>
                    @include('items.form.form_template')
                </form>
            </div>
        </div>
    </section>
    @php
        $img_site_name = config('app.imgSiteName').config('app.categoriesRoute');
    @endphp
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/items.js') }}?10"></script>
    @include('items.script.js-function')
@endsection
