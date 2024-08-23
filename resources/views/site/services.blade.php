@extends('layouts.app')
@section('title'){!! $seo['site_settings_service_title'] !!}@endsection
@section('meta_block')
<meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['site_settings_service_keyword'] !!}">
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['site_settings_service_description'] !!}">
    <link rel="canonical" href="{{ url()->full() }}" />
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
    <meta property="og:title" content="{!! $seo['site_settings_service_title'] !!}">
    <meta property="og:description" content="{!! $seo['site_settings_service_description'] !!}">
@endsection()
@section('content')

<section class="servives_sec">
    <div class="container">
        <nav aria-label="breadcrumb" class="my_nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Services') }}</li>
            </ol>
        </nav>
        <div class="services_main">
            <h1>{{ trans('messages.How sell faster') }}</h1>
            <ul class="nav serv_ul">
                <li><a data-toggle="tab" class="active show" href="#etr0">{{ trans('messages.Ads') }}</a></li>
                <li><a data-toggle="tab" href="#etr1">{{ trans('messages.Shop') }}</a></li>
            </ul>
            <div class="tab-content">
                <div id="etr0" class="tab-pane fade active show">
                    @php $i=0; @endphp
                    @foreach($services as $service)
                        @if($service['module'] == 'bbs')
                            @php
                                if(++$i % 2 == 1) $class = '';
                                else $class = 'odd_serv';
                            @endphp
                            <div class="services_main_item {{ $class }} ">
                                <div class="services_main_item_left">
                                    <img src="{{ $service['icon_b'] }}" alt="{{ $service['title'] }}">
                                </div>
                                <div class="services_main_item_right">
                                    <h2>{{ $service['title'] }}</h2>
                                    <p>{!! $service['short_description'] !!}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div id="etr1" class="tab-pane fade">
                    @php $i=0; @endphp
                    @foreach($services as $service)
                        @if($service['module'] == 'shops')
                            @php
                                if(++$i % 2 == 1) $class = '';
                                else $class = 'odd_serv';
                            @endphp
                            <div class="services_main_item {{ $class }} ">
                                <div class="services_main_item_left">
                                    <img src="{{ $service['icon_b'] }}" alt="{{ $service['title'] }}">
                                </div>
                                <div class="services_main_item_right">
                                    <h2>{{ $service['title'] }}</h2>
                                    <p>{!! $service['short_description'] !!}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        @if(isset($banners['service_list']))
            <div class="serv_ariel">
                @if($banners['service_list']['type'] == 1)
                <div class="ser_img">
                    <img src="{{ $banners['service_list']['img'] }}" alt="{{ $banners['service_list']['alt'] }}">
                </div>
                <div class="serv_text">
                    <h2>{{ $banners['service_list']['title'] }}</h2>
                    <a href="{{ $banners['service_list']['url'] }}" target="_blank" class="more_know">{{ trans('messages.Details') }}</a>
                </div>
                @else
                    <div class="">
                    <br>
                    {!! $banners['service_list']['type_data'] !!}
                    </div>                
                @endif
            </div>
        @endif
        
    </div>
</section>  
@endsection