@extends('layouts.help')
@section('title'){!! $seo['helps_view_title'] !!}@endsection
@section('meta_block')
<meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['helps_view_description'] !!}">
	<meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['helps_view_keyword'] !!}">
  <link rel="canonical" href="{{ url()->full() }}"/>
@foreach($langs as $lang)
        <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}" />
@endforeach
@endsection
@section('content')

<section class="helping">
    <div class="container">
      	<nav aria-label="breadcrumb" class="my_nav">
        	<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('help') }}">{{ trans('messages.Help') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$data->name}}</li>
            </ol>
      	</nav>
      	<div class="help_tab">
      		<div class="tab-content for_business">
				<center>
					<h1>{{$data->name}}</h1>
					<p>{{ $data->text }}</p>
				</center>
			</div>
		</div>
	</div>
</section>

@endsection