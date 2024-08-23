@extends('layouts.app')
@section('title'){{ trans('messages.Crm ') . $shop->name }} @endsection
@section('content')
    <section class="cabinet">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Settings') }}</li>
                </ol>
            </nav>
            <div class="row pb-3">
                @include('crm.includes.sidebar')
                <div class="col-xl-9 col-md-8">
                    <div class="place_main">
                        <h1>@lang('messages.Update')</h1>
                        <form action="{{ route('services.update', ['keyword' => $shop->keyword, $service]) }}" method="POST"
                              autocomplete="off"
                              class="form_ads niked" id="items-form">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ trans('messages.Name')}}</label>
                                        <input type="text" name="name" class="form-control" required value="{{ old('name') ?? $service->name }}">
                                        <div class="help-block">
                                            @error ('name')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">{{ trans('messages.Price')}}</label>
                                        <input type="number" name="price" class="form-control" required value="{{ old('price') ?? $service->price }}">
                                        <div class="help-block">
                                            @error ('price')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pr-3 justify-content-end">
                                <a href="{{ route('services.index', $shop->keyword) }}" class="more_know bg-warning">
                                    <span class="spinner fa fa-spinner fa-spin text-white"></span>
                                    {{ trans('messages.Close') }}
                                </a>
                                <button type="submit" class="more_know ml-5">
                                    <span class="spinner fa fa-spinner fa-spin text-white"></span>
                                    {{ trans('messages.Save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
