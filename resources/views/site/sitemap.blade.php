@extends('layouts.app')
@section('title'){!! $seo['site_settings_sitemap_title'] !!}@endsection
@section('meta_block')
<meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['site_settings_sitemap_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['site_settings_sitemap_keyword'] !!}">
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
                <li class="breadcrumb-item active" aria-current="page">@lang('messages.Sitemap') </li>
            </ol>
        </nav>
        <h1> @lang('messages.Sitemap')</h1>
        <div class="main_map_site">
            @foreach($headerCategories as $first)
                <div class="main_map_site_item">
                    <img src="{{$first['icon_b']}}" alt="{{$first['title']}}">
                    <h4>{{$first['title']}}</h4>
                    <ul>
                        @foreach($first['secondMenu'] as $second)
                            <li>
                                <a href="{{route('items-list', $second['keyword']) }}" style="color:black">
                                    {{ $second['title'] }}
                                    <b>({{ $second['count'] }})</b>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
