@extends('layouts.login-app')

@section('title'){{ trans('messages.Successfully registered') }} @endsection

@section('content')
<section class="registr success_formed shadow_bc" style="background-image: url(/images/registr_bc.jpg);">
    <form action="#" class="registr niked">
        <a href="{{ route('site-index') }}" class="logo_reg">
            <img src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" alt="{{ Config::get('settings.logo') }}">
        </a>
        <div class="seccuse">
            <img src="/images/succes.png" alt="Success">
        </div>
        <h1>{{ trans('messages.Successfully registered') }}</h1>
        <a href="{{ route('site-index') }}" class="more_know blue">{{ trans('messages.Begin') }}</a>
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