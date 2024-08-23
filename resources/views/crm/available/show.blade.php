@extends('layouts.app')
@section('title'){{ trans('messages.Shops') }} @endsection
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
                    <div class="score_main">
                        <div class="score_main_top">
                            <p>@lang('messages.View item')</p>
                            <a href="{{ route('available.index', $shop->keyword) }}" class="more_know btn-sm">
                                <span class="spinner fa fa-spinner fa-spin text-white"></span>
                                {{ trans('messages.Close') }}
                            </a>
                        </div>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>@lang('messages.ID')</th>
                                    <td>{{ $available->id }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('messages.Item')</th>
                                    <td>{{ $available->good->name }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('messages.Price')</th>
                                    <td>{{ $available->price }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('messages.Count')</th>
                                    <td>{{ $available->count }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('messages.Type')</th>
                                    <td>{{ $available_types[$available->type_parts_by] }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('messages.Date')</th>
                                    <td>{{ \Carbon\Carbon::parse($available->created_at)->format('H:i:s d.m.Y')  }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('messages.Date')</th>
                                    <td>{{ \Carbon\Carbon::parse($available->updated_at)->format('H:i:s d.m.Y')  }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('crm.clients.import-form')
@endsection
