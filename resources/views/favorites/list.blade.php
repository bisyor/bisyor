@extends('layouts.app')

@section('title'){{ trans('messages.Sorted search results') }} @endsection
@section('meta_block')
    <link rel="canonical" href="{{ url()->full() }}" />
@endsection
@section('content')
    <section class="premium_ads_section items-list-class">
        <div class="container">
            <div class="naved_tit">
                <nav aria-label="breadcrumb" class="my_nav">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Search') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-12">
                    <section class="result_section">
                        <div class="results_o">
                            <h2>{{ trans('messages.Sorted search results') }} ({{ count($favorites) }})</h2>
                            <div class="row">
                                @foreach($favorites as $favorite)
                                    <div class="col-lg-3 col-sm-4">
                                        <div class="results_o_item">
                                            <a href="{{ route('site-search', ['query' => $favorite['text']]) }}">
                                                <h5>{!! $favorite['text'] !!} <i class="fa fa-external-link-alt"></i> </h5>
                                                <div class="rukns">
                                                    <div>
                                                        <span>{{ trans('messages.Search time') }} :</span>
                                                        <p>{!! $favorite['date'] !!}</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="{{ route('delete-searched-text', ['type' => $favorite['type'], 'id' => $favorite['id']]) }}">
                                                <button><img src="/images/delete.svg" alt=""></button>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                                @if(count($favorites) == 0)
                                    <div class="free_block">
                                        <img style="align-items: center" src="/images/free.png" alt="No datas">
                                        <p>{{ trans('messages.Sorted search is not available') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection