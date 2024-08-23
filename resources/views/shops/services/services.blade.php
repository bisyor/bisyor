@extends('layouts.app')

@section('title'){{ trans('messages.Ad Promotion') }} @endsection

@section('content')
    <section class="cabinet">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item active"
                        aria-current="page">{{ trans('messages.Ad Promotion shops') }}</li>
                </ol>
            </nav>
            @if($status == 'error')
                @include('items.services.error')
            @endif
            <div class="place_main">
                <a href="{{ route('shops-view', $model->keyword) }}"
                   class="insco">{{ trans('messages.View shops') }}</a>
                <h1 class="mt-5">{{ trans('messages.Ad Promotion shops') }}</h1>
                <form action="{{ route('buy-services-shop', $model->id) }}" method="get" id="serivice-add" class="">
                    <div class="error"></div>
                    <div class="radio_mag innermag">
                        <input type="radio" value="0" name="services" id="notservice" data-price="0" checked>
                        <label for="notservice">
                            <img src="{{ config('app.noImage') }}" alt="Free" style="max-width: 100px; max-height: 50px; margin: 5px">
                            {{ trans('messages.No promotion') }}
                            <span style="position:absolute; right: 25px">{{ trans('messages.Free') }}</span>
                        </label>
                        <div class="description">
                            {{ trans('messages.No promotion description') }}
                        </div>
                    </div>
                    @foreach($services as $service)
                        <div class="radio_mag innermag">
                            <input type="radio" value="{{ $service->id }}" name="services" id="{{ $service->keyword }}"
                                   data-price="{{ $service->price }}">
                            <label for="{{ $service->keyword }}">
                                <img src="{{config('app.servicePath').$service->icon_s}}" alt="{{ $service->title }}"
                                     style="max-width: 100px; max-height: 100px; margin: 5px">
                                {{ $service->title }} <span
                                        style="position:absolute; right: 25px"><b>{{ $service->price }} </b>{{ trans('messages.sum') }}</span>
                            </label>
                            <div class="description" style="display: none">
                                {!! $service->description !!}
                            </div>
                        </div>
                    @endforeach
                    <div class="summa text-center">
                        <h5>{{ trans('messages.Total payable') }}: <b id="price">0</b> {{ trans('messages.sum') }}</h5>
                    </div>
                    <h4 class="text-center mt-5">{{ trans('messages.Select a Payment Method') }}</h4>
                    <div class="radio_mag innermag">
                        <input type="radio" name="payment_method" id="m1my" checked="" value="m1my">
                        <label for="m1my">
                            {{ trans('messages.My balance') }}
                            <b style="position: absolute;right: 5%;padding-left: 10px;">
                                {{ Auth::user()->balance . " ".trans('messages.sum')}}
                            </b>
                        </label>
                        <input type="radio" name="payment_method" id="m1er" value="m1er">
                        <label for="m1er"><img src="/images/payme.png" alt="payme"></label>
                        <input type="radio" name="payment_method" id="m2sev" value="m2sev">
                        <label for="m2sev"><img src="/images/click.png" alt="click"></label>
                    </div>
                    <div class="btm_cl form-group text-center mt-5">
                        <a href="{{ route('profile-items-list') }}" class="btn cans"
                           style="color: #cdd5ff">{{ trans('messages.Publish without ads') }}</a>
                        <button type="submit" class="more_know ">
                            {{ trans('messages.Buy') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('extra-js')
    <script>
        show = false;
        $('input[name="services"]').on('change', function (e) {
            if (show) {
                $('#' + show).next().next().hide();
            }
            $(this).next().next().fadeIn();
            show = $(this).attr('id');
            $('#price').html($(this).data('price'));
        });
        $('#serivice-add').submit(function () {
            var check = false;
            const inputs = $('input[name="services"]');
            for (const input of inputs) {
                if (input.checked) {
                    check = true;
                    break;
                }
            }
            if (!check) {
                $('.error').html('<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>Service not selected</div>');
                $('html, body').animate({
                    scrollTop: $('.alert').offset().top - 60
                }, 1000);
            }
            return check;
        });
    </script>
@endsection
