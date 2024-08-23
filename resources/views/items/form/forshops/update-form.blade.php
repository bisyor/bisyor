@extends('layouts.app')

@section('title') {{ trans('messages.Update items') }} @endsection

@section('content')
    <section class="ads">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Create items') }}</li>
                </ol>
            </nav>
            <div class="place_main">
                <h1>{{ trans('messages.Update items') }}</h1>
                <form action="{{ route('items-save-update', $model->link) }}" method="POST" autocomplete="off"
                      enctype="multipart/form-data" class="form_ads niked" id="items-form">
                    @csrf
                    @if($errors->any())
                        @include('items.form.error')
                    @endif
                    <div class="form-group required">
                        @php
                            $title = $model->title;
                            if(old('title') != null) $title = old('title');
                        @endphp
                        <label for="title" class="control-label">{{ trans('messages.Title') }}</label>
                        <input name="title" type="text"
                               class="form-control @error('title') is-invalid @enderror nativ-required"
                               placeholder="{{ trans('messages.Title') }}" value="{{ $title }}">
                        <span class="help-block">@if ($errors->has('title'))
                                <strong>{{ $errors->first('title') }}</strong>@endif</span>
                    </div>
                    <div class="form-group required">
                        @php
                            $shop_id = $model->shop_id;
                            if(old('shop_id') != null) $shop_id = old('shop_id');
                        @endphp
                        <label for="shop_id" class="control-label">{{ trans('messages.Select Shops') }}</label>
                        <select name="shop_id" class="js-select2" id="shop_id">
                            @foreach($shopList as $shop)
                                <option
                                    value="{{ $shop['id'] }}" @if($shop_id == $shop['id']) @endif>{{ $shop['name'] }}</option>
                            @endforeach
                        </select>
                        <span class="help-block">@if ($errors->has('shop_id'))
                                <strong>{{ $errors->first('shop_id') }}</strong>@endif</span>
                    </div>
                    @include('items.form.form_template_update')
                </form>
            </div>
        </div>
    </section>
    @php
        $img_site_name = config('app.imgSiteName').config('app.categoriesRoute');
    @endphp
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    @include('items.script.js-function')
@endsection
