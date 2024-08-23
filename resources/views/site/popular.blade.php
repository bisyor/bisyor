@extends('layouts.app')
@section('title'){!! $seo['site_settings_pupular_title'] !!}@endsection
@section('meta_block')
<meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['site_settings_pupular_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['site_settings_pupular_keyword'] !!}">
    <link rel="canonical" href="{{ url()->full() }}" />
@foreach($langs as $lang)
    <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? '/site-map':$lang->url.'/site-map') }}" />
@endforeach
@endsection
@section('content')
<section class="map_site">
    <div class="container">
        <nav aria-label="breadcrumb" class="my_nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site-index') }}"> @lang('messages.Home') </a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! $seo['site_settings_pupular_crumb'] !!}</li>
            </ol>
        </nav>
        <h1>{!! $seo['site_settings_pupular_titleh1'] !!}</h1>
        <div class="main_map_tags">
            @foreach($search_results as $value)
                <a href="{{route('site-search') }}?query={{ $value['query'] }}" class="tag">
                    {{ $value['query'] }}
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
