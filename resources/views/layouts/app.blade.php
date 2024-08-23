<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<link rel="icon" type="image/png" href="/ico.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@yield('title')</title>
	{{-- SEO optimallashtirish uchun maxsus bloklar boshlanish nuqtasi --}}
	@yield('meta_block')
	{{-- SEO optimallashtirish tugadi --}}
	<meta http-equiv="Content-Language" content="{{app()->getLocale()}}" />
	<meta name="robots" content="index, follow" />
	<!-- <link rel="stylesheet" href="{{ asset('font/opensans.css') }}"> -->
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    @stack('before-styles')
	<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/style.css') }}?27">
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}?6">
	<link rel="stylesheet" href="{{ asset('css/media.css') }}?20">
	<link rel="stylesheet" href="{{ asset('css/my-style.css') }}?19">
    @stack('after-styles')
	{{--<link rel="stylesheet" href="{{ asset('css/style.min.css') }}?16">
	<link rel="stylesheet" href="{{ asset('css/media.min.css') }}?16">
	<link rel="stylesheet" href="{{ asset('css/my-style.min.css') }}?16">--}}
  	<meta name="csrf-token" content="{{ csrf_token() }}">
  	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  	
  	<!-- video for begin -->
  	

    @yield('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  	<!-- end video -->
  	
@php
	$countersList = \App\Models\References\Caching::getCountersCache();

	foreach ($countersList as $counter) {
		if($counter['code_position'] == 1) echo $counter['code'];
	}
@endphp

</head>

<body class="preload-mobile">
	@php
		\App\User::setLastSeen();
		$additional = new \App\Models\References\Additional();
		$langs = $additional->getLangs();
		$topShops = \App\Models\References\Caching::getTopShopsListCache();
		$headerCategories = $additional->headerCategories();

		foreach ($countersList as $counter) {
  			if($counter['code_position'] == 2) echo $counter['code'];
  		}

	@endphp
@include('inc.header', ['langs' => $langs, 'additional' => $additional, 'headerCategories' => $headerCategories])
	@include('alerts.success')
	@yield('content')
	@include('inc.footer', ['langs' => $langs, 'topShops' => $topShops, 'countersList' => $countersList])
	@include('inc.additional-js')
	<link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
	<!-- <script src="https://code.jquery.com/jquery-1.9.1.js"></script> -->
	<!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> -->
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/swiper.min.js') }}"></script>
	<script src="{{ asset('js/popper.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/select2.full.min.js') }}"></script>
  	<script src="{{ asset('js/jquery.maskedinput.js') }}"></script>
	<script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
	<script src="{{ asset('js/main.js') }}?23"></script>
	{{--<script src="{{ asset('js/main.min.js') }}"></script>--}}
	<script src="{{ asset('js/app.js') }}" defer></script>

    {{--<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>--}}

    @yield('extra-js')
    @include('auth.verification-ajax')
    @php
  		foreach ($countersList as $counter) {
  			if($counter['code_position'] == 3) echo $counter['code'];
  		}
  	@endphp
  
</body>
</html>
