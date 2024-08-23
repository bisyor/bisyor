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
                    <div class="score_main">
                        <div class="score_main_top">
                            <a class="insco">{{ trans('messages.Clients') }}</a>
                            <div>
                                <a href="{{ route('order.create', $shop->keyword) }}"
                                   class="btn btn-primary mr-1">{{ trans('messages.Create') }}</a>
                                <a href="javascript:void(0);"
                                   data-fancybox data-src="#import_form"
                                   class="btn btn-primary mr-1">{{ trans('messages.Import') }}</a>
                                <a href="{{ route('clients.export', $shop->keyword) }}"
                                   class="btn btn-primary mr-1">{{ trans('messages.Export') }}</a>
                            </div>
                        </div>
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>@lang('messages.Status')</th>
                                <th>@lang('messages.Client')</th>
                                <th>@lang('messages.Price')</th>
                                <th>@lang('messages.Departments')</th>
                                <th>@lang('messages.Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->status_order }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>{{ $order->inn }}</td>
                                    <td>
                                        <a href="{{ route('clients.edit', ['keyword' => $shop->keyword, $order]) }}"
                                           class="btn btn-primary  btn-sm "><i
                                                class="fa fa-edit"></i></a>
                                        <form action="{{ route('clients.destroy', ['keyword' => $shop->keyword, $order]) }}" method="POST"
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
                        @includeWhen(!$orders->items(), 'crm.includes.empty')
                        <div class="ml-3">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="import_form" class="close_black popup_moto" style="display: none; max-width: 500px">
        <p class="text-center border-0">@lang('messages.Upload data from an Excel file to the Services table')</p>
        <div class="text-center">
            <p>@lang('messages.Click the download button below to download the Excel spreadsheet sample')</p>
        </div>
        <div>
            <img src="images/openiun.png" alt="">
            <span class="blue_text">@lang('messages.Example'): </span>
            <a href="{{ route('services.example', $shop->keyword) }}"
               class="btn btn-warning mr-1">{{ trans('messages.Download') }}</a>
        </div>
        <form action="{{ route('services.import', ['keyword' => $shop->keyword]) }}"
              class="popup_moto_form" id="form_op" method="POST"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="file" name="file">
            </div>
            <button type="submit" class="more_know blue">@lang('messages.Upload')</button>
        </form>
    </div>
@endsection
