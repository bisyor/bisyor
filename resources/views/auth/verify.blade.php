@extends('layouts.login-app')

@section('title'){{ trans('messages.SMS configuration') }} @endsection

@section('content')
<section class="registr shadow_bc" style="background-image: url(/images/registr_bc.jpg);">
    <form action="{{ route('verify-login-post') }}" method="POST" class="registr niked">
        @csrf
        <!-- <a href="{{ route('site-index') }}" class="logo_reg">
            <img src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" alt="{{ Config::get('settings.logo') }}">
        </a> -->
        <h1>{{ trans('messages.SMS configuration') }}</h1>
        <p class="number_sms">{!! $text !!}</p>
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $message)
                    <strong>{{ $message }}</strong>
                @endforeach
            </div>
        @endif
        <div class="form-group">
            <input type="text" name="sms_code" value="{{Session::get('sms_code')}}" class="form-control @if(Session::has('message')) is-invalid @endif" placeholder="{{ trans('messages.SMS code') }}">
            @if (Session::has('message'))
                <span class="help-block">
                    <strong style="color: red;">{{ Session::get('message') }}</strong>
                </span>
            @endif
        </div>
        <div class="change_numbers">
            <!-- <a href="registr.html">Изменить номер телефона</a> -->
            <a href="{{ route('retry-verify-code', ['login' => $login]) }}">{{ trans('messages.Send new code') }}</a>
        </div>
        <button class="more_know blue">{{ trans('messages.Send') }}</button>
    </form>
    <div class="reg_bottom">
        <p>© 2018-{{ date('Y') }} {{ trans('messages.Reserved text') }}</p>
        <p>
            {{ trans('messages.By question') }}:
            <a href="mailto:{{ Config::get('settings.email') }}">
                {{ Config::get('settings.email') }}
            </a>
        </p>
    </div>
</section>
@endsection
