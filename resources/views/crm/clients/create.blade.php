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
                        <form action="{{ route('clients.store', $shop->keyword) }}" method="POST"
                              autocomplete="off"
                              class="form_ads niked" id="items-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type" class="control-label">@lang('messages.Type')</label>
                                        <select name="type" class="js-select2 form-control
                                         required @error('type') is-invalid @enderror" id="type">
                                            @foreach($client_types as $key => $client_type)
                                                <option value="{{ $key }}">{{ $client_type }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block">
                                            @error ('type')
                                                <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fio">{{ trans('messages.Full Name')}}</label>
                                        <input type="text" name="fio" class="form-control" required value="{{ old('fio') }}">
                                        <div class="help-block">
                                            @error ('fio')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="company_name" @if(old('type') == 1 || old('type') == null) style="display: none" @endif>
                                        <label for="company_name">{{ trans('messages.Company')}}</label>
                                        <input type="text" name="company_name" class="form-control"
                                               value="{{ old('company_name') }}">
                                        <div class="help-block">
                                            @error ('company_name')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group gender" @if(old('type') == 2) style="display: none" @endif>
                                        <label for="">{{ trans('messages.Sex')}}</label>
                                        <select name="gender" class="js-select2 form-control
                                         @error('gender') is-invalid @enderror" id="type">
                                            <option value disabled="" {{ !old('type') ? 'selected':'' }}>{{ trans('messages.Select sex') }}...</option>
                                            @foreach($genders as $key => $gender)
                                                <option value="{{ $key }}">{{ $gender }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block">
                                            @error ('gender')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">{{ trans('messages.Phone number')}}</label>
                                        <input type="text" name="phone" class="form-control sirt"
                                               placeholder="+998xx-xxx-xx-xx" value="{{ old('phone') }}">
                                        <div class="help-block">
                                            @error ('phone')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">{{ trans('messages.inn')}}</label>
                                        <input type="text" name="inn" class="form-control"
                                               value="{{ old('inn') }}">
                                        <div class="help-block">
                                            @error ('inn')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label for="">{{ trans('messages.Email')}}</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                        <div class="help-block">
                                            @error ('email')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group required">
                                        <label for="">{{ trans('messages.Address')}}</label>
                                        <input type="text" name="address" class="form-control"
                                               value="{{ old('address') }}">
                                        <div class="help-block">
                                            @error ('address')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pr-3 justify-content-end">
                                <a href="{{ route('clients.index', $shop->keyword) }}" class="more_know bg-warning">
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

@section('extra-js')
    @include('crm.clients.script')
@endsection
