@extends('layouts.app')
@section('title'){{ trans('messages.Shops') }} @endsection
@section('content')

<section class="cabinet">
    <div class="container">
        <nav aria-label="breadcrumb" class="my_nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Shops') }}</li>
            </ol>
        </nav>
        <div class="row pb-3">
            @include('users.left_sidebar', ['user' => $user])
            <div class="col-xl-9 col-md-6">
                <div class="lasfert">
                        @forelse($shopsList as $shop)
                            @php
                                //$itemCount = str_replace('{ads_count}', $shop['itemCount'], trans('messages.Items count'));
                                $status = trans('messages.Status'). ': ' . $shop['statusName'];
                            @endphp
                            <div class="row">
                                <div class="col-xl-10 col-md-11">
                                    <div class="product_horizontal">
                                        <a href="{{ route('shops-view', $shop['keyword']) }}"  class="product_item snim_ads">
                                            <img src="{{ $shop['logo'] }}" alt="{{ $shop['name'] }}">
                                            <div class="product_text" @if($shop['serviceMarked']) style="background-color: {{ $shop['serviceMarkedColor'] }}" @endif >
                                                <div class="elt_title">
                                                    <span>{{ $shop['catNames'] }}</span>
                                                    <div class="elt_date">{{ $status }}</div>
                                                </div>
                                                <h3>{{ $shop['name'] }}</h3>
                                                <div class="tru_about">{{ $shop['description'] }}</div>
                                                @if ($shop['address'])
                                                    <div class="address_product">{{ $shop['address'] }}</div>
                                                @endif
                                                <div>{{ $shop['work_time'] }}</div>
                                            </div>
                                        </a>
                                        @if($shop['serviceFixed'])
                                            <div class="fastening"><img src="/images/fastening.png" alt="Fix">{{ trans('messages.Fix') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-1">
                                    <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                        <a href="{{ route('clients.index', $shop['keyword']) }}" style="background-color:#ffc977" class="btn" title="CRM" >
                                            <i class="fas fa-address-book"></i>
                                        </a>
                                      <a href="{{ route('shops-update', $shop['keyword']) }}" style="background-color:#46b8da" class="btn" title="Изменить" >
                                          <i class="fas fa-pencil-alt"></i>
                                      </a>
                                      <a href="{{ route('shops-sliders', ['shop_id' => $shop['id']]) }}" style="background-color:#E3FFEC" class="btn" title="Список слайдов" >
                                          <i class="fa fa-list" aria-hidden="true"></i>
                                      </a>
                                      <button type="button" style="background-color:#ff5b57" class="btn shop_delete" title="{{ trans('messages.Delete') }}"
                                              data-path="{{ route('shops-delete', ['keyword' => $shop['id']]) }}">
                                          <i class="fa fa-trash" aria-hidden="true"></i>
                                      </button >
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="score_main">
                                <div class="free_score">
                                    <img src="/images/free_score.png" alt="No datas">
                                    <p>{{ trans('messages.No datas') }}</p>
                                </div>
                            </div>
                        @endforelse
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="auto_up" tabindex="-1" role="dialog" aria-labelledby="auto_up" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 400px">
        <div class="modal-content">
            <div class="modal-body">
                <div class="auto_up_top d-block mt-3 mb-3 text-center">
                    <span>{{ trans('messages.Confirm action') }}</span>
                </div>
            </div>
            <div class="modal-footer">
                <button class="more_know lets" data-dismiss="modal">{{ trans('messages.No') }}</button>
                <a class="btn btn-secondary more_know blue go_delete" href="">{{ trans('messages.Yes') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection


@section('extra-js')
    <script>
        $('.shop_delete').on('click', (button) => {
            let path = button.currentTarget.dataset.path;
            if(path){
                $('.go_delete').attr('href', path);
            }
            $('#auto_up').modal('show');
        });
    </script>
@endsection
