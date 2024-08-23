@if (!Auth::check() && !$noActualStatus)
    <div class="reg_comment">
        <h4>{{ trans('messages.Comments') }}</h4>
        @php
            $text = trans('messages.No comment text');
            $text = str_replace("{register_link}", route('register'), $text);
            $text = str_replace("{auth_link}", route('login'), $text);
        @endphp
        <p style="background-image: url(/images/kom.png);">{!! $text !!}</p>
    </div>
    @else
        <form action="{{ route('items-send-comment') }}" method="POST" class="comments uetr"
        itemscope itemtype="https://schema.org/Thing">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item['id'] }}" >
            <!-- <div class="sorted">
              <div class="sort">
                <span>Сортировка : </span>
                <div class=" dropdown_popup">
                  <a href="#" class=""><span>Самые новые</span></a>
                  <div class="dropdown_popup_body">
                    <a href="#"><span>Cамые лучшие</span></a>
                    <a href="#"><span>Cамые интересные </span></a>
                  </div>
                </div>
              </div>
            </div> -->
            <h3 style="padding-top: 12px;">{{ trans('messages.Comments') }}</h3>
            @foreach($msgList as $msg)
                <div class="item_comment">
                    <div class="top_item_comment">
                        <img src="{{ $msg['userAvatar']}}" alt="{{ $msg['userFio']}}" itemprop="image">
                        <div class="text">
                            <h5 itemscope itemtype="https://schema.org/Person" itemprop="additionalName">{{ $msg['userFio']}}</h5>
                            @if($msg['userOnlineStatus'])
                                <div class="on_of onlines">{{ trans('messages.Online') }}</div>
                                @else
                                    <div class="on_of">{{ trans('messages.Offline') }}</div>
                            @endif
                        </div>
                    </div>
                    <p>{{ $msg['message']}}</p>
                    {{--<div class="bottom_rep">
                                <div class="repl">
                                    <img src="/images/reply.png" alt="reply" class="repl_tog">
                                    <div class=" dropdown_popup">
                                        <a href="#" class=""><span><i class="fas fa-ellipsis-h"></i></span></a>
                                        <div class="dropdown_popup_body">
                                            <a href="#"><span>Удалить</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="likes">
                                    <div class="dislike">
                                        <a href="#" class="dislike">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10">
                                              <g><g><path d="M9.5 6h2V0h-2zM3 0c-.415 0-.77.25-.92.61L.57 4.135A.988.988 0 0 0 .5 4.5v.955l.005.005L.5 5.5c0 .55.45 1 1 1h3.155L4.18 8.785l-.015.16c0 .205.085.395.22.53l.53.525L8.21 6.705c.18-.18.29-.43.29-.705V1c0-.55-.45-1-1-1z" /></g></g>
                                          </svg>
                                        </a>
                                        <span>4</span>
                                    </div>
                                    <div class="like">
                                        <a href="#" class="like">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10">
                                                <g><g><path d="M11.5 4.5l-.005.04.005.005V5.5c0 .13-.025.25-.07.365L9.92 9.39A.993.993 0 0 1 9 10H4.5c-.55 0-1-.45-1-1V4c0-.275.11-.525.295-.705L7.085 0l.53.525c.135.135.22.325.22.53l-.015.16L7.345 3.5H10.5c.55 0 1 .45 1 1zM.5 10V4h2v6z" /></g></g>
                                            </svg>
                                        </a>
                                        <span>82</span>
                                    </div>
                                </div>
                    </div>--}}
                </div>
            @endforeach
            <div class="answer_letter">
                <i class="fas fa-reply"></i>
                <div class="inrepl">
                    <div class="answer_letter_name"></div>
                    <div class="answer_letter_some"></div>
                </div>
                <div class="close_let"><img src="/images/close.png" alt="close"></div>
            </div>
            <div class="self_kom">
                <div class="top_item_comment">
                    <img src="{{ Auth::user()->getAvatar() }}" alt="{{ Auth::user()->getUserFio() }}">
                    <div class="text">
                        <h5 itemscope itemtype="https://schema.org/Person" itemprop="additionalName">{{ Auth::user()->getUserFio() }}</h5>
                        <div class="on_of onlines">{{ trans('messages.Online') }}</div>
                    </div>
                </div>
                <textarea name="message" placeholder="{{ trans('messages.Comment') }}"></textarea>
                <button class="more_know blue">{{ trans('messages.Send') }}</button>
            </div>
        </form>
@endif
