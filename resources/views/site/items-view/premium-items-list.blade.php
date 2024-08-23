<section class="last_ads">
    <div class="container">
        <hr class="hr_title">
        <div class="pre_top">
            <div class="title title_premium">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15">
                    <g><g><path fill="#f5a623" d="M4.831 4.901l1.905-3.86a.667.667 0 0 1 1.196 0l1.905 3.86 4.26.623c.547.08.765.751.369 1.137l-3.082 3.002.727 4.241a.667.667 0 0 1-.967.703l-3.81-2.004-3.81 2.004a.667.667 0 0 1-.967-.703l.727-4.241L.202 6.66a.667.667 0 0 1 .369-1.137z" /></g></g>
                </svg>
                {{ trans('messages.Premium announcements') }}
            </div>

        </div>
        <div class="lasts_main">
            @foreach($premiumItems as $key => $item)
                <div class="product_mains col-md-3 col-sm-4 col-6">
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
                    <div class="premium premium_item_border">
                        <img src="/images/premium.png" alt="premium">
                        {{ trans('messages.Premium') }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>