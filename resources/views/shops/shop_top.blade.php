<div class="rest_top">
    <div class="rest_top_left">
        <img src="{{ $shop['cover'] }}" class="gener" alt="">
        <div class="rest_btns">
            <div>
                <div class="apple_btn">
                    <img src="{{ $shop['logo'] }}">
                </div>
            </div>
            <div>
                <a href="#" class="review_btn more_know" data-src="#review_set" data-fancybox>@lang('messages.Evaluation')</a>
                @if ($shop['subscribe'] === false)
                    <a href="{{ route('shop-subscribe', ['id' => $shop['id']]) }}"
                       class="review_btn more_know blue">@lang('messages.Subscribe')</a>
                @else
                    <a href="{{ route('shop-subscribe', ['id' => $shop['id']]) }}"
                       class="review_btn more_know blue bg-danger">@lang('messages.Unsubscribe')</a>
                @endif
            </div>
        </div>
        <div class="about_apples">
            <h1> {{ $shop['name']  }}
                @if($shop['is_verify'])
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 8.38095C16 7.17714 15.3334 6.13333 14.3635 5.63809C14.4808 5.30667 14.5448 4.94857 14.5448 4.57143C14.5448 2.88762 13.242 1.52533 11.636 1.52533C11.2779 1.52533 10.9351 1.58933 10.6182 1.71581C10.1473 0.697143 9.1508 0 8.00038 0C6.84996 0 5.85496 0.698667 5.38184 1.71429C5.06566 1.58857 4.72206 1.52381 4.36398 1.52381C2.75644 1.52381 1.45517 2.88762 1.45517 4.57143C1.45517 4.94781 1.5184 5.3059 1.63573 5.63809C0.666635 6.13333 0 7.17562 0 8.38095C0 9.52 0.595781 10.5128 1.47955 11.037C1.46431 11.1665 1.45517 11.296 1.45517 11.4286C1.45517 13.1124 2.75644 14.4762 4.36398 14.4762C4.72206 14.4762 5.0649 14.4107 5.38108 14.2857C5.85344 15.3021 6.84844 16 7.99962 16C9.15156 16 10.1466 15.3021 10.6182 14.2857C10.9343 14.4099 11.2772 14.4747 11.636 14.4747C13.2436 14.4747 14.5448 13.1109 14.5448 11.427C14.5448 11.2945 14.5357 11.165 14.5197 11.0362C15.4019 10.5128 16 9.52 16 8.38171V8.38095ZM10.9595 5.84076L7.65754 10.7931C7.54707 10.9585 7.36651 11.0476 7.18137 11.0476C7.07243 11.0476 6.96195 11.0171 6.86444 10.9516L6.77682 10.88L4.93691 9.04C4.71368 8.81676 4.71368 8.45486 4.93691 8.23238C5.16014 8.0099 5.52202 8.00838 5.74449 8.23238L7.093 9.57867L10.0071 5.20533C10.1824 4.94248 10.5374 4.87314 10.7995 5.04762C11.0631 5.22286 11.1347 5.5779 10.9595 5.84V5.84076Z" fill="#2E7CD9" />
                    </svg>
                @endif
            </h1>
            <div class="raiting_brend">
                <div class="raiting_stars">
                    @for($i = 1;  $i <=5; $i++)
                        <img src="{{ asset('images/' . ($shop['ratings'] >= $i ? 'star_full.svg':'star_full_bad.svg')) }}" alt="">
                    @endfor
                </div>
                <a href="#" data-src="#all_review_view" data-fancybox>{{ $shop['comments_count']  . " " . trans('messages.Comment') }}</a>
            </div>
            <div class="about_raiting_block_item">
                <p>@lang('messages.Work time'): <b> {{ $shop['work_time'] }}</b></p>
            </div>
            <div class="about_raiting_block_item">
                <p>
                    @lang('messages.Phone number'):
                    @foreach($shop['getPhones'] as $phone)
                        <a href="tel:{{ $phone != 'null' ? $phone : ''  }}" itemprop="telephone">{{ $phone != 'null' ? $phone : ''}}</a><br>
                    @endforeach
                </p>
            </div>
        </div>
    </div>
    @isset($premium_item)
    @includeWhen($premium_item, 'shops.premium_item', ['premium_item' => $premium_item])
    @endisset
</div>
