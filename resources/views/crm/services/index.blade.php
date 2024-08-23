@extends('layouts.app')
@section('title'){{ trans('messages.Crm ') . $shop->name }} @endsection
@section('content')
    <section class="cabinet">
        <div class="container">
            @include('crm.includes.breadcrumb')
            <div class="row pb-3">
                @include('crm.includes.sidebar')
                <div class="col-xl-9 col-md-8">
                    <div class="score_main">
                        <div class="score_main_top">
                            <a class="insco">{{ trans('messages.Services') }}</a>
                            <div>
                                <a href="{{ route('services.create', $shop->keyword) }}"
                                   class="btn btn-primary mr-1">{{ trans('messages.Create') }}</a>
                                <a href="javascript:void(0);"
                                   data-fancybox data-src="#import_form"
                                   data-options='{"touch" : false}'
                                   class="btn btn-primary mr-1">{{ trans('messages.Import') }}</a>
                                <a href="{{ route('services.export', $shop->keyword) }}"
                                   class="btn btn-primary mr-1">{{ trans('messages.Export') }}</a>

                            </div>
                        </div>
                        <table class="table" >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="width: 48%">@lang('messages.Name')</th>
                                <th style="width: 48%">@lang('messages.Price')</th>
                                <th style="width: 4%">@lang('messages.Actions')</th>
                            </tr>
                            <tr>
                                @include('crm.services.search')
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>{{ $services->perPage()*($services->currentPage() - 1) + $loop->iteration }}</td>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ number_format($service->price, 0, '.', ' ') }}</td>
                                    <td>
                                        <a href="{{ route('services.edit', ['keyword' => $shop->keyword, $service]) }}"
                                           class="btn btn-primary  btn-sm "><i
                                                class="fa fa-edit"></i></a>
                                        <form action="{{ route('services.destroy', ['keyword' => $shop->keyword, $service]) }}" method="POST"
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
                        @includeWhen(!$services->items(), 'crm.includes.empty')
                        <div class="ml-3">
                            {{ $services->links() }}
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
