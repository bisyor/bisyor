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
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Crm') }}</li>
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
                                <a href="{{ route('clients.create', $shop->keyword) }}"
                                   class="btn btn-primary mr-1">{{ trans('messages.Create') }}</a>
                                <a href="javascript:void(0);"
                                   data-fancybox data-src="#import_form"
                                   data-options='{"touch" : false}'
                                   class="btn btn-primary mr-1">{{ trans('messages.Import') }}</a>
                                <a href="{{ route('clients.export', $shop->keyword) }}"
                                   class="btn btn-primary mr-1">{{ trans('messages.Export') }}</a>
                            </div>
                        </div>
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('messages.Company')</th>
                                <th>@lang('messages.Full Name')</th>
                                <th>@lang('messages.Type')</th>
                                <th>@lang('messages.Phone number')</th>
                                <th>@lang('messages.Actions')</th>
                            </tr>
                            <tr>
                                @include('crm.clients.search')
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td>{{ $clients->perPage()*($clients->currentPage() - 1) + $loop->iteration }}</td>
                                    <td>{{ $client->company_name }}</td>
                                    <td>{{ $client->fio }}</td>
                                    <td>{{ $client->getClientType() }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>
                                        <a href="{{ route('clients.edit', ['keyword' => $shop->keyword, $client]) }}"
                                           class="btn btn-primary  btn-sm "><i
                                                class="fa fa-edit"></i></a>
                                        <form action="{{ route('clients.destroy', ['keyword' => $shop->keyword, $client]) }}" method="POST"
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
                        @includeWhen(!$clients->items(), 'crm.includes.empty')
                        <div class="ml-3">
                            {{ $clients->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('crm.clients.import-form')
@endsection
