<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	@php
		$countersList = \App\Models\References\Caching::getCountersCache();
	@endphp
	<meta charset="UTF-8">
	<link rel="icon" type="image/png" href="/ico.png">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- <link rel="stylesheet" href="{{ asset('font/opensans.css') }}"> -->
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
	<!-- <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}"> -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<!-- <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.6/jquery.fancybox.min.css">
	<!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="{{ asset('css/swiper.min.css') }}">
	<!-- <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"> -->
	<link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/style.css') }}?4">
	<link rel="stylesheet" href="{{ asset('css/media.css') }}?4">
	<link rel="stylesheet" href="{{ asset('css/my-style.css') }}">
  	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title')</title>
	{{-- SEO optimallashtirish uchun maxsus bloklar boshlanish nuqtasi --}}
	@yield('meta_block')
	{{-- SEO optimallashtirish tugadi --}}
	@php
		foreach ($countersList as $counter) {
			if($counter['code_position'] == 1) echo $counter['code'];
		}
	@endphp
</head>
<body>
	@php
		foreach ($countersList as $counter) {
  			if($counter['code_position'] == 2) echo $counter['code'];
  		}
	@endphp
	@yield('content')
	<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/swiper.min.js') }}"></script>
	<!-- <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script> -->
	<!-- <script src="{{ asset('js/popper.min.js') }}"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<!-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<!-- <script src="{{ asset('js/select2.full.js') }}"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  	<!-- <script src="{{ asset('js/jquery.maskedinput.js') }}"></script> -->
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
	<!-- <script src="{{ asset('js/jquery.fancybox.min.js') }}"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.6/jquery.fancybox.min.js"></script>
	<script src="{{ asset('js/main.js') }}?22"></script>
	@php
  		foreach ($countersList as $counter) {
  			if($counter['code_position'] == 3) echo $counter['code'];
  		}
  	@endphp
</body>
	@php
        foreach ($countersList as $counter) {
            if($counter['code_position'] == 0) echo $counter['code'];
        }
    @endphp
</html>