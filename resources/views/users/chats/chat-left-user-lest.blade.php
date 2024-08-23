@foreach($chatList as $chat)
    @php
        $active = '';
        if($nowChat != null && $chat['chat_id'] == $nowChat->id) $active = 'active';
    @endphp
    <a href="#" class="user chat_left_item {{ $active }}" id="{{ $chat['user_id'] }}" chat_id="{{ $chat['chat_id'] }}">
        <div class="img_chat {{ $chat['userOnline'] ? 'online' : '' }}">
            <img src="{{ $chat['userAvatar'] }}" alt="Avatar">
            <span class="pending">{{ $chat['noReadMsgCount'] }}</span>
        </div>
        <div>
            <h3>{{ $chat['userFio'] }}</h3>
            <p class="last_message">{!! $chat['lastMessage']['message'] !!}</p>
        </div>
        <div class="date_chat">{{ $chat['lastMessage']['date_cr']  }}</div>
        <div class="send_tick {{  $chat['lastMessage']['is_read'] ? 'double_tick' : '' }}"></div>
    </a>
@endforeach()
