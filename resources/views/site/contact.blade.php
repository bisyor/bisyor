@extends('layouts.app')
@section('title'){!! $seo['site_settings_form_title'] !!}@endsection
@section('meta_block')
<meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['site_settings_form_keyword'] !!}">
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['site_settings_form_description'] !!}">
@foreach($langs as $lang)
    <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}" />
@endforeach
    <link rel="canonical" href="{{ url()->full() }}" />
@endsection()
@section('content')
<section class="contact_sec">
    <div class="container">
        <nav aria-label="breadcrumb" class="my_nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site-index') }}"> @lang('messages.Home') </a></li>
                <li class="breadcrumb-item active" aria-current="page">@lang('messages.To contact us') </li>
            </ol>
        </nav>

        <form action="{{ route('submit-message') }}" class="vacant_form niked" method="post">
            @csrf
            <h1>@lang('messages.Write us')</h1>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="name">@lang('messages.Your name')</label>
                        <input type="text" id = "name" name = "name" class="form-control" required="" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="email">@lang('messages.Your phone')</label>
                        <input type="text" class="form-control" id = "phone" name = "phone"
                               placeholder="+998xx-xxx-xx-xx" required="" value="{{ old('phone') }}">
                    </div>

                    <div class="form-group">
                        <label for="type">@lang('messages.Choose subject')</label>
                        <select name="type" class="js-select2" id="type">
                            <option value="1">@lang('messages.Error on the site')</option>
                            <option value="2">@lang('messages.Technical question')</option>
                            <option value="3">@lang('messages.Suggestion')</option>
                            <option value="4">@lang('messages.Other question')</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="type">@lang('messages.Message')</label>
                        <textarea name="message" id="message" class="form-control"></textarea>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button class="more_know blue" type="submit">@lang('messages.Submit message')</button>
            </div>
        </form>
    </div>
</section>
@endsection
@section('extra-js')
    <script>
        $.mask.definitions['9'] = '';
        $.mask.definitions['n'] = '[0-9]';
        $('input[name=phone]').mask("+998nn-nnn-nn-nn");
    </script>
@endsection
