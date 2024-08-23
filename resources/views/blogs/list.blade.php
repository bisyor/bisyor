@extends('layouts.app')
@section('title'){!! $seo['blog_list_title'] !!} @endsection

@section('meta_block')
<meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['blog_list_description'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['blog_list_keyword'] !!}">
    <link rel="canonical" href="{{ url()->full() }}"/>
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
    <meta property="og:title" content="{!! $seo['blog_list_title'] !!}">
    <meta property="og:description" content="{!! $seo['blog_list_description'] !!}">
@endsection()
@section('content')
<section class="blog_section">
    <div class="container">
        <nav aria-label="breadcrumb" class="my_nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Blog') }}</li>
            </ol>
        </nav>
        <h1 class="title">{{  $seo['blog_list_titleh1']  }}</h1>
        <ul class="blobg_ul nav">
            @foreach($categories as $category)
                <li><a href="{{ route('blogs-category', $category['key']) }}">{{ $category['name'] }}</a></li>
            @endforeach
        </ul>
        <div class="blog_main">
            @if($topPosts[0] != null)
                <a href="{{ route('blogs-view', $topPosts[0]['slug']) }}" class="capital_right blog_left shadow_bc" style="background-image: url({{  $topPosts[0]['image_m'] }})">
                    <div class="asy">
                        <div class="overasy">{{ $topPosts[0]['catName'] }}</div>
                        <span>{{ $topPosts[0]['date_cr'] }}</span>
                    </div>
                    <h2>{{ $topPosts[0]['title'] }}</h2>
                    <p>{!! $topPosts[0]['short_text'] !!}</p>
                    <div class="user_blog">
                        <img src="{{ $topPosts[0]['userAvatar'] }}" alt="{{ $topPosts[0]['title'] }}">
                        <div>
                            <span>{{ $topPosts[0]['userFio'] }}</span>
                            <!-- <span>UI/UX Designer</span> -->
                        </div>
                        <div class="info_cap">
                            <span><img src="/images/letter.svg" alt="letter">{{ $topPosts[0]['msgCount'] }}</span>
                            <span><img src="/images/eye.svg" alt="eye">{{ $topPosts[0]['view_count'] }}</span>
                        </div>
                    </div>
                </a>
            @endif

            <div class="blog_right">
                @if($topPosts[1] != null)
                <a href="{{ route('blogs-view', $topPosts[1]['slug']) }}" class="first_blog_link shadow_bc" style="background-image: url({{  $topPosts[1]['image_m'] }});">
                    <span>1</span>
                    <div>
                        <p>{{ $topPosts[1]['title'] }}</p>
                        <div class="date_blog">{{ $topPosts[1]['date_cr'] }}</div>
                    </div>
                </a>
                @endif
                @if($topPosts[2] != null)
                <a href="{{ route('blogs-view', $topPosts[2]['slug']) }}">
                    <span>2</span>
                    <div>
                        <p>{{ $topPosts[2]['title'] }}</p>
                        <div class="date_blog">{{ $topPosts[2]['date_cr'] }}</div>
                    </div>
                </a>
                @endif
                @if($topPosts[3] != null)
                <a href="{{ route('blogs-view', $topPosts[3]['slug']) }}">
                    <span>3 </span>
                    <div>
                        <p>{{ $topPosts[3]['title'] }}</p>
                        <div class="date_blog">{{ $topPosts[3]['date_cr'] }}</div>
                    </div>
                </a>
                @endif
            </div>
        </div>

        <div class="blogs_product">
            @foreach($categories as $category)
                @if( count($category['blogList']) > 0 )
                    <div class="pre_top blog_tit aler">
                        <div class="title">{{ $category['name'] }}</div>
                        @if( count($category['blogList']) >= 4 )
                            <a href="{{ route('blogs-category', $category['key']) }}">{{ trans('messages.View all') }}</a>
                        @endif
                    </div>
                    <div class="row">
                        @foreach($category['blogList'] as $blog)
                        <div class="col-lg-3 col-sm-6">
                            <a href="{{ route('blogs-view', $blog['slug'] ) }}" class="product_item width_blogs">
                                <img class="lazy" data-src="{{ $blog['image_m'] }}" alt="{{ $blog['title'] }}">
                                <div class="product_text">
                                    <div class="span_blogs">
                                        <span>{{ $blog['userFio'] }}</span>
                                        <div class="eye_bl">
                                            <svg data-name="Icons / Messages" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                                <path id="_Icon_Color" data-name="🔹 Icon Color" d="M8.25,11.25A8.8,8.8,0,0,1,3.205,9.672,8.877,8.877,0,0,1,0,5.625a8.864,8.864,0,0,1,16.5,0,8.877,8.877,0,0,1-3.205,4.047A8.8,8.8,0,0,1,8.25,11.25Zm0-9.375A3.75,3.75,0,1,0,12,5.625,3.754,3.754,0,0,0,8.25,1.875Zm0,6a2.25,2.25,0,1,1,2.25-2.25A2.253,2.253,0,0,1,8.25,7.875Z" transform="translate(0.75 3.75)"/>
                                            </svg>
                                            <b>{{ $blog['view_count'] }}</b>
                                        </div>
                                    </div>
                                    <h4>{{ $blog['title'] }}</h4>
                                    <div class="arch">{!! $blog['short_text'] !!}</div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endsection
