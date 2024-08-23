@extends('layouts.app')

@section('title'){{ trans('messages.Favorites') }} @endsection

@section('content')

<section class="cabinet">
    <div class="container">
        <nav aria-label="breadcrumb" class="my_nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Favorites') }}</li>
            </ol>
        </nav>
        <div class="row pb-3">
            @include('users.left_sidebar', ['user' => $user])
            <div class="col-xl-9 col-md-8 c_cabinet">
                <ul class="nav tab_top_cabinet">
                    <!-- <li><a data-toggle="tab" class="active show" href="#ff0">{{ trans('messages.All favorites') }}</a></li> -->
                    <li><a data-toggle="tab" class="active show" href="#ff1">{{ trans('messages.Featured Ads') }}</a></li>
                    <li><a data-toggle="tab" href="#ff2">{{ trans('messages.Featured Search Results') }}</a></li>
                    <li><a data-toggle="tab" href="#ff3">{{ trans('messages.Recently watched') }}</a></li>
                </ul>
                <div class="tab-content">
                    <!-- <div id="ff0" class="tab-pane fade active show">
                        <div class="row">
                        </div>
                    </div> -->
                  <div id="ff1" class="tab-pane fade active show">
                      <div class="row">
                          @foreach($favorites as $item)
                              <div class="col-lg-4 col-6">
                                  <div class="product_mains">
                                      <a href="{{ route('view-item', $item['link']) }}" class="product_item">
                                          <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                                          <div class="product_text" @if($item['serviceMarked']) style="background-color: {{ $item['serviceMarkedColor'] }}" @endif >
                                              <span>{{ $item['categoryName'] }}</span>
                                              <div class="product_text_h4">{!! $item['title'] !!}</div>
                                              <div class="price_product">
                                                  <b>{{ $item['price'] }}</b>
                                                  <i>{{ $item['oldPrice'] }}</i>
                                              </div>
                                              <p class="negotiat">@if($item['price_ex']){{ $item['price_ex_title'] }}@endif</p>
                                              <div class="address_product">{{ $item['address'] }}</div>
                                          </div>
                                      </a>
                                      @if (Auth::check())
                                          <div class="favoruites_product {{ $item['favorite'] ? 'active' : '' }}" data-url="{{ route('item-set-favorite', [ 'id' => $item['id'], 'type' => 1]) }}" onclick="itemFavorite(this)"></div>
                                          @else
                                              <div class="favoruites_product {{ $item['favorite'] ? 'active' : '' }}" data-url="{{ route('item-set-favorite-noauth', [ 'id' => $item['id'], 'type' => 1]) }}" onclick="itemFavorite(this)"></div>
                                              <!-- <div class="favoruites_product" data-toggle="modal" data-target="#loginModal"></div> -->
                                      @endif
                                      @if($item['servicePremium'])
                                          <div class="premium premium_item_border"><img src="/images/premium.png" alt="premium">{{ trans('messages.Premium') }}</div>
                                      @endif
                                      @if($item['serviceFixed'])
                                          <div class="fastening"><img src="/images/fastening.png" alt="fastening">{{ trans('messages.Fix') }}</div>
                                      @endif
                                      @if($item['serviceQuick'])
                                          <div class="premium ups_pre"><img src="/images/premium.png" alt="premium">{{ trans('messages.Quick') }}</div>
                                      @endif
                                  </div>
                              </div>
                          @endforeach
                          @if(count($favorites) == 0)
                              <div class="free_block"> 
                                  <img src="/images/free.png" alt="free">
                                  <p>{{ trans('messages.Ads not found') }}</p>
                              </div>
                          @endif
                      </div>
                  </div>
                  <div id="ff2" class="tab-pane fade">
                      <div class="row">
                          <div class="col-12">
                            <section class="result_section">
                                <div class="results_o">
                                    <div class="row">
                                        @foreach($searchFavorites as $favorite)
                                            <div class="col-lg-4 col-sm-4">
                                                <div class="results_o_item">
                                                    <a href="{{ route('site-search', ['query' => $favorite['text']]) }}">
                                                        <h5>{!! $favorite['text'] !!} <i class="fa fa-external-link-alt"></i> </h5>
                                                        <div class="rukns">
                                                            <div>
                                                                <span>{{ trans('messages.Search time') }} :</span>
                                                                <p>{!! $favorite['date'] !!}</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <a href="{{ route('delete-searched-text', ['type' => $favorite['type'], 'id' => $favorite['id']]) }}">
                                                        <button><img src="/images/delete.svg" alt=""></button>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        </div>
                          @if(count($searchFavorites) == 0)
                              <div class="free_block"> 
                                  <img src="/images/free.png" alt="free">
                                  <p>{{ trans('messages.Ads not found') }}</p>
                              </div>
                          @endif
                      </div>
                  </div>
                  <div id="ff3" class="tab-pane fade">
                      <div class="row">
                          @foreach($viewFavorites as $item)
                              <div class="col-lg-4 col-6">
                                  <div class="product_mains">
                                      <a href="{{ route('view-item', $item['link']) }}" class="product_item">
                                          <img src="{{ $item['image'] }}" alt="{!! $item['title'] !!}">
                                          <div class="product_text" @if($item['serviceMarked']) style="background-color: {{ $item['serviceMarkedColor'] }}" @endif >
                                              <span>{{ $item['categoryName'] }}</span>
                                              <div class="product_text_h4">{!! $item['title'] !!}</div>
                                              <div class="price_product">
                                                  <b>{{ $item['price'] }}</b>
                                                  <i>{{ $item['oldPrice'] }}</i>
                                              </div>
                                              <p class="negotiat">@if($item['price_ex']){{ $item['price_ex_title'] }}@endif</p>
                                              <div class="address_product">{{ $item['address'] }}</div>
                                          </div>
                                      </a>
                                      @if (Auth::check())
                                          <div class="favoruites_product {{ $item['favorite'] ? 'active' : '' }}" data-url="{{ route('item-set-favorite', [ 'id' => $item['id'], 'type' => 1]) }}" onclick="itemFavorite(this)"></div>
                                          @else
                                              <div class="favoruites_product {{ $item['favorite'] ? 'active' : '' }}" data-url="{{ route('item-set-favorite-noauth', [ 'id' => $item['id'], 'type' => 1]) }}" onclick="itemFavorite(this)"></div>
                                              <!-- <div class="favoruites_product" data-toggle="modal" data-target="#loginModal"></div> -->
                                      @endif
                                      @if($item['servicePremium'])
                                          <div class="premium premium_item_border"><img src="/images/premium.png" alt="premium">{{ trans('messages.Premium') }}</div>
                                      @endif
                                      @if($item['serviceFixed'])
                                          <div class="fastening"><img src="/images/fastening.png" alt="fastening">{{ trans('messages.Fix') }}</div>
                                      @endif
                                      @if($item['serviceQuick'])
                                          <div class="premium ups_pre"><img src="/images/premium.png" alt="premium">{{ trans('messages.Quick') }}</div>
                                      @endif
                                  </div>
                              </div>
                          @endforeach
                          @if(count($viewFavorites) == 0)
                              <div class="free_block"> 
                                  <img src="/images/free.png" alt="free">
                                  <p>{{ trans('messages.Ads not found') }}</p>
                              </div>
                          @endif
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection