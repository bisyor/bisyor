@foreach($items as $item)
    <div class="product_mains product_horizontal oct_blocks">
        <div class="product_item">
            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
            <div class="product_text"
                 @if($item['serviceMarked']) style="background-color: {{ $item['serviceMarkedColor'] }}" @endif>
                <div class="tops_oct flexis">
                    <span>{{ $item['categoryName'] }}</span>
                    <b>
                        {!! str_replace('{from_date}', $item['publicated'], trans('messages.From date')) !!}
                        {!! str_replace('{to_date}', $item['publicated_to'], trans('messages.From To date')) !!}
                    </b>
                </div>
                <div class="title_oct flexis">
                    <h4><a href="{{ route('view-item', $item['link']) }}">{{$item['title']}}</a></h4>
                    <div class="popups_fl">
                        <div class="popups_fl_top">
                            <img src="/images/settings.svg" alt="Settings"> {{ trans('messages.Settings') }}
                        </div>
                        <div class="popups_fl_body">
                            {{--<a href="{{ route('view-item', $item['link']) }}">{{ trans('messages.Views') }}</a>--}}
                            <a href="{{ route('update-item', $item['link']) }}">{{ trans('messages.Update') }}</a>
                            @if($item['statusName'] == 'publicated')
                                <a class="open-confirm" href="{{ route('item-change-status', ['status' => 4, 'is_publicated' => 0, 'is_moderating' => 0, 'id' => $item['id']]) }}">{{ trans('messages.Deactivation') }}</a>
                                <a class="open_auto_up" data-id="{{ $item['id']}}">{{ trans('messages.Enable Auto Raise') }}</a>
                            @endif
                            @if($item['statusName'] == 'no-active' || $item['statusName'] == 'remove-public')
                                <a href="{{ route('activity-item', $item['id']) }}">{{ trans('messages.Activation') }}</a>
                            @endif
                            <a class="delete_item" href="{{ route('item-change-status', ['status' => 6, 'is_publicated' => 0, 'is_moderating' => 0, 'id' => $item['id']]) }}">{{ trans('messages.Delete') }}</a>
                            <a href="{{ route('video-gallery.index', $item['keyword']) }}">@lang('messages.Video gallery')</a>
                        </div>
                    </div>
                </div>
                <div class="flexis nego">
                    <div class="price_product">
                        <b>{{ $item['price'] }}</b>
                        <i>{{ $item['oldPrice'] }}</i>
                    </div>
                    <p class="negotiat">@if($item['price_ex']){{ $item['price_ex_title'] }}@endif</p>
                </div>
                <div class="flexis btns user-flexis-content">
                    <a href="{{ route('item-chats-list', ['item_id' => $item['id']] ) }}" class="more_know lets">
                        <img src="/images/letter2.svg" alt="letter2">
                        {{ trans('messages.Messages') }}: <span>{{ $item['msgCount'] }}</span>
                    </a>
                    @if($item['statusName']=='publicated' || $item['statusName']=='moderation')
                        <a href="{{ route('items-service', $item['id']) }}"
                           class="more_know blue">{{ trans('messages.Order advertisement') }}</a>
                    @endif
                    <a href="{{ route('profile.item.stat', ['item' => $item['id']]) }}"
                       class="more_know blue view_stat">
                        <img src="{{ asset('images/stat_white.png') }}" alt="@lang('messages.Statistics')">@lang('messages.Statistics')</a>
                </div>
                <div class="description_oct">
                    <div class="popup_tooltip" data-toggle="popover" data-html="true"
                         data-container="body"
                         data-trigger="hover"
                         data-placement="bottom"
                         data-content="<a class='m-2' href='{{ route('reset-count', ['id' => $item['id'], 'type' => 'view']) }}'>{{ trans('messages.Reset count') }}</a>"
                         style="cursor:pointer;"
                    >
                        <img src="/images/eye2.svg" alt="eye2">
                        <p>{{ trans('messages.Views') }}:<b> {{ $item['viewCount'] }}</b></p>
                    </div>
                    <div class="popup_tooltip" data-toggle="popover" data-html="true"
                         data-container="body"
                         data-trigger="hover"
                         data-placement="bottom"
                         data-content="<a class='m-2' href='{{ route('reset-count', ['id' => $item['id'], 'type' => 'contact']) }}'>{{ trans('messages.Reset count contacts') }}</a>"
                         style="cursor:pointer;">
                        <img src="/images/phone.svg" alt="phone">
                        <p>{{ trans('messages.Contacts') }}:<b> {{ $item['contactView'] }}</b></p>
                    </div>
                    <div class="popup_tooltip" data-toggle="popover" data-html="true"
                         data-container="body"
                         data-trigger="hover"
                         data-placement="bottom"
                         data-content="<a class='m-2' href='{{ route('reset-count', ['id' => $item['id'], 'type' => 'message']) }}'>{{ trans('messages.Reset count messages') }}</a>"
                         style="cursor:pointer;">
                        <img src="/images/letter2.svg" alt="letter2">
                        <p>{{ trans('messages.Messages') }}:<b> {{ $item['msgCount'] }}</b></p>
                    </div>
                    @if($item['blocked_reason'])
                        <div>
                            <img src="/images/error.png" alt="letter2" height="16" width="16">
                            <p class="blocker-reason" style="cursor: pointer" data-message="{{ $item['blocked_reason'] }}">{{ trans('messages.Block') }}</p>
                        </div>
                    @endif
                    @if(count($item['itemServicesList']) > 0)
                        <div class="popups_fl">
                            <div class="popups_fl_top">
                                <i class="fa fa-bullhorn"></i>
                                {{ trans('messages.Active services') }}
                            </div>
                            <div class="popups_fl_body">
                                @foreach($item['itemServicesList'] as $srv)
                                    <a href="#">
                                        <img class="itemServicesListImg" src="{{ $srv['img'] }}"
                                             alt="{{ $srv['name'] }}">
                                        {{ $srv['name'] }}
                                        <span class="item-services-list-date"> {{ trans('messages.to') }} &nbsp;{{ $srv['date'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- <div class="favoruites_product">
        </div> -->
        @if($item['servicePremium'])
            <div class="premium premium_item_border"><img src="/images/premium.png"
                                                          alt="premium">{{ trans('messages.Premium') }}</div>
        @endif
        @if($item['serviceFixed'])
            <div class="fastening"><img src="/images/fastening.png" alt="fastening">{{ trans('messages.Fix') }}</div>
        @endif
        @if($item['serviceQuick'])
            <div class="premium ups_pre"><img src="/images/premium.png" alt="premium">{{ trans('messages.Quick') }}
            </div>
        @endif
    </div>
@endforeach
