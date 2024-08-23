@extends('layouts.app')
@section('title'){{ trans('messages.Video gallery')  }} @endsection
@section('content')
    <section class="cabinet">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                </ol>
            </nav>
            <div class="row pb-3">
                @include('users.left_sidebar', ['user' => auth()->user()])
                <div class="col-xl-9 col-md-8">
                    <div class="place_main">
                        <h1>@lang('messages.Create')</h1>
                        <form action="{{ route('video-gallery.store', $item->keyword) }}" method="POST"
                              autocomplete="off"
                              enctype="multipart/form-data"
                              class="form_ads niked" id="items-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">{{ trans('messages.Title')}}</label>
                                        <input type="text" name="title" class="form-control" required
                                               value="{{ old('title') }}">
                                        <div class="help-block">
                                            @error ('title')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">{{ trans('messages.Video file')}}</label>
                                        <input type="file" name="video" class="form-control" required accept="video/*"
                                               value="{{ old('video') }}">
                                        <div class="help-block">
                                            @error ('video')
                                            <strong>{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pr-3 justify-content-end">
                                <a href="{{ route('video-gallery.index', $item->keyword) }}"
                                   class="more_know bg-warning">
                                    <span class="spinner fa fa-spinner fa-spin text-white"></span>
                                    {{ trans('messages.Cancel') }}
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
