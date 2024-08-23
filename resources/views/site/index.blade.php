@extends('layouts.app')
@section('title'){!! $seo['site_settings_main_title'] !!}@endsection

@section('meta_block')
<meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['site_settings_main_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['site_settings_main_keyword'] !!}">
    <link rel="canonical" href="{{ url()->full() }}" />
@foreach($langs as $lang)
    <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}" />
@endforeach
    <meta property="og:url" content="{{ url()->full() }}" />
    <meta property="og:site_name" content="Bisyor.uz" />
    <meta property="og:image:width" content="800" />
    <meta property="og:image:height" content="665" />
    <meta property="og:locale" content="{{ app()->getLocale() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://bisyor.uz/images/bisyor-cover.jpg" />
    <meta property="og:title" content="{!! $seo['site_settings_main_title'] !!}">
    <meta property="og:description" content="{!! $seo['site_settings_main_description'] !!}">
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "WebSite",
      "name": "{!! $seo['site_settings_main_title'] !!}",
      "url": "https://bisyor.uz",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://bisyor.uz/search?query={search_term_string}&utm_source=google&utm_medium=search&utm_campaign=search_organic",
        "query-input": "required name=search_term_string"
      }
    }
    </script>
@endsection()

{{--@section('extra-js')
    <script>
        /*var page = 1; var flag = false;
        function infiniteLoad() { flag = false; }

        $(window).scroll(function () {
            if(flag) return;
            var footer = $('#footerId').get(0);
            var new_collection_reclams = $('#new_collection_reclams').get(0);
            var phones = $('#phones').get(0);
            var raznitsa = $(document).height() - $(window).height() - footer.scrollHeight - new_collection_reclams.scrollHeight;

            if ($(window).scrollTop() > raznitsa ) {
                flag = true; page++;
                $.ajax({
                    url: "{{ route('item-new-list') }}",
                    type: 'GET',
                    data: { page : page },
                    dataType: 'JSON',
                    success: function (data) {
                        $('#divScroll').append(data.msg);
                        $('.favoruites_product').on('click', function() {
                            $(this).toggleClass('active');
                        });
                        if(data.itemCount > 0) infiniteLoad();
                    }
                });
            }
        });*/
    </script>
@endsection--}}
@section('content')

<!-- <div class="loader loader-41">
    <img src="/images/ico-loader.png" alt="ico-loader">
</div> -->

@include('site.add.top-categories')
@if(config('settings.general_premium_view_type') == 1)
    @if(is_array($premiumItems) && count($premiumItems))
        @include('site.items-view.premium-items-slide', ['premiumItems' => $premiumItems])
    @endif
@else
    @if(is_array($premiumItems) && count($premiumItems))
        @include('site.items-view.premium-items-list', ['premiumItems' => $premiumItems])
    @endif
@endif

@if(isset($banners['site_index_item_before']))
    <section class="phones" id="phones">
        <div class="container">
            @if($banners['site_index_item_before']['type'] == 1)
            <div class="phones_main" style="background-image: url({{ $banners['site_index_item_before']['img'] }});" alt="{{ $banners['site_index_item_before']['alt']  }}">
                <h2>{{ $banners['site_index_item_before']['title'] }}</h2>
                <a href="{{ route('banner-item', $banners['site_index_item_before']['id'] ) }}" target="_blank" rel="nofollow" class="more_know">{{ trans('messages.Details') }}</a>
            </div>
            @else
                <div class="">
                    <br>
                    {!! $banners['site_index_item_before']['type_data'] !!}
                </div>
            @endif
        </div>
    </section>
@endif

@if(count($newItems))
    @include('site.new-items', ['newItems' => $newItems, 'seo' => $seo])
@endif

<section class="new_collection_reclams" id="new_collection_reclams">
    <div class="container">
        @include('site.add.banners-site-footer')

        @include('site.add.blogs')
    </div>
</section>
@endsection
