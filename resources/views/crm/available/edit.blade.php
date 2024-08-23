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
                        <h1>@lang('messages.Update')</h1>
                        <form action="{{ route('available.update', ['keyword' => $shop->keyword, $available]) }}" method="POST"
                              autocomplete="off"
                              class="form_ads niked" id="items-form">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type" class="control-label">@lang('messages.Item')</label>
                                        <select name="good_id" class="js-select2 form-control
                                         required @error('good_id') is-invalid @enderror" id="good_id"
                                                data-tags="true">
                                            <option value disabled="" {{ !old('good_id') ? 'selected':'' }}>{{ trans('messages.Select item') }}...</option>
                                            @foreach($goods as $good)
                                                <option {{ $good['id'] == $available->good_id ? 'selected':'' }}
                                                        value="{{ $good['id'] }}">{{ $good['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block">
                                            @error ('good_id')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="control-label">@lang('messages.Type')</label>
                                        <select name="type_parts_by" class="js-select2 form-control
                                         required @error('type_parts_by') is-invalid @enderror"
                                                data-minimum-results-for-search="Infinity"
                                        >
                                            <option value disabled="" {{ !old('type_parts_by') ? 'selected':'' }}>{{ trans('messages.Select type') }}...</option>
                                            @foreach($type_parts as $key => $type_part)
                                                <option {{ $key == $available->type_parts_by ? 'selected':'' }}
                                                        value="{{ $key }}">{{ $type_part }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block">
                                            @error ('type_parts_by')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">{{ trans('messages.Count')}}</label>
                                        <input type="number" name="count" class="form-control"
                                               required value="{{ old('count') ?? $available->count }}">
                                        <div class="help-block">
                                            @error ('count')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">{{ trans('messages.Price')}}</label>
                                        <input type="text" name="price" class="form-control" required
                                               value="{{ old('price') ?? $available->price }}">
                                        <div class="help-block">
                                            @error ('price')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">{{ trans('messages.Critical level')}}</label>
                                        <input type="number" name="residue" class="form-control"
                                               value="{{ old('residue') ?? $available->residue }}">
                                        <div class="help-block">
                                            @error ('residue')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="comment">{{ trans('messages.Comment')}}</label>
                                        <textarea class="form-control" name="comment" id="comment">{{ old('comment') ?? $available->comment }}</textarea>
                                        <div class="help-block">
                                            @error ('comment')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pr-3 justify-content-end">
                                <a href="{{ route('available.index', $shop->keyword) }}" class="more_know bg-warning">
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
