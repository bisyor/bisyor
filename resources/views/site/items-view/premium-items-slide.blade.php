<section class="premium_ads_section">
    <div class="container">
        <hr class="hr_title">
        <div class="pre_top">
            <div class="title title_premium">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15">
                    <g><g><path fill="#f5a623" d="M4.831 4.901l1.905-3.86a.667.667 0 0 1 1.196 0l1.905 3.86 4.26.623c.547.08.765.751.369 1.137l-3.082 3.002.727 4.241a.667.667 0 0 1-.967.703l-3.81-2.004-3.81 2.004a.667.667 0 0 1-.967-.703l.727-4.241L.202 6.66a.667.667 0 0 1 .369-1.137z" /></g></g>
                </svg>
                {{ trans('messages.Premium announcements') }}
            </div>
            <div class="pre_btns">
                <div class="swiper-button-prev btn_swiper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="5.763" height="9.333" viewBox="0 0 5.763 9.333">
                        <g id="_Icon2" data-name="Icon" transform="translate(-0.5 -0.333)"><path id="_Icon_Color2" data-name="Icon Color" d="M-1.1,0,0,1.1l-3.562,3.57L0,8.237l-1.1,1.1L-5.763,4.667Z" transform="translate(6.263 0.333)" fill="#8d9aaf" /></g>
                    </svg>
                </div>
                <div class="swiper-button-next btn_swiper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="5.444" height="9.333" viewBox="0 0 5.444 9.333">
                        <g id="_Icon3" data-name="Icon1" transform="translate(-0.667 -0.333)"><path id="_Icon_Color3" data-name="Icon Color" d="M1.036,0,0,1.1l3.365,3.57L0,8.237l1.036,1.1L5.444,4.667Z" transform="translate(0.667 0.333)" fill="#8d9aaf" /></g>
                    </svg>
                </div>
            </div>
        </div>
        <div class="premium_swiper swiper-container">
            <div class="swiper-wrapper">
                @foreach($premiumItems as $item)  
                    <div class="swiper-slide">
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
                                <div class="favoruites_product {{ $item['favorite'] }}" data-url="{{ route('item-set-favorite', [ 'id' => $item['id'], 'type' => 1]) }}" onclick="itemFavorite(this)"></div>
                                @else
                                    <div class="favoruites_product {{ $item['favorite'] ? 'active' : '' }}" data-url="{{ route('item-set-favorite-noauth', [ 'id' => $item['id'], 'type' => 1]) }}" onclick="itemFavorite(this)"></div>
                                    <!-- <div class="favoruites_product_no_active" data-toggle="modal" data-target="#loginModal"></div> -->
                            @endif
                            <div class="premium premium_item_border">
                                <img src="/images/premium.png" alt="premium">
                                {{ trans('messages.Premium') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- <a href="#" class="more_know blue">{{ trans('messages.All items') }}</a> -->
    </div>
</section>