@extends('layouts.app')
@section('title') {{ $item->title }} - @lang('messages.Video galerry') @endsection
@section('content')
    <section class="estate">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                </ol>
            </nav>
            <div class="row pb-3">
                @include('users.left_sidebar', ['user' => auth()->user()])
                <div class="col-xl-9 col-md-8 c_cabinet">
                    <div class="score_main">
                        <div class="score_main_top">
                            <a href="#"
                               onclick="window.history.back()"
                               class="btn btn-danger mr-1 ">
                                <i class="fa fa-arrow-left text-white"></i>
                                {{ trans('messages.Back') }}</a>
                            <a class="insco">{{ trans('messages.Video gallery') }}</a>
                            <div>
                                <a href="{{ route('video-gallery.create', $item->keyword) }}"
                                   class="btn btn-primary mr-1">
                                    <i class="fa fa-plus text-white"></i>
                                    {{ trans('messages.Create') }}</a>
                            </div>
                        </div>
                        <table class="table" >
                            <thead>
                            <tr>
                                <th style="width: 2%">#</th>
                                <th style="width: 48%">@lang('messages.Title')</th>
                                <th style="width: 4%">@lang('messages.Actions')</th>
                            </tr>
                            <tr>
                                {{--                        @include('crm.services.search')--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($video_galleries as $video)
                                <tr>
                                    <td>{{ $video_galleries->perPage()*($video_galleries->currentPage() - 1) + $loop->iteration }}</td>
                                    <td>{{ $video->title }}</td>
                                    <td>
                                        <a href="{{ route('video-gallery.edit', ['keyword' => $item->keyword, 'video_gallery' => $video->id]) }}"
                                           class="btn btn-primary  btn-sm "><i
                                                class="fa fa-edit"></i></a>
                                        <form action="{{ route('video-gallery.destroy', ['keyword' => $item->keyword, 'video_gallery' => $video->id]) }}"
                                              method="POST"
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
                        @includeWhen(!$video_galleries->items(), 'crm.includes.empty')
                        <div class="ml-3">
                            {{ $video_galleries->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
