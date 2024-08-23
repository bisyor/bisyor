@extends('layouts.app')
@section('title'){!! $seo['site_settings_mapregions_title'] !!}@endsection
@section('meta_block')
<meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['site_settings_mapregions_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['site_settings_mapregions_keyword'] !!}">
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
                <li class="breadcrumb-item active" aria-current="page">{!! $seo['site_settings_mapregions_crumb'] !!}</li>
            </ol>
        </nav>
        <h1>{!! $seo['site_settings_mapregions_titleh1'] !!}</h1>
        <div class="main_map_site">
            @foreach($headerCategories as $first)
                <div class="main_map_site_item">
                    <h4>{{ app()->getLocale() != App\Models\References\Additional::defaultLang() ? $first['translate']['field_value'] : $first['name']}}
                        <span>({{ $first['count'] }})</span>
                    </h4>
                    <ul>
                        @foreach($first['districts_item'] as $second)
                            <li>
                                <a href="{{ route('global-region', ['key' => $second['keyword'], 'time' => time() ]) }}"
                                   style="color:black">
                                    {{ app()->getLocale() != App\Models\References\Additional::defaultLang() ? $second['translate']['field_value'] : $second['name']}}
                                    <b>({{ $second['items_count'] }})</b>
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
