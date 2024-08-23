@if( $item['shop_id'] == null )
    <div class="est_user">
        <div class="top_item_comment">
            <img src="{{ $user->getAvatar() }}" alt="{{ $item['name'] }}">
            <div class="text">
                <h5 itemscope itemtype="https://schema.org/Offer" itemprop="offeredBy" class="d-flex">
                    @if($user->is_verify)
                        <img src="{{ asset('images/is_verifiy.png') }}" style="width: 18px !important; height: 18px !important; border-radius: initial !important;" alt="Verifiy">
                    @endif
                    {{ $item['name'] }}</h5>
                @if($user->getOnlineStatus())
                    <div class="on_of onlines">{{ trans('messages.Online') }}</div>
                @else
                    <div class="on_of">{{ trans('messages.Offline') }}</div>
                @endif
            </div>
        </div>
        <p class="part">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="14" viewBox="0 0 12 14">
                <g>
                    <g>
                        <path fill="#2196f3"
                              d="M11.333 13.667a.667.667 0 0 1-.666-.667v-1.333a2 2 0 0 0-2-2H3.333a2 2 0 0 0-2 2V13A.667.667 0 0 1 0 13v-1.333a3.333 3.333 0 0 1 3.333-3.334h5.334A3.333 3.333 0 0 1 12 11.667V13a.667.667 0 0 1-.667.667zM6 7A3.333 3.333 0 1 1 6 .333 3.333 3.333 0 0 1 6 7zm0-1.333a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                    </g>
                </g>
            </svg>
            {{ trans('messages.Personal') }}
        </p>
        <p class="part">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                <g>
                    <g>
                        <path fill="#00b273"
                              d="M14 6.718c.368 0 .667.298.667.666v.62a7.333 7.333 0 1 1-4.349-6.702.667.667 0 0 1-.543 1.218 6 6 0 1 0 3.558 5.484v-.62c0-.368.299-.666.667-.666zm.195-5.185a.667.667 0 1 1 .943.943L7.805 9.809a.667.667 0 0 1-.943 0l-2-2a.667.667 0 1 1 .943-.943l1.528 1.529z"/>
                    </g>
                </g>
            </svg>
            {{ str_replace('{date_register}', $user->getRegistryDate() , trans('messages.User register site') ) }}
        </p>
        <div class="btn_est_right">
            <a href="{{ route('user-items', $user->getUserLogin()) }}"
               class="all_ads_author">{{ trans('messages.Users all items') }}</a>
            @if($noActualStatus == 0)
                @if($item['showPhone'])
                    <a class="more_know blue" id="show_phone" data-number=""
                       data-login="{{ route('get-item-user-phone', ['id' => $item['id']]) }}"
                       data-url="{{ route('set-contact-view', $item['id']) }}"
                       data-options='{"touch" : false}'
                       onclick="setContactView(this)">{{ trans('messages.Show number') }}</a>
                    <a href="#" id="phone_main">{{ trans('messages.Show number') }}</a>
                @endif
                <div class="popups_es" id="op_yet_popup">
                    <form action="{{ route('chat-create-chat') }}" method="POST" class="niked" autocomplete="off">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                        <div class="form-group">
                            <label for="#">{{ trans('messages.Your name') }}</label>
                            <input name="name" type="text" class="form-control" required="">
                        </div>
                        <div class="form-group">
                            <label for="#">{{ trans('messages.Your phone') }}</label>
                            <input name="phone" type="tel" class="form-control" required="">
                        </div>
                        <button class="more_know blue">{{ trans('messages.To order') }}</button>
                    </form>
                </div>
                <button class="more_know blue" id="op_yet">{{ trans('messages.Order phone') }}</button>
                @if (Auth::check() && Auth::user()->id != $user->id)
                    <a href="#message-content"
                       onclick="$('html, body').animate({ scrollTop: $('#message-content').offset().top-70 }, 1000);"
                       class="more_know blue mt-3" id="op_mes">
                        {{ trans('messages.Sent message') }}
                    </a>
                @endif
                @if (!Auth::check())
                    <a href="{{ route('login-index') }}"
                       class="more_know blue mt-3"> {{ trans('messages.Sent message') }} </a>
                @endif
            @endif


            @if(!$user->getOnlineStatus())
                <style>
                   .disable-video {
                       pointer-events: none;
                   }
                </style>
            @endif
            @if($noActualStatus == 0)
                @include('video-chat')
            @endif

            <div id="claim" class="mt-3 text-center text-danger"
                 style="cursor: pointer">{{ trans('messages.Complain') }}
             </div>
        </div>
    </div>

