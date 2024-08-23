<div class="pre_top aler">
    <div class="title">{{ trans('messages.Latest Blog') }}</div>
    <a href="{{ route('blogs-list') }}">{{ trans('messages.All materials') }}</a>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="capital_left">
            @if($newBlogs[0] != null)
            <a href="{{ route('blogs-view', $newBlogs[0]['slug'] ) }}" class="capital_left_top">
                <img class="lazy" src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" data-src="{{ $newBlogs[0]['image'] }}" alt="{{ $newBlogs[0]['title'] }}">
                <span>{{ $newBlogs[0]['date_cr'] }}</span>
                <div class="a_capital_left_top_h3">{{ $newBlogs[0]['title'] }}</div>
                <p>{!! $newBlogs[0]['short_text'] !!}</p>
            </a>
            @endif
            <div class="capital_left_bottom">
                <div class="row">
                    @php $i = 0; @endphp
                    @foreach($newBlogs as $blog)
                        @php
                            if(++$i == 1) continue;
                        @endphp
                        <div class="col-xl-6 col-lg-12 col-md-6">
                            <a href="{{ route('blogs-view', $blog['slug'] ) }}">
                                <img class="lazy" src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" data-src="{{ $blog['image'] }}" alt="{{ $blog['title'] }}">
                                <p>{{ $blog['title'] }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @if($topPost != null)
    <div class="col-lg-6">
        <a href="{{ route('blogs-view', $topPost['slug']) }}" class="capital_right">
            <div class="over">{{ $topPost['catName'] }}</div>
            <img class="lazy" src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" data-src="{{  $topPost['image'] }}" alt="{{ $topPost['title'] }}">
            <div class="capital_right_h2">{{ $topPost['title'] }}</div>
            <p>{!! $topPost['short_text'] !!}</p>
            <div class="info_cap">
                <span><img src="/images/letter.svg" alt="letter">{{ $topPost['msgCount'] }}</span>
                <span><img src="/images/eye.svg" alt="eye">{{ $topPost['view_count'] }}</span>
            </div>
        </a>
    </div>
    @endif
</div>