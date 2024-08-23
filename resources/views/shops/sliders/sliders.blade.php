@extends('layouts.app')

@section('title') {{ trans('messages.Sliders') }} @endsection


@section('content')

    <section class="cabinet">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Open shop') }}</li>
                </ol>
            </nav>
            <div class="row pb-3">
                @include('users.left_sidebar', ['user' => $user])
                <div class="col-xl-9 col-md-6">
                    <div class="lasfert">
                        <div class="nav tab_top_cabinet">
                            <a href="{{ route('profile-shops-list') }}" class="mr-5">{{ trans('messages.Back') }}</a>
                            <a href="{{ route('shops-slider-create', ['shop_id' => $shop]) }}">{{ trans('messages.Create slider') }}</a>
                        </div>
                        <div class="row">
                            @foreach($sliders as $value)
                                <div class="col-xl-10 col-md-11">
                                    <div class="product_horizontal">
                                        <a href="javascript:;" class="product_item snim_ads">
                                            <img src="{{  $value->getImage() }}" alt="{{ $value->title }}">
                                            <div class="product_text">
                                                <h3>{{ $value->title }}</h3>
                                                <div class="tru_about">{{ $value->text }}</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                               <div class="col-xl-2 col-md-1">
                                    <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                        <a href="{{ route('shops-slider-update', ['slider_id' => $value->id]) }}"
                                           style="background-color:#46b8da" class="btn" title="{{ trans('messages.Update') }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a href="{{ route('shops-slider-delete', ['slider_id' => $value->id]) }}"
                                           style="background-color:#ff5b57" class="btn"
                                                title="{{ trans('messages.Delete') }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection