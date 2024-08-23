@extends('layouts.help')
@section('title'){!! $seo['helps_search_title'] !!}@endsection
@section('meta_block')
<meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['helps_search_description'] !!}">
	<meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['helps_search_keyword'] !!}">
	<link rel="canonical" href="{{ url()->full() }}"/>
@foreach($langs as $lang)
    <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}?q={{ str_replace(' ', '+', $keyword) }}" />
@endforeach
@endsection
@section('content')

	@if($count > 0)
		<center>
			<p>{{ str_replace('{count}', $count, trans('messages.Search result count') ) }}</p>
			<ol>
			@foreach($data as $el)
				<li>
					<h3>{{ $el->name }}</h3>
					<p>{{ substr($el->text, 0, 100) }}
					<a href="{{ route('help-search-one', $el->id) }}">...{{ trans('messages.Details') }}</a></p>
				</li>
			@endforeach
			</ol>
	</center>
	@endif

	@if($count == 0)
		<center>
			<p>{{ str_replace(':query', $keyword, trans('messages.Result not found') ) }}</p>
		</center>
	@endif

@endsection