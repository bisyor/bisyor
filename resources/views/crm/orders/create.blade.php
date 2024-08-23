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
                        <form action="{{ route('order.store', $shop->keyword) }}" method="POST"
                              autocomplete="off"
                              class="form_ads niked" id="items-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">@lang('messages.Comment')</label>
                                        <textarea class="form-control" name="comment" id="comment">{{ old('comment') }}</textarea>
                                        <div class="help-block">
                                            @error ('comment')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">@lang('messages.Type client')</label>
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
                                        <label for="type" class="control-label">@lang('messages.Client')</label>
                                        <select name="client_id" class="js-select2 form-control
                                         @error('client_id') is-invalid @enderror" >

                                        </select>
                                        <div class="help-block">
                                            @error ('client_id')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">@lang('messages.Type client')</label>
                                        <select name="type_order_by" class="js-select2 form-control
                                         @error('type') is-invalid @enderror" id="type">
                                            @foreach($client_types as $key => $client_type)
                                                <option value="{{ $key }}">{{ $client_type }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block">
                                            @error ('type_order_by')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">{{ trans('messages.Phone number')}}</label>
                                        <input type="text" name="phone" class="form-control tel_uz" required
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
                                        <label for="gender">{{ trans('messages.Sex')}}</label>
                                        <select name="gender" class="js-select2 form-control
                                         required @error('gender') is-invalid @enderror" id="type">
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
                                    <div class="form-group required">
                                        <label for="">{{ trans('messages.Email')}}</label>
                                        <input type="email" name="email" class="form-control"
                                               required value="{{ old('email') }}">
                                        <div class="help-block">
                                            @error ('email')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">{{ trans('messages.inn')}}</label>
                                        <input type="text" name="inn" class="form-control"
                                               required value="{{ old('inn') }}">
                                        <div class="help-block">
                                            @error ('inn')
                                                <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label for="">{{ trans('messages.Address')}}</label>
                                        <input type="text" name="address" class="form-control"
                                               required value="{{ old('address') }}">
                                        <div class="help-block">
                                            @error ('address')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="more_know prevent-button">
                                    <span class="spinner fa fa-spinner fa-spin text-white"></span>
                                    {{ trans('messages.Submit') }}
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
    @include('crm.orders.script')
@endsection
