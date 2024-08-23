@extends('layouts.login-app')
@section('title'){!! $seo['users_auth_title'] !!} @endsection
@section('meta_block')
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['users_auth_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['users_auth_keyword'] !!}">
    <link rel="canonical" href="{{ url()->full() }}"/>
@stop
@section('content')
<section class="registr shadow_bc" style="background-image: url(/images/registr_bc.jpg);">
    <form method="POST" action="{{ route('login') }}" class="registr niked prevent-multiple-submitted" autocomplete="off" >
        {{ csrf_field() }}
        <a href="{{ route('site-index') }}" class="logo_reg">
            <img src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" alt="{{ Config::get('settings.logo') }}">
        </a>
        <h1>{{ trans('messages.Login') }}</h1>
        <div class="reg_social">
            <a href="{{ route('social.oauth', 'google') }}">
                <span>{{ trans('messages.Google') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"><g><g><g><path fill="#ea4335" d="M10.997 4.253c2.065 0 3.459.893 4.253 1.638l3.104-3.031C16.448 1.088 13.967 0 10.997 0 6.694 0 2.979 2.469 1.17 6.062l3.557 2.762c.892-2.652 3.36-4.57 6.27-4.57z"/></g><g><path fill="#4285f4" d="M21.56 11.249c0-.905-.073-1.565-.232-2.249H11v4.082h6.062c-.122 1.015-.782 2.542-2.249 3.57l3.471 2.688c2.078-1.919 3.276-4.742 3.276-8.091z"/></g><g><path fill="#fbbc05" d="M4.742 13.173a6.772 6.772 0 0 1-.366-2.175c0-.758.134-1.491.354-2.176L1.173 6.06A11.01 11.01 0 0 0 0 10.998c0 1.772.428 3.446 1.173 4.938l3.57-2.763z"/></g><g><path fill="#34a853" d="M11.004 22.004c2.97 0 5.464-.977 7.285-2.664l-3.471-2.689c-.93.648-2.176 1.1-3.814 1.1-2.908 0-5.377-1.919-6.257-4.571L1.19 15.942c1.809 3.594 5.512 6.062 9.814 6.062z"/></g><g/></g></g></svg>
            </a>
            <a href="{{ route('social.oauth', 'facebook') }}">
                <span>{{ trans('messages.Facebook') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="24" viewBox="0 0 12 24"><g><g><g/><g><path fill="#3b5998" d="M7.446 24V11.999h3.313l.44-4.136H7.445l.006-2.07c0-1.079.103-1.657 1.652-1.657h2.07V0H7.863C3.882 0 2.48 2.006 2.48 5.38v2.483H0V12h2.48V24z"/></g></g></g></svg>
            </a>
            <a href="{{ route('social.oauth', 'yandex') }}">
                <span>{{ trans('messages.Yandex') }}</span>
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path style="fill:#FF0000;" d="M363.493,0h-72.744C217.05,0,142.684,54.422,142.684,176.006c0,62.978,26.691,112.027,75.619,139.922
                  l-89.552,162.091c-4.246,7.666-4.357,16.354-0.298,23.24c3.963,6.725,11.21,10.741,19.378,10.741h45.301
                  c10.291,0,18.315-4.974,22.163-13.688L299.26,334.08h6.128v157.451c0,11.096,9.363,20.469,20.446,20.469h39.574
                  c12.429,0,21.106-8.678,21.106-21.104V22.403C386.516,9.213,377.05,0,363.493,0z M305.388,261.126h-10.81
                  c-41.915,0-66.938-34.214-66.938-91.523c0-71.259,31.61-96.648,61.194-96.648h16.554V261.126z" /><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                </svg>
            </a>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $message)
                    <strong>{{ $message }}</strong>
                @endforeach
            </div>
        @endif
        <div class="form-group">
            <input type="tel" name="login" class="form-control tel_uz"
                   required value="{{ old('login') }}" placeholder="+998xx-xx-xx-xx" >
        </div>
        {{--<div class="form-group">
            <input type="password" name="password" class="form-control" required value="{{ old('password') }}" placeholder="{{ trans('messages.Password') }}">
        </div>--}}
        <button type="submit" class="more_know blue prevent-button">
            <span class="spinner fa fa-spinner fa-spin text-white"></span> {{ __('messages.to_get_the_code') }}
        </button>
        <div class="login-buttons">
            {{--<a href="{{ route('forgot-password-get') }}">{{ trans('messages.Forgot password') }}</a>--}}
            <a href="{{ route('register') }}">{{ trans('messages.Registration') }}</a>
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
