@extends('layouts.app')
@section('title') {{ $message }} @endsection

@section('content')
    <section class="cabinet">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Profile') }}</li>
                </ol>
            </nav>
            <div class="row pb-3">
                @include('users.left_sidebar', ['user' => $user])
                <div class="col-xl-9 col-md-8 ">
                    <div class="success_none_form">
                        <img src="{{ $status == "success" ? '/images/success.png':'/images/error.png' }}" alt="Status Image">
                        <h2>{{ $message }}</h2>
                        <div class="form-group">
                            <a class="btn more_know" href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
