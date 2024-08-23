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
            <h1>{{ $vacancy['name'] }}</h1>
        </div>
    </section>
    <section class="inner_vacant">
        <div class="container">
            <a href="{{ route('vacancy') }}" class="back_vacant_specify"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><g><g><path d="M12 5a.667.667 0 0 1-.667.667H2.276l2.862 2.862a.667.667 0 1 1-.943.942l-4-4a.665.665 0 0 1 0-.942l4-4a.667.667 0 1 1 .943.942L2.276 4.333h9.057c.369 0 .667.299.667.667z"></path></g></g></svg>Вернуться к выбору специальностей</a>
        @foreach($vacancy['children'] as $vac)
                <div class="d-flex">
                    <b class="mr-1">{{ $vac['name'] }}</b><br>
                </div>
                <br>
                @foreach($vac['vacancies'] as $child)
                    <div class="d-flex">
                        <a class="ml-5 mr-1" href="{{ route('vacancy-view', ['id' => $child['id']]) }}">{{ $child['title'] }}</a>
                        <span class="text-secondary">({{ $child['vacancy_count'] . " "  . trans('messages.Vacancy') }})</span>
                    </div>
                @endforeach
                <br>
            @endforeach
        </div>
    </section>

@endsection