@else
    <div class="est_user">
        <div class="top_item_comment">
            <img src="{{ $item['shop']['logo'] }}" alt="{{ $item['shop']['name'] }}">
            <div class="text d-flex">
                @if($item['shop']['is_verify'])
                    <img src="{{ asset('images/is_verifiy.png') }}" style="width: 18px !important; height: 18px !important; border-radius: initial !important;" alt="Verifiy">
                @endif
                <h5>{{ $item['shop']['name'] }}</h5>
            </div>

        </div>
        <p class="part">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                <g>
                    <g>
                        <path fill="#00b273"
                              d="M5.4 11.4V11a.6.6 0 0 1 1.2 0v1a.6.6 0 0 1-.6.6H4a.6.6 0 0 1-.6-.6v-1a.6.6 0 0 1 1.2 0v.4zm3.2-.467V14.4h2.8v-3.467zm3.8-9.266a.067.067 0 0 0-.067-.067H3.667a.067.067 0 0 0-.067.067V2.4h8.8zm.85 6.483a1.15 1.15 0 0 0 1.147-1.062l-1.148-3.442a.067.067 0 0 0-.063-.046H2.814a.067.067 0 0 0-.063.046L1.603 7.088A1.15 1.15 0 0 0 3.9 7a.6.6 0 0 1 1.2 0 1.15 1.15 0 1 0 2.3 0 .6.6 0 0 1 1.2 0 1.15 1.15 0 1 0 2.3 0 .6.6 0 0 1 1.2 0c0 .635.515 1.15 1.15 1.15zM.4 7l.03-.19 1.182-3.544c.127-.38.423-.67.788-.797v-.802C2.4.967 2.967.4 3.667.4h8.666c.7 0 1.267.567 1.267 1.267v.802c.365.127.66.416.788.797l1.181 3.544.031.19c0 .795-.395 1.499-1 1.924v5.41c0 .699-.567 1.266-1.267 1.266H2.667c-.7 0-1.267-.567-1.267-1.267v-5.41A2.347 2.347 0 0 1 .4 7zm5.85 2.35c-.695 0-1.32-.302-1.75-.782a2.344 2.344 0 0 1-1.9.777v4.988c0 .037.03.067.067.067H7.4v-4.067a.6.6 0 0 1 .6-.6h4a.6.6 0 0 1 .6.6V14.4h.733c.037 0 .067-.03.067-.067V9.345a2.344 2.344 0 0 1-1.9-.777c-.43.48-1.055.782-1.75.782-.695 0-1.32-.302-1.75-.782-.43.48-1.055.782-1.75.782z"/>
                    </g>
                </g>
            </svg>
            {{ trans('messages.Shop') }}
        </p>
        <p class="part">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                <g>
                    <g>
                        <path fill="#00b273"
                              d="M14 6.718c.368 0 .667.298.667.666v.62a7.333 7.333 0 1 1-4.349-6.702.667.667 0 0 1-.543 1.218 6 6 0 1 0 3.558 5.484v-.62c0-.368.299-.666.667-.666zm.195-5.185a.667.667 0 1 1 .943.943L7.805 9.809a.667.667 0 0 1-.943 0l-2-2a.667.667 0 1 1 .943-.943l1.528 1.529z"/>
                    </g>
                </g>
            </svg>
            {{ str_replace('{date_register}', $item['shop']['date_cr'] , trans('messages.User register site') ) }}
        </p>
        <div class="btn_est_right">
            <a href="{{ $item['shop']['link'] }}" class="all_ads_author">{{ trans('messages.Users all items') }}</a>
            <a href="#" data-fancybox data-src="#applications_form" data-options='{"touch" : false}' class="all_ads_author bg-success text-white" >{{ trans('messages.Purchase') }}</a>
            @if($noActualStatus == 0)
                @if($item['showPhone'])
                    <a class="more_know blue" id="show_phone" data-number=""
                       data-login="{{ route('get-item-user-phone', ['id' => $item['id']]) }}"
                       data-url="{{ route('set-contact-view', $item['id']) }}"
                       data-options='{"touch" : false}'
                       onclick="setContactView(this)">{{ trans('messages.Show number') }}</a>
                    <a href="#" id="phone_main">{{ trans('messages.Show number') }}</a>
                @endif
                @if (Auth::check() && Auth::user()->id != $user->id)
                    <a href="#message-content" class="more_know blue" id="op_mes" onclick="$('html, body').animate({
                        scrollTop: $('#message-content').offset().top-70
                        }, 1000);">
                        {{ trans('messages.Sent message') }}
                    </a>
                @endif
                    <div id="claim" class="mt-3 text-center text-danger"
                         style="cursor: pointer">{{ trans('messages.Complain') }}</div>
        @endif
        </div>
    </div>
@endif
<div class="modal fade confirm_success_modal" id="auto_up" tabindex="-1" role="dialog"
     aria-labelledby="auto_up" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('messages.Complain') }}</h5>
                <button type="button" class="closes" data-dismiss="modal" aria-label="Close">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858Z"
                              fill="black"/>
                        <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="5" y="5"
                              width="14" height="14">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858Z"
                                  fill="white"/>
                        </mask>
                        <g mask="url(#mask0)">
                            <rect width="24" height="24" fill="black" fill-opacity="0.4"/>
                        </g>
                    </svg>
                </button>
            </div>
            <form action="{{ route('items-claim') }}" method="POST" id="claim_form"
                  autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="auto_up_top">
                        <span>{{ trans('messages.Please state the reasons') }}</span>
                    </div>
                    <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                    @foreach($reason_type_list as $key => $value)
                        <div class="form-group">
                            <label>
                                <input name="reason" value="{{ $key }}" type="radio" required>
                                {{ trans($value) }}
                            </label>
                        </div>
                    @endforeach
                    <div class="form-group" id="comment" style="display: none">
                        <label for="#">{{ trans('messages.Leave your comment') }}</label>
                        <textarea name="message" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="more_know blue">{{ trans('messages.Send') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
