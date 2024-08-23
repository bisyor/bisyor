@foreach($items as $item)
    <div class="product_mains">
        <a href="{{ route('view-item', $item['link']) }}" class="product_item">
            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
                 itemscope itemtype="https://schema.org/Thing">
            <div class="product_text"
                 @if($item['serviceMarked']) style="background-color: {{ $item['serviceMarkedColor'] }}" @endif >
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
            <div class="favoruites_product {{ $item['favorite'] ? 'active' : '' }}"
                 data-url="{{ route('item-set-favorite', [ 'id' => $item['id'], 'type' => 1]) }}"
                 onclick="itemFavorite(this)"></div>
        @else
            <div class="favoruites_product {{ $item['favorite'] ? 'active' : '' }}"
                 data-url="{{ route('item-set-favorite-noauth', [ 'id' => $item['id'], 'type' => 1]) }}"
                 onclick="itemFavorite(this)"></div>
        @endif
        @if($item['servicePremium'])
            <div class="premium premium_item_border">
                <img src="/images/premium.png" alt="premium">{{ trans('messages.Premium') }}
            </div>
        @endif
        @if($item['serviceFixed'])
            <div class="fastening">
                <img src="/images/fastening.png" alt="fastening">{{ trans('messages.Fix') }}
            </div>
        @endif
        @if($item['serviceQuick'])
            <div class="premium ups_pre">
                <img src="/images/premium.png" alt="premium">{{ trans('messages.Quick') }}
            </div>
        @endif
    </div>
@endforeach
