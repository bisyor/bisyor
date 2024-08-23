@extends('layouts.app')

@section('title') {{ trans('messages.Update items') }} @endsection

@section('content')
    <section class="ads">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Update items') }}</li>
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
                               class="form-control count_max @error('title') is-invalid @enderror nativ-required"
                               maxlength="70"
                               placeholder="{{ trans('messages.Title') }}" value="{{ $title }}">
                        <p class="count_chars">
                            <span>{{ 70- strlen($title) }}</span> {{ trans('messages.Characters left')}}
                        </p>
                        <span class="help-block">@if ($errors->has('title'))
                                <strong>{{ $errors->first('title') }}</strong>@endif</span>
                    </div>
                    @if(config('settings.general_editing_item_category') == 1)
                        <div id="categories" class="required">
                            <label for="category" class="control-label">{{ trans('messages.Category') }}</label>
                            <a data-fancybox data-src="#exampleModalCat" href="javascript:;"
                               class="for_cat_list form-control @error('cat_id') is-invalid @enderror">
                                {{ trans('messages.Select') }}...
                            </a>
                            <span class="help-block">
                                @if ($errors->has('cat_id'))
                                    <strong>{{ $errors->first('cat_id') }}</strong>
                                @endif
                            </span>
                        </div>
                    @else
                        <div class="form-group">
                            <label for="cat_id" class="control-label">{{ trans('messages.Category') }}*</label>
                            <input type="text" class="form-control" disabled value="{{ $model->category->getName() }}">
                            <span class="help-block"></span>
                        </div>
                    @endif
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
