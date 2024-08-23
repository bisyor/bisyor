@extends('layouts.app')
@section('title'){!! $seo['mtitle'] !!}@endsection
@section('meta_block')
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['mkeywords'] !!}">
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['mdescription'] !!}">
@foreach($langs as $lang)
	<link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}" />
@endforeach
    <link rel="canonical" href="{{ url()->full() }}" />
@endsection()
@section('content')

<section class="contact_sec">
    <div class="container">
        <nav aria-label="breadcrumb" class="my_nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site-index') }}"> @lang('messages.Home') </a></li>
                <li class="breadcrumb-item active" aria-current="page">@lang('messages.About us') </li>
            </ol>
        </nav>

        <form action="javascript:void(0)" class="vacant_form niked" method="post">           
			<h1>{!! $about['title'] !!}</h1>
			<p>{!! $about['description'] !!}</p>
			<small><p>{{ $about['date_up'] }}</p></small>
		</form>
    </div>
</section>

@endsection
