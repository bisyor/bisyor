@extends('layouts.login-app')
@php

use App\Models\References\Seo;

$seo = Seo::getMetaAuth(Seo::getSeoKey('users', app()->getLocale()), app()->getLocale());

@endphp
@section('title'){!! $seo['users_recover_title'] !!} @endsection
@section('meta_block')
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['users_recover_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['users_recover_keyword'] !!}">
    <link rel="canonical" href="{{ url()->full() }}"/>
@stop

@section('content')
<section class="registr shadow_bc" style="background-image: url(/images/registr_bc.jpg);">
    <form method="POST" action="{{ route('forgot-password-post') }}" class="registr niked" autocomplete="off" >
        @csrf
        <a href="{{ route('site-index') }}" class="logo_reg">
            <img src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" alt="{{ Config::get('settings.logo') }}">
        </a>
        <h1>{{ trans('messages.Password recovery') }}</h1>
        <span class="help-block" >
            @if ($errors->has('phone_email'))
                <strong style="color:red;">{{ $errors->first('phone_email') }}<br></strong>
                @else
                    <strong>{{ trans('messages.Enter phone number or e-mail') }}<br></strong>
            @endif
            <br>
        </span>
        <div class="form-group">
            <input type="tel" name="phone" class="form-control tel_uz @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+998xx-xx-xx-xx">
            @if ($errors->has('phone'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <input type="text" name="email" class="form-control @php if($errors->has('email')) echo 'is-invalid' @endphp" value="{{ old('email') }}" placeholder="{{ trans('messages.Enter e-mail') }}" >
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <br>
        <button type="submit" class="more_know blue">{{ trans('messages.Send') }}</button>
        <div class="login-buttons">
            <a href="{{ url()->previous() }}">{{ trans('messages.Back') }}</a>
        </div>
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