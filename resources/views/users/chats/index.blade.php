<div class="chats-content">
@php $nowDate = ''; @endphp
@foreach($chatsMessage as $msg)
	<?php
		if($nowDate != $msg['totalDate']) {
			$nowDate = $msg['totalDate'];
			echo '<div class="lined">' . $nowDate . '</div>';
		}
	?>
	<div class="chat_right_item {{ $msg['class'] }}">
		<div class="tide">
			@if(!$msg['self']) <h3>{{ $msg['userFio'] }}</h3> @endif
			<span>{{ $msg['date_cr'] }}</span>
		</div>
		<p class="{{ $msg['is_read'] && $msg['self'] ? 'writed_let_doub' : '' }}">{!! $msg['message'] !!}</p>
        @if(!$msg['self'] && $msg['type'] == 'msg')
            <button id="translate" data-message="{{ $msg['message'] }}"
                    data-original="{{ $msg['message']  }}"
                    data-type="translate"
            class="btn btn-primary btn-sm rounded-sm">@lang('messages.Translate')</button>
        @endif
	</div>
	<!-- <div class="writing_load">
		<div class="load-3">
			<div class="line"></div>
			<div class="line"></div>
			<div class="line"></div>
		</div>
		<span>Фахриддин Юсупов</span> пишут…
	</div> -->
@endforeach
</div>
<!-- <form action="{{ route('chat-send-msg') }}" method="POST" class="chat_form"> -->
<form class="chat_form" name="chat-formasi" action="javascript:void(0);">
	<input type="file" id="hrq" onchange="sendFile()">
	<label for="hrq"></label>
	<input type="hidden" name="chatId" id="chatId" value="{{ $nowChat->id }}">
	<textarea id="chat_textarea" name="chatMsg" rows="1" placeholder="{{ trans('messages.Write a message') }}"></textarea>
	<button type="submit" onclick="submitChat()" id="myBtn"></button>
</form>
