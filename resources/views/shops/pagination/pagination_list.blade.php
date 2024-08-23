@foreach($shopsList as $key => $shop)
    <div class="product_horizontal" style="height: 170px">
        @if(array_key_exists('is_banner', $shop))
            {!! $shop['code'] !!}
        @else
            <a href="{{ route('shops-view', $shop['keyword']) }}"  class="product_item snim_ads">
                @if($key < 6)
                    <img src="{{ $shop['logo'] }}" alt="{!! $shop['name'] !!}">
                @else
                    <img class="lazy" src="{{ config('app.noImage') }}" data-src="{{ $shop['logo'] }}" alt="{!! $shop['name'] !!}">
                @endif
                <div class="product_text" @if($shop['serviceMarked']) style="background-color: {{ $shop['serviceMarkedColor'] }}" @endif >
                    <div class="elt_title">
                        <span>{{ $shop['catNames'] }}</span>
                        <div class="elt_date">{{ str_replace('{ads_count}', $shop['itemCount'], trans('messages.Items count')) }}</div>
                    </div>
                    <div class="title_new_mag">
                        @if($shop['is_verify'])
                            <img src="{{ asset('images/is_verifiy.png') }}" style="width: 18px !important; height: 18px !important; border-radius: initial !important;" alt="Verifiy">
                        @endif
                        {!! $shop['name'] !!}</div>
                    <div class="description_new_mag">{{ $shop['description'] }}</div>
                    @if ($shop['address'])
                        <div class="address_product">{{ $shop['address'] }}</div>
                    @endif
                    <div>{{ $shop['work_time'] }}</div>
                </div>
            </a>
            @if($shop['serviceFixed'])
                <div class="fastening"><img src="/images/fastening.png" alt="fastening">{{ trans('messages.Fix') }}</div>
            @endif
            @if($shop['serviceMarked'])
                <div class="premium ups_pre"><img src="/images/premium.png" alt="premium">{{ trans('messages.Mark') }}</div>
            @endif
        @endif
    </div>
@endforeach
