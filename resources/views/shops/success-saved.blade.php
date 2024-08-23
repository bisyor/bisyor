@extends('layouts.app')

@section('title') {{ trans('messages.Open shop') }} @endsection

@section('content')

<section class="cabinet">
    <div class="container">
        <nav aria-label="breadcrumb" class="my_nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Open shop') }}</li>
            </ol>
        </nav>
        <div class="row pb-3">
            @include('users.left_sidebar', ['user' => $user])
            <div class="col-xl-9 col-md-8 ">
                <div class="success_none_form">
                    <img src="/images/succes.png" alt="succes">
                    <h2>{{ trans('messages.Success shop changed') }} <br> "{{ $shop->name }}".</h2>
                    <a href="{{ route('site-index') }}" class="more_know blue">{{ trans('messages.Home') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>  
@endsection