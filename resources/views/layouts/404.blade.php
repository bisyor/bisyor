<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@php
    $countersList = \App\Models\References\Caching::getCountersCache();
    $title = trans('messages.Not found');
@endphp
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="/ico.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $title !!}">
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $title !!}">
    <link rel="canonical" href="{{ url()->full() }}"/>
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
    @php
        foreach ($countersList as $counter) {
            if($counter['code_position'] == 1) echo $counter['code'];
        }
    @endphp
</head>

<body>
  @yield('content')

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