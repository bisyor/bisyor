@extends('layouts.app')
@section('title'){{ trans('messages.Crm ') . $shop->name }} @endsection
@section('content')
    <section class="cabinet">
        <div class="container">
            @include('crm.includes.breadcrumb')
            <div class="row pb-3">
                @include('crm.includes.sidebar')
                <div class="col-xl-9 col-md-8 c_cabinet">
                    @if($errors->any())
                        <div class="error_lis">
                            <p>{{ trans('messages.Import error text') }}</p>
                            <ul>
                                @foreach ($errors->all() as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <ul class="nav tab_top_cabinet justify-content-between">
                            <li><a data-toggle="tab" class="active show" href="#leftovers">{{ trans('messages.Leftovers') }}</a></li>
                            <li><a data-toggle="tab" class=""  href="#you_need">{{ trans('messages.You need to order') }}</a></li>
                            <div class="d-flex">
                                <div>
                                    <a href="{{ route('available.create', $shop->keyword) }}"
                                       class="btn btn-primary mr-1">{{ trans('messages.Create') }}</a>
                                    <a href="javascript:void(0);"
                                       data-fancybox data-src="#import_form"
                                       data-options='{"touch" : false}'
                                       class="btn btn-primary mr-1">{{ trans('messages.Import') }}</a>
                                    <a href="{{ route('available.export', $shop->keyword) }}"
                                       class="btn btn-primary mr-1">{{ trans('messages.Export') }}</a>
                                </div>
                            </div>
                        </ul>
                        <div class="tab-content">
                            <div id="leftovers" class="tab-pane fade active show">
                                <div class="score_main">
                                    <div class="score_main_top">
                                        <a class="insco">{{ trans('messages.Leftovers') }}</a>
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <td>#</td>
                                            <th>@lang('messages.Product')</th>
                                            <th>@lang('messages.Count')</th>
                                            <th>@lang('messages.Price')</th>
                                            <th>@lang('messages.Type')</th>
                                            <th>@lang('messages.Actions')</th>
                                        </tr>
                                        <tr>
                                            @include('crm.available.search_full')
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($available as $value)
                                            <tr>
                                                <td>{{ $available->perPage()*($available->currentPage() - 1) + $loop->iteration }}</td>
                                                <td>{{ $value->good->name }}</td>
                                                <td>{{ $value->count }}</td>
                                                <td>{{ $value->price }}</td>
                                                <td>{{ $available_types[$value->type_parts_by] }}</td>
                                                <td>
                                                    <a href="{{ route('available.edit', ['keyword' => $shop->keyword, $value]) }}"
                                                       class="btn btn-primary  btn-sm "><i
                                                            class="fa fa-edit"></i></a>
                                                    <form action="{{ route('available.destroy', ['keyword' => $shop->keyword, $value]) }}" method="POST"
                                                          class="d-inline"
                                                          onsubmit='confirm("@lang('messages.Confirm action')")'>
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                                class="btn btn-danger btn-sm"><i
                                                                class="fa fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    @includeWhen(!$available->items(), 'crm.includes.empty')
                                    <div class="ml-3">
                                        {{ $available->links() }}
                                    </div>
                                </div>
                            </div>
                            <div id="you_need" class="tab-pane fade">
                                <div class="score_main">
                                    <div class="score_main_top">
                                        <a class="insco">{{ trans('messages.You need to order') }}</a>
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <td>#</td>
                                            <th>@lang('messages.Product')</th>
                                            <th>@lang('messages.Count')</th>
                                            <th>@lang('messages.Price')</th>
                                            <th>@lang('messages.Type')</th>
                                            <th>@lang('messages.Actions')</th>
                                        </tr>
                                        <tr>
                                            @include('crm.available.search_full')
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($need_available as $value)
                                            <tr>
                                                <td>{{ $available->perPage()*($available->currentPage() - 1) + $loop->iteration }}</td>
                                                <td>{{ $value->good->name }}</td>
                                                <td>{{ $value->count }}</td>
                                                <td>{{ $value->price }}</td>
                                                <td>{{ $available_types[$value->type_parts_by] }}</td>
                                                <td>
                                                    <a href="{{ route('available.edit', ['keyword' => $shop->keyword, $value]) }}"
                                                       class="btn btn-primary  btn-sm "><i
                                                            class="fa fa-edit"></i></a>
                                                    <form action="{{ route('available.destroy', ['keyword' => $shop->keyword, $value]) }}" method="POST"
                                                          class="d-inline"
                                                          onsubmit='confirm("@lang('messages.Confirm action')")'>
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                                class="btn btn-danger btn-sm"><i
                                                                class="fa fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    @includeWhen(!$need_available->items(), 'crm.includes.empty')
                                    <div class="ml-3">
                                        {{ $need_available->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>
    <div id="import_form" class="close_black popup_moto" style="display: none; max-width: 500px">
        <p class="text-center border-0">@lang('messages.Fill in the customer base via Excel')</p>
        <div class="text-center">
            <p>@lang('messages.Click the download button below to download the Excel spreadsheet sample')</p>
        </div>
        <div>
            <img src="images/openiun.png" alt="">
            <span class="blue_text">@lang('messages.Example'): </span>
            <a href="{{ route('available.example', $shop->keyword) }}"
               class="btn btn-warning mr-1">{{ trans('messages.Download') }}</a>
        </div>
        <form action="{{ route('available.import', $shop->keyword) }}"
              class="popup_moto_form" id="form_op" method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <input type="file" name="file">
            </div>
            <button type="submit" class="more_know blue">@lang('messages.Send')</button>
        </form>
    </div>

@endsection
