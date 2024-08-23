<div class="estate_main_right">
    <div class="est_user" itemscope itemtype="https://schema.org/Person">
        <div class="top_item_comment" itemprop="knowsAbout" itemscope
             itemtype="https://schema.org/Thing">
            <img itemprop="image" src="{{ $user->getAvatar() }}" alt="{{ $user->getUserFio() }}">
            <div class="text">
                <h5 itemprop="name" class="d-flex">
                    @if($user->is_verify)
                        <img src="{{ asset('images/is_verifiy.png') }}" style="width: 18px !important; height: 18px !important; border-radius: initial !important;" alt="Verifiy">
                    @endif
                    {{ $user->getUserFio() }}</h5>
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
        <div class="d-flex justify-content-between mb-2">
            <a href="{{ route('user-subscribers', ['login' => $user->getUserLogin(), 'type' => 'subscribers']) }}">{{ $user->subscribers_count }} подписчика</a>
            <a href="{{ route('user-subscribers', ['login' => $user->getUserLogin(), 'type' => 'subscriptions']) }}">{{ $user->subscriptions_count }} подписок</a>
        </div>
        <div class="btn_est_right">
            {{--<a class="more_know blue" id="show_phone" data-number=""
               data-login="{{ route('get-user-phone', ['login' => $user->login]) }}">{{ trans('messages.Show number') }}</a>--}}
            <a href="#" id="phone_main">{{ trans('messages.Show number') }}</a>
            <a href="{{ route('subscribe-user', ['id' => $user->id]) }}"
               class="button more_know blue {{ !$subscriber ?: 'bg-danger' }}">{{ $subscriber ? trans('messages.Unsubscribe') : trans('messages.Subscribe') }}</a>
        </div>
    </div>
    <?php //include('items.view.premium', ['premiumItems' => $premiumItems]) ?>
</div>
