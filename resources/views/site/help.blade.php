@extends('layouts.help')
@section('title'){!! $seo['helps_main_title'] !!}@endsection
@section('meta_block')
<meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['helps_main_keyword'] !!}">
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['helps_category_description'] !!}">
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
<meta property="og:image" content="https://bisyor.uz/images/bisyor-cover.jpg" />
<meta property="og:title" content="{!! $seo['helps_main_title'] !!}">
<meta property="og:description" content="{!! $seo['helps_category_description'] !!}">
@endsection()
@section('content')

<section class="helping">
    <div class="container">
        <nav aria-label="breadcrumb" class="my_nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Help') }}</li>
            </ol>
        </nav>
        <h1 class="title">{{ trans('messages.Help') }}</h1>
        <div class="help_tab">
            <div class="help_tab_left">
                <ul class="nav">
                    @foreach($categories as $help)
                        <li><a href="{{ route('help-in', $help['id']) }}">{{ $help['name'] }}</a></li>
                    @endforeach
                    <li style="display: none;"><a data-toggle="tab" href="#gesa"></a></li>
                </ul>
                <div class="tab_bottom_help">
                    <a href="tel:{{ Config::get('settings.phone') }}" class="tel_help">{{ Config::get('settings.phone') }}</a>
                    <a href="{{ route('contact') }}" class="support_services">{{ trans('messages.Support') }}</a>
                </div>
            </div>
            <div class="tab-content for_business">
                <div id="gesa" class="tab-pane show active">
                    <div class="in_hat">
                        @foreach($categories as $category)
                        <div>
                            <h4>{{ $category['name'] }}</h4>
                            <ul>
                                @foreach($category['helps'] as $help)
                                    <li><a href="{{ route('help-in', $help['helps_categories_id']) }}">{{ $help['name'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection