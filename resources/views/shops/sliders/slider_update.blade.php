@extends('layouts.app')

@section('title') {{ trans('messages.Update slider') }} @endsection
@section('content')
    <section class="cabinet">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a  href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Update slider') }}</li>
                </ol>
            </nav>
            <div class="row pb-3">
                @include('users.left_sidebar', ['user' => $user])
                <div class="col-xl-9 col-md-8">
                    <form action="{{ route('shops-slider-update-save') }}" method="POST" autocomplete="off"
                          enctype="multipart/form-data" class="op_marc">
                        @csrf
                        <input type="hidden" name="slider_id" value="{{ $slider->id }}">
                        <h2>{{ trans('messages.Slider information') }}</h2>
                        @if($errors->any())
                            <div class="error_lis">
                                <p>{{ trans('messages.Model error text') }}</p>
                                <ul>
                                    @foreach ($errors->all() as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="niked">
                            <div class="form-group">
                                <label for="name">{{ trans('messages.Title') }}*</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') ?: $slider->title }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description">{{ trans('messages.Description') }}*</label>
                                <textarea name="text" id="description"
                                          class="form-control @error('text') is-invalid @enderror">{{ old('text') ?: $slider->text }}</textarea>
                                @if ($errors->has('text'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('text') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="site">{{ trans('messages.Link for site') }}</label>
                                <input type="text" name="link" id="site" value="{{ old('link') ?: $slider->link }}"
                                       class="form-control @error('link') is-invalid @enderror"
                                       placeholder="www">
                                @if ($errors->has('link'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('link') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="pre_file">
                            <div class="pre_file_img ml-2" style="background-image: url('{{ (old('temp_address') ? config('app.trashPath').old('temp_address') : config('app.uploadPath') . 'shop-slider/'. $slider->image) }}')">
                            </div>
                            <div class="pre_file_right">
                                <p>{{ trans('messages.Photo for slide') }}
                                <input type="file" name="profile_image" accept="image/*" id="file_inp">
                                <input hidden="hidden" type="text" name="temp_address" id="temp_address"
                                       value="{{ old('temp_address') }}">
                                <label for="file_inp">{{ trans('messages.Precode file') }}...</label>
                                <span>{{ str_replace('{mb_count}', 3, trans('messages.Maximum file size')) }}</span>
                            </div>
                        </div>
                        <div class="niked">
                            <div class="btm_cl">
                                <a href="{{ route('profile-settings') }}"
                                   class="cans">{{ trans('messages.Cancel') }}</a>
                                <button class="op_ma">{{ trans('messages.Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('extra-js')
    <script>
        $("#file_inp").on('change', function (e) {
            $('.help-block').remove();
            const file = $('#file_inp')[0].files[0];
            const data = new FormData();
            const date = new Date();
            const filename = file.name;
            const date_int = date.getTime();
            const name = filename.split('.').shift();
            const ext = filename.split('.').pop();
            const file_size = Math.round((file.size / 1024));
            if (file_size <= 3072) {
                const new_name = 'bisyor_shop_' + date_int + '_' + name + '.' + ext;
                data.append('file', file);
                data.append('names', new_name);
                $('#temp_address').val(new_name);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route("shops-upload-image") }}',
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (success) {
                        const img_site_name = '{{ config("app.imgSiteName") }}' + success;
                        $('.pre_file_img').attr('style', 'background-image:url("' + img_site_name + '")');
                    },
                    error: function (error) {
                        alert("Error occur uploading image. Try again )");
                        $(".pre_file_img").css('background-image', 'url(\'{{ config("app.noImage") }}\')');
                    },
                    cache: false,

                    xhr: function () {
                        const myXhr = $.ajaxSettings.xhr();
                        if (myXhr.upload) {
                            $(".pre_file_img").css('background-image', 'url(\'{{ config("app.zzImg") }}\')');
                            return myXhr;
                        }
                    }
                });
            } else {
                $('.pre_file_right').append('<span class="help-block"><strong>{{ str_replace(':max', 3, trans('messages.This file big')) }}</strong></span>');
            }
        });
    </script>
@endsection