@extends('layouts.app')
@section('title'){!! $seo['mtitle'] !!}@endsection
@section('meta_block')
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['mdescription'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['mkeywords'] !!}">
    @foreach($langs as $lang)
        <link rel="alternate" hreflang="{{ $lang->url }}"
              href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}"/>
    @endforeach
    <link rel="canonical" href="{{ url()->full() }}"/>
@endsection

@section('content')

    <section class="vacancy_bc shadow_bc" style="background-image: url(/images/vacan_bc.jpg);">
        <div class="container">
            <img src="/images/logo_white.svg" alt="Working">
            <h1> @lang('messages.Working at Bisyor means daily challenge and continuous development') </h1>
        </div>
    </section>
    <section class="vacan_ma">
        <div class="container">
            <h3> @lang('messages.Vacancy notifications')</h3>
            <h2> @lang('messages.We need congenial people sharing Bisyor values')</h2>
            <div class="development row">
                @foreach($vacancies as $vacancy)
                    <div class="col-lg-3 col-sm-6">
                        <div class="development_item">
                            <a href="{{ route('vacancy-list', ['id' => $vacancy['id']]) }}">{{$vacancy['name']}}</a>
                            <p>{{ trans('messages.Vacancy') }} - <span>{{ $vacancy['children'] }}</span></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
