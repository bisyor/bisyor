@extends('layouts.app')
@section('title') {{ trans('messages.Chats') }} @endsection
@section('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        var my_id = "{{ Auth::id() }}";
        var receiver_id = "";
        $(document).keypress(function (e) {
            if (e.which == 13) {
                submitChat();
                e.preventDefault();
            }
        });

        function scrollToBottomFunc() {
            $('.chat_right').animate({
                scrollTop: $('.chat_right').get(0).scrollHeight
            }, 10);
        }

        function setActualDatas(fromMsg, toMsg) {
            $('#' + fromMsg.userId).find('.last_message').html(toMsg.message);
            $('#' + fromMsg.userId).find('.date_chat').html(toMsg.date_cr);
            if (toMsg.is_read == 1) $('#' + fromMsg.userId).find('.send_tick').addClass('double_tick');
            else $('#' + fromMsg.userId).find('.double_tick').removeClass('double_tick');
            if (toMsg.userOnline == 1) $('#' + fromMsg.userId).find('.img_chat').addClass('online');
        }

        function gagTextFunction(msg) {
            //var dt = new Date();
            //var time = dt.getHours() + ":" + dt.getMinutes();
            var text = '<div class="chat_right_item righted"><div class="writing_load"><div class="load-3"><div class="line"></div><div class="line"></div><div class="line">' +
                '</div></div><span style="font-size:12px;">' + msg + '</span></div></div>';
            $(".chats-content").append(text);
            scrollToBottomFunc();
        }

        function submitChat() {

            if ($('#chat_textarea').val() == '') {
                alert("Пожалуйста введите текст");
                return;
            }

            var data = new FormData();
            data.append('_token', '{{ csrf_token() }}');
            data.append('chatId', $('#chatId').val());
            data.append('chatMsg', $('#chat_textarea').val());
            gagTextFunction('Sending message ...');

            $('#chat_textarea').val("");
            $.ajax({
                url: "{{ route('chat-send-msg') }}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (datas) {
                },
            });
        }

        function sendFile() {
            var data = new FormData();
            data.append('file', $('#hrq')[0].files[0]);
            data.append('_token', '{{ csrf_token() }}');
            data.append('chat_id', $('#chatId').val());
            gagTextFunction('Sending file ...');

            $.ajax({
                url: "{{ route('chat-send-file') }}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                },
                error: function (error) {
                    alert(error.responseJSON.message.map(e => "\n" + e.replace('file', "{{ trans('messages.File') }}")));
                }
            });
        }

        $(document).on('click', '#translate', function () {
            let button = $(this);
            let type = button.attr('data-type');
            const translate = '@lang('messages.Translate')';
            const original = '@lang('messages.Original')';
            let message = button.attr('data-message');
            if(type === 'translate'){
                $.ajax({
                    url: "{{ route('translate') }}",
                    type: 'GET',
                    data: {
                        message: message,
                        lang: '{{ app()->getLocale() }}'
                    },
                    cache: false,
                    success: function (data) {
                        button.prev().html(data);
                        button.attr('data-type', 'original');
                        button.text(original);
                    },
                    error: function (error) {}
                });
            }else{
                button.prev().html(button.attr('data-original'));
                button.text(translate);
                button.attr('data-type', 'translate');
            }
        });

        const translate = (message) => {

        }
        $(document).ready(function () {

            Pusher.logToConsole = true;
            var pusher = new Pusher('427c76d3c42455585e4b', {
                cluster: 'ap2'
            });

            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', function (data) {
                console.log(JSON.stringify(data));
                if (my_id == data.fromMsg.userId) {
                    setActualDatas(data.toMsg, data.fromMsg);
                    setTimeout(function () {
                        $('#' + data.toMsg.userId).click();
                    }, 500);
                } else {
                    if (my_id == data.toMsg.userId) {
                        if (receiver_id == data.fromMsg.userId) {
                            setActualDatas(data.fromMsg, data.toMsg);
                            setTimeout(function () {
                                $('#' + data.fromMsg.userId).click();
                            }, 500);
                        } else {
                            setActualDatas(data.fromMsg, data.toMsg);
                            var pending = parseInt($('#' + data.fromMsg.userId).find('.pending').html());
                            if (pending) $('#' + data.fromMsg.userId).find('.pending').html(pending + 1);
                            else $('#' + data.fromMsg.userId).find('.pending').html(1);
                        }
                    }
                }
            });

            $('.user').click(function () {
                receiver_id = $(this).attr('id');
                $('.user').removeClass('active');
                $(this).addClass('active');
                //$(this).find('.pending').remove();  kkli kod
                $(this).find('.pending').html("");

                $.ajax({
                    type: "get",
                    url: "{{ route('messages-list') }}" + "?chat_id=" + $(this).attr('chat_id'),
                    data: "",
                    cache: false,
                    success: function (data) {
                        $('#chat-message-content').html(data);
                        $('#chat_right').removeClass('free2');
                        scrollToBottomFunc();
                    }
                });
            });

            $('#chat_textarea').keydown(function (e) {
                if ((e.keyCode == 10 || e.keyCode == 13) && e.ctrlKey) {
                    var text = $(this).val();
                    text = text + "\n";
                    $(this).val(text);
                }
            });

            $(document).on('click', '.tab_view', function () {

            });
        });
    </script>

    <section class="cabinet">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Chats') }}</li>
                </ol>
            </nav>
            <div class="row pb-3">
                @include('users.left_sidebar', ['user' => $user])
                <div class="col-xl-9 col-md-8 c_cabinet">
                    <div class="chat_main">
                        <div class="chat_top">
                            <ul class="nav">
                                <li><a class="{{ request()->url() == route('chats-list') ? 'active' : '' }}"
                                       href="{{ route('chats-list') }}">{{ trans('messages.All messages') }}</a></li>
                                <li>
                                    <a class="{{ request()->url() == route('chats-list', ['type_list' => 'purchase']) ? 'active' : '' }}"
                                       href="{{ route('chats-list', ['type_list' => 'purchase']) }}">{{ trans('messages.Purchase') }}</a>
                                </li>
                                <li>
                                    <a class="{{ request()->url() == route('chats-list', ['type_list' => 'sale']) ? 'active' : ''}}"
                                       href="{{ route('chats-list', ['type_list' => 'sale']) }}">{{ trans('messages.Sales') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="chat_wrap">
                            @if(count($chatList) > 0)
                                <div class="chat_left">
                                    {{--                                {{ dd($chatList) }}--}}
                                    @include('users.chats.chat-left-user-lest')
                                </div>
                            @else
                                <div class="chat_left free1">
                                    <img src="/images/let_free1.png" alt="{{ trans('messages.Messages empty') }}">
                                    <p class="freedas">{{ trans('messages.Messages empty') }}</p>
                                </div>
                            @endif

                            @if(count($chatsMessage) > 0)
                                <div class="chat_right" id="chat_right">
                                    <div id="chat-message-content">
                                        @include('users.chats.index', ['chatsMessage' => $chatsMessage, 'nowChat' => $nowChat])
                                    </div>
                                </div>
                            @else
                                <div class="chat_right free2" id="chat_right">
                                    <div id="chat-message-content">
                                        <img src="/images/let_free2.png" alt="No messages">
                                        <p class="freedas">{{ trans('messages.No messages') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
