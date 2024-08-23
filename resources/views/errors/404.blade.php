@extends('layouts.404')

@section('title')404 @endsection

@section('content')
	<section class="not_found">
		<div class="container">
			<img src="/images/not_found.png" alt="Not found">
			<a href="{{ URL::previous() }}" class="update">{{ trans('messages.Back') }}</a>
			<p>{!! str_replace('{home_page_link}', env('SITE_LINK'), trans('messages.Go home page')) !!}</p>
		</div>
	</section>
@endsection