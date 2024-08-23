@extends('layouts.app')
@section('title'){!! $seo['mtitle'] !!}@endsection
@section('meta_block')
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['mdescription'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['mkeywords'] !!}">
    <link rel="canonical" href="{{ url()->full() }}" />
    @foreach($langs as $lang)
        <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}" />
    @endforeach
@endsection

@section('content') 

<section class="contact_sec">
    <div class="container">
        <nav aria-label="breadcrumb" class="my_nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site-index') }}"> @lang('messages.Home') </a></li>
                <li class="breadcrumb-item active" aria-current="page">@lang('messages.Terms of use') </li>
            </ol>
        </nav>

        <form action="javascript:void(0)" class="vacant_form niked" method="post">           
			<h1>{!! $term->title !!}</h1>
			<p>{!! $term->description !!}</p>
			<small><p>{{ $term->date_up }}</p></small>
		</form>
    </div>
</section>

@endsection
