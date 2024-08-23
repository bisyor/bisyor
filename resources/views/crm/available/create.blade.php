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
                        <form action="{{ route('available.store', ['keyword' => $shop->keyword, 'id' => request('id')]) }}" method="POST"
                              autocomplete="off"
                              class="form_ads niked" id="items-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type" class="control-label">@lang('messages.Item')</label>
                                        <select name="good_id" class="js-select2 form-control
                                         required @error('good_id') is-invalid @enderror" id="good_id"
                                                data-tags="true">
                                            <option value disabled="" {{ !old('good_id') ? 'selected':'' }}>{{ trans('messages.Select item') }}...</option>
                                            @foreach($goods as $good)
                                                <option value="{{ $good['id'] }}">{{ $good['name'] }}</option>
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
                                                <option value="{{ $key }}">{{ $type_part }}</option>
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
                                               required value="{{ old('count') }}">
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
                                               value="{{ old('price') }}">
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
                                               value="{{ old('residue') }}">
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
                                        <textarea class="form-control" name="comment" id="comment">{{ old('comment') }}</textarea>
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
                        <div class="row mt-5">
                            <table class="table ">
                                <thead>
                                <tr>
                                    <th>@lang('messages.Product')</th>
                                    <th>@lang('messages.Count')</th>
                                    <th>@lang('messages.Price')</th>
                                    <th>@lang('messages.Type')</th>
                                    <th>@lang('messages.Actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($available as $value)
                                    <tr>
                                        <td>{{ $value->good->name }}</td>
                                        <td>{{ $value->count }}</td>
                                        <td>{{ $value->price }}</td>
                                        <td>{{ $value->type_parts_by }}</td>
                                        <td>
                                            <a href="{{ route('available.show', ['keyword' => $shop->keyword, $value]) }}"
                                               class="btn btn-primary  btn-sm "><i
                                                    class="fa fa-eye"></i></a>
                                            <form action="{{ route('available.destroy', ['keyword' => $shop->keyword, $value]) }}" method="POST"
                                                  class="d-inline"
                                                  onsubmit='confirm("@lang('messages.Confirm action')")'>
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('extra-js')
    <script>
        $(document).on('change', 'select[name=good_id]', function () {
            $.ajax({
                url: '{{ route("available.good-info", $shop->keyword) }}',
                type: 'GET',
                data: {id: $(this).val()},
                contentType: false,
                success: function (success) {
                    $('input[name=price]').val(success.cost);
                },
                error: function (success) {
                    /*This error responsive*/
                },
                cache: false,

                xhr: function () {
                    myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        return myXhr;
                    }
                }
            });
        });
    </script>
@endsection
