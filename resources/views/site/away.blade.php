@extends('layouts.app')
@section('title'){{ trans('messages.Redirect in progress') }} @endsection

@section('content')
<center>
	<div class="logo" style="margin-top: 40px;">
        <img src="https://img.bisyor.ru/web/uploads/settings/bisyor-logo.svg" alt="bisyor-logo.svg">
    </div>
	<h1 style="margin-top: 40px;">{{ trans('messages.Redirect in progress') }}</h1>
	<div style="margin-top: 50px;">
		<p style="font-size: 20px;">
			{!! str_replace('{second}', '<span id="j-away-countdown" style="color:red; font-size: 22px; font-weight: bold;">5</span>', trans('messages.Redirect in any seconds')) !!}
		</p>
	</div>
	<div style="margin-top: 10px; margin-bottom: 80px; font-size: 18px;">
		<a href="{{ $link }}">
			{{ trans('messages.Follow the link now') }}
		</a>
	</div>
</center>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
$(function(){
    var $secs = $('#j-away-countdown');
    var timeout = 5, interval = 0;

    function showTimeout() {
        if (timeout >= 0) {
            $secs.text(timeout);
        }
    }

    interval = setInterval(function(){
        timeout--;
        if(timeout <= 0){
            document.location = '{{ $link }}';
            clearInterval(interval);
        }
        showTimeout();
    }, 1000);
    showTimeout();
});

</script>
@endsection