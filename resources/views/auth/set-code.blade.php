@extends('layouts.login-app')

@section('title'){{ trans('messages.SMS configuration') }} @endsection

@section('content')
@php
$text = filter_var($login, FILTER_VALIDATE_EMAIL) 
            ? str_replace('{email}', '<b> ' . $login . '</b> ', trans('messages.Send message to email')) 
            : str_replace('{phone_number}', '<b> ' . $login . ' </b>', trans('messages.Send message to phone'));
@endphp
<section class="registr shadow_bc" style="background-image: url(/images/registr_bc.jpg);">
    <form action="{{ route('new-password-post') }}" method="POST" autocomplete="off" class="registr niked">
        @csrf
        <a href="{{ route('site-index') }}" class="logo_reg">
            <img src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" alt="{{ Config::get('settings.logo') }}">
        </a>
        <h1>{{ trans('messages.SMS configuration') }}</h1>
        <p class="number_sms">{!! $text !!}</p>
        <div class="form-group">
            <input type="text" name="sms_code" value="{{ old('sms_code') }}" class="form-control @error('sms_code') is-invalid @enderror" placeholder="{{ trans('messages.SMS code') }}">
            @if ($errors->has('sms_code'))
                <span class="help-block">
                    <strong style="color:red;">{{ $errors->first('sms_code') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required value="{{ old('password') }}" placeholder="{{ trans('messages.New Password') }}">
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong style="color:red;">{{ $errors->first('password') }}</strong>
                </span>
            @endif
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