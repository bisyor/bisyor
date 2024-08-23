@foreach($shopsList as $key => $shop)
    @php $itemCount = str_replace('{ads_count}', $shop['itemCount'], trans('messages.Items count')); @endphp
    <div class="product_horizontal">
        <a href="{{ route('shops-view', $shop['keyword']) }}"  class="product_item snim_ads">
            @if($key < 6)
                <img src="{{ $shop['logo'] }}" alt="{!! $shop['name'] !!}">
                @else
                    <img class="lazy" src="{{ config('app.noImage') }}" data-src="{{ $shop['logo'] }}" alt="{!! $shop['name'] !!}">
            @endif
            <div class="product_text" @if($shop['serviceMarked']) style="background-color: {{ $shop['serviceMarkedColor'] }}" @endif >
                <div class="elt_title">
                    <span>{{ $shop['catNames'] }}</span>
                    <div class="elt_date">{{ $itemCount }}</div>
                </div>
                <h3>{!! $shop['name'] !!}</h3>
                <div class="tru_about">{{ $shop['description'] }}</div>
                <div class="address_product">{{ $shop['address'] }}</div>
                <input type="hidden" name="coordinateX[]" value="{{ $shop['coordinate_x'] }}">
                <input type="hidden" name="coordinateY[]" value="{{ $shop['coordinate_y'] }}">
                <input type="hidden" name="shopNames[]" value="{{ $shop['name'] }}">
                <input type="hidden" name="shopCategories[]" value="{{ $shop['catNames'] }}">
                <input type="hidden" name="itemsCounts[]" value="{{ $itemCount }}">
                <input type="hidden" name="shopLogos[]" value="{{ $shop['logo'] }}">
                <input type="hidden" name="shopUrls[]" value="{{ route('shops-view', $shop['keyword']) }}">
            </div>
        </a>
        <!-- <div class="favoruites_product"></div> -->
        @if($shop['serviceFixed'])
            <div class="fastening"><img src="/images/fastening.png" alt="fastening">{{ trans('messages.Fix') }}</div>
        @endif
        @if($shop['serviceMarked'])
            <div class="premium ups_pre"><img src="/images/premium.png" alt="premium">{{ trans('messages.Quick') }}</div>
        @endif
    </div>
@endforeach
