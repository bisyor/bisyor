@extends('layouts.app')
@section('title'){{ trans('messages.Crm ') . $shop->name }} @endsection
@section('content')
    <section class="cabinet">
        <div class="container">
            @include('crm.includes.breadcrumb')
            <div class="row pb-3">
                @include('crm.includes.sidebar')
                <div class="col-xl-9 col-md-8">
                    <div class="place_main">
                        <h1>@lang('messages.Create')</h1>
                        <form action="{{ route('services.store', $shop->keyword) }}" method="POST"
                              autocomplete="off"
                              class="form_ads niked" id="items-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ trans('messages.Name')}}</label>
                                        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
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
                                        <input type="number" name="price" class="form-control" required value="{{ old('price') }}">
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
