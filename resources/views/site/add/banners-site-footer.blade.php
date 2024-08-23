<div class="row">

    @if(isset($banners['site_index_item_after_left']))
        <div class="col-lg-6">
            @if($banners['site_index_item_after_left']['type'] == 1)
            <div class="new_wint_left">
                <h2>{{ $banners['site_index_item_after_left']['title'] }}</h2>
                <p>{{ $banners['site_index_item_after_left']['description'] }}</p>
                <a href="{{ route('banner-item', $banners['site_index_item_after_left']['id'] ) }}" target="_blank" rel="nofollow" class="more_know blue">{{ trans('messages.Details') }}</a>
                <img class="lazy" data-src="{{ $banners['site_index_item_after_left']['img'] }}" alt="{{ $banners['site_index_item_after_left']['alt'] }}">
            </div>
            @else
            <div class="">
                <br>
                {!! $banners['site_index_item_after_left']['type_data'] !!}
            </div>
            @endif
        </div>
    @endif

    @if(isset($banners['site_index_item_after_right']))
        <div class="col-lg-6">
            @if($banners['site_index_item_after_right']['type'] == 1)
            <div class="new_wint_right">
                <h2>{{ $banners['site_index_item_after_right']['title'] }}</h2>
                <p>{{ $banners['site_index_item_after_right']['description'] }}</p>
                <a href="{{ route('banner-item', $banners['site_index_item_after_right']['id'] ) }}" target="_blank" rel="nofollow" class="more_know">{{ trans('messages.Details') }}</a>
                <img class="lazy" data-src="{{ $banners['site_index_item_after_right']['img'] }}" alt="{{ $banners['site_index_item_after_right']['alt'] }}">
            </div>
            @else
            <div class="">
                <br>
                {!! $banners['site_index_item_after_right']['type_data'] !!}
            </div>
            @endif
        </div>
    @endif
    
</div>