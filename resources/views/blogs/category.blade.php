@extends('layouts.app')

@section('title'){!! $seo['blog_category_title'] !!} @endsection
@section('meta_block')
<meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['blog_category_description'] !!}">
<meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['blog_category_keyword'] !!}">
<meta name="robots" content="noindex, follow" />
<meta property="og:url" content="{{ url()->full() }}" />
<meta property="og:site_name" content="Bisyor.uz" />
<meta property="og:image:width" content="800" />
<meta property="og:image:height" content="665" />
<meta property="og:locale" content="{{ app()->getLocale() }}" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://bisyor.uz/images/bisyor-cover.jpg" />
<meta property="og:title" content="{!! $seo['blog_category_title'] !!}">
<meta property="og:description" content="{!! $seo['blog_category_description'] !!}">
<link rel="canonical" href="{{ url()->full() }}"/>
@endsection()
@section('content')
<section class="blog_section">
    <div class="container">
        <nav aria-label="breadcrumb" class="my_nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blogs-list') }}">{{ trans('messages.Blog') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $categoryValues['name'] }}</li>
            </ol>
        </nav>

        <ul class="blobg_ul nav">
            @foreach($categoriesNames as $category)
                <li>
                    <a href="{{ route('blogs-category', $category['key']) != url()->current() ? route('blogs-category', $category['key']):'javascript:;'}}"
                       class="{{ $cat->key == $category['key'] ? 'active' : null }}">{{ $category['name'] }}</a></li>
            @endforeach
        </ul>

        <div class="blogs_product">
        @if( $categoryValues['blogList'] != null )
            <div class="pre_top blog_tit aler">
                <div class="title"><h1>{{ $categoryValues['name'] }}</h1></div>
            </div>
            <div class="row">
                @foreach($categoryValues['blogList'] as $key => $blog)
                <div class="col-lg-3 col-sm-6 category_blog_list">
                    <a href="{{ route('blogs-view', $blog['slug'] ) }}" class="product_item width_blogs">
                        @if($key < 8)
                            <img src="{{ $blog['image'] }}" alt="{{ $blog['title'] }}">
                            @else
                                <img class="lazy" data-src="{{ $blog['image'] }}" alt="{{ $blog['title'] }}">
                        @endif
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
            @else
                <h1>{{ trans('messages.Blogs not found') }}</h1>
        @endif
        </div>
    </div>
</section>
@endsection