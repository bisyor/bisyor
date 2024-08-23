<section class="property">
    <div class="container">
        <div class="swiper-container top_swiper_property">
            <div class="swiper-wrapper">
                @foreach($topCategories as $category)
                <div class="swiper-slide">
                    <a href="{{ route('items-list', $category['keyword']) }}">
                        <img src="{{ $category['icon_b'] }}" alt="{{ $category['title'] }}">
                        <p>{{ $category['title'] }}</p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <div class="swiper-button-next btn_swiper">
            <svg xmlns="http://www.w3.org/2000/svg" width="5.444" height="9.333" viewBox="0 0 5.444 9.333">
                <g id="_Icon" data-name="Icon1" transform="translate(-0.667 -0.333)"><path id="_Icon_Color" data-name="Icon Color" d="M1.036,0,0,1.1l3.365,3.57L0,8.237l1.036,1.1L5.444,4.667Z" transform="translate(0.667 0.333)" fill="#8d9aaf" /></g>
            </svg>
        </div>
        <div class="swiper-button-prev btn_swiper">
          <svg xmlns="http://www.w3.org/2000/svg" width="5.763" height="9.333" viewBox="0 0 5.763 9.333">
              <g id="_Icon1" data-name="Icon" transform="translate(-0.5 -0.333)"><path id="_Icon_Color1" data-name="Icon Color" d="M-1.1,0,0,1.1l-3.562,3.57L0,8.237l-1.1,1.1L-5.763,4.667Z" transform="translate(6.263 0.333)" fill="#8d9aaf" /></g>
          </svg>
        </div>
    </div>
</section>