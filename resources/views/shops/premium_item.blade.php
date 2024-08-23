<div class="product_mains">
    <a href="{{ route('view-item', $premium_item['link']) }}" class="product_item">
        <img src="{{ $premium_item['image'] }}" alt="{{ $premium_item['title'] }}"
             itemscope itemtype="https://schema.org/Thing">
        <div class="product_text"
             @if($premium_item['serviceMarked']) style="background-color: {{ $premium_item['serviceMarkedColor'] }}" @endif >
            <span>{{ $premium_item['categoryName'] }}</span>
            <h4>{!! $premium_item['title'] !!}</h4>
            <div class="price_product">
                <b>{{ $premium_item['price'] }}</b>
                <i>{{ $premium_item['oldPrice'] }}</i>
            </div>
            <p class="negotiat">@if($premium_item['price_ex']){{ $premium_item['price_ex_title'] }}@endif</p>
            <div class="address_product">{{ $premium_item['address'] }}</div>
        </div>
    </a>
    @if (Auth::check())
        <div class="favoruites_product {{ $premium_item['favorite'] ? 'active' : '' }}"
             data-url="{{ route('item-set-favorite', [ 'id' => $premium_item['id'], 'type' => 1]) }}"
             onclick="itemFavorite(this)"></div>
    @else
        <div class="favoruites_product {{ $premium_item['favorite'] ? 'active' : '' }}"
             data-url="{{ route('item-set-favorite-noauth', [ 'id' => $premium_item['id'], 'type' => 1]) }}"
             onclick="itemFavorite(this)"></div>
    @endif
    @if($premium_item['servicePremium'])
        <div class="premium $premium_item_border">
            <img src="/images/premium.png" alt="premium">{{ trans('messages.Premium') }}
        </div>
    @endif
    @if($premium_item['serviceFixed'])
        <div class="fastening">
            <img src="/images/fastening.png" alt="fastening">{{ trans('messages.Fix') }}
        </div>
    @endif
    @if($premium_item['serviceQuick'])
        <div class="premium ups_pre">
            <img src="/images/premium.png" alt="premium">{{ trans('messages.Quick') }}
        </div>
    @endif
</div>
