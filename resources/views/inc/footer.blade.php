<footer id="footerId">
    <div class="container">
        <a href="{{ Route::currentRouteName() == 'site-index' ? 'javascript:void(0)' : route('site-index') }}" class="logo_ftr">
            <img src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" alt="{{ Config::get('settings.logo') }}">
        </a>
        <p class="wortern">{{ trans('messages.Subscribe text') }}</p>
        <form action="{{ route('subscribers') }}" class="form_ftr" autocomplete="off" method="post">
            @csrf
            <div class="form-group">
                <input type="text" name="email" value="{{ old('email') }}" class="form-control @php if($errors->has('email')) echo 'is-invalid' @endphp" required placeholder="E-mail">
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary"> {{ trans('messages.Send') }} </button>
            </div>
        </form>

        <div class="ftr_ul">
            <div>
                <div class="ftr_ul_h3">{{ trans('messages.Shops') }}</div>
                <ul>
                <!-- <ul class="shops_list_footer"> -->
                @foreach($topShops as $shop)
                    <li><a href="{{ route('shops-view', $shop->keyword) }}">{!! mb_substr($shop->name, 0, 25, "utf-8") !!}</a></li>
                @endforeach
                </ul>
            </div>
            <div>
                <div class="ftr_ul_h3">{{ trans('messages.Company') }}</div>
                <ul>
                    <li><a href="{{ Route::currentRouteName() == 'about' ? 'javascript:void(0)' : route('about') }}">{{ trans('messages.About us') }}</a></li>
                    <li><a href="{{ Route::currentRouteName() == 'vacancy' ? 'javascript:void(0)' : route('vacancy') }}">{{ trans('messages.Vacancy') }}</a></li>
                    <li><a href="{{ Route::currentRouteName() == 'items-list' ? 'javascript:void(0)' : route('items-list') }}">{{ trans('messages.Ads') }}</a></li>
                    <li><a href="{{ Route::currentRouteName() == 'blogs-list' ? 'javascript:void(0)' : route('blogs-list') }}">{{ trans('messages.Blog') }}</a></li>
                </ul>
            </div>
            <div>
                <div class="ftr_ul_h3">{{ trans('messages.Help') }}</div>
                <ul>
                    <li><a href="{{ Route::currentRouteName() == 'contact' ? 'javascript:void(0)' : route('contact') }}">{{ trans('messages.To contact us') }}</a></li>
                    <li><a href="{{ Route::currentRouteName() == 'services' ? 'javascript:void(0)' : route('services') }}">{{ trans('messages.Services') }}</a></li>
                    <li><a href="{{ Route::currentRouteName() == 'site-terms' ? 'javascript:void(0)' : route('site-terms') }}">{{ trans('messages.Terms of use') }}</a></li>
                    <li><a href="{{ Route::currentRouteName() == 'advertising' ? 'javascript:void(0)' : route('advertising') }}">{{ trans('messages.Advertising') }}</a></li>
                </ul>
            </div>
            <div>
                <div class="ftr_ul_h3">{{ trans('messages.Other') }}</div>
                <ul>
                    {{--<li><a href="{{ route('help') }}">{{ trans('messages.Help') }}</a></li>--}}
                    @if (Auth::check())
                        <li><a href="{{ Route::currentRouteName() == 'profile-settings' ? 'javascript:void(0)' : route('profile-settings') }}">{{ trans('messages.Profile') }}</a></li>
                        @else
                            <!-- <li><a href="#" data-toggle="modal" data-target="#loginModal"></a></li> -->
                            <li><a href="{{ route('login-index') }}">{{ trans('messages.Profile') }}</a></li>
                    @endif
                    <li><a href="{{ Route::currentRouteName() == 'site-map' ? 'javascript:void(0)' : route('site-map') }}">{{ trans('messages.Sitemap') }}</a></li>
                    <li><a href="{{ Route::currentRouteName() == 'site-map-regions' ? 'javascript:void(0)' : route('site-map-regions') }}">{{ trans('messages.Region map') }}</a></li>
                    <li><a href="{{ Route::currentRouteName() == 'popular' ? 'javascript:void(0)' : route('popular') }}">{{ trans('messages.Popular searchs') }}</a></li>
                </ul>
            </div>
            <div>
                <div class="ftr_ul_h3">{{ trans('messages.We in social') }}</div>
                <ul>
                    <li>
                        <a href="{{ Config::get('settings.facebook') }}" rel="nofollow" target="_blank">
                            <i class="fab fa-facebook-square"></i>{{ trans('messages.Facebook') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ Config::get('settings.twitter') }}" rel="nofollow" target="_blank">
                            <i class="fab fa-twitter"></i>{{ trans('messages.Twitter') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ Config::get('settings.instagram') }}" rel="nofollow" target="_blank">
                            <i class="fab fa-instagram"></i>{{ trans('messages.Instagram') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ Config::get('settings.youtube') }}" rel="nofollow" target="_blank">
                            <i class="fab fa-youtube"></i>{{ trans('messages.Youtube') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ftr_bottom_under">
            <span>{{ trans('messages.Bisyor Mobile') }}</span>
            <a href="{{ Config::get('settings.app_store') }}" rel="nofollow" target="_blank"><img class="lazy" src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" data-src="/images/App_Store.svg" alt="App_Store"></a>
            <a href="{{ Config::get('settings.google_play') }}" rel="nofollow" target="_blank"><img class="lazy" src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" data-src="/images/Play_Market.svg" alt="Play_Market"></a>
            <a href="{{ Config::get('settings.telegram_bot') }}" rel="nofollow" target="_blank"><img class="lazy" src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" data-src="/images/link_telegram.svg" alt="Telegram_Bot"></a>
            <!-- {!! Config::get('settings.footer_text') !!} -->
            <p>{!! App\Models\References\Caching::getSettingValueByKey('footer_text') !!}</p>
        </div>
        <div class="ftr_copyright">
            <span>© 2018-{{ date('Y') }} {{ trans('messages.Reserved text') }}</span>
            <!-- <a href="mailto:{{ Config::get('settings.email') }}" class="info_cpy">{{ Config::get('settings.email') }}</a>
            <a href="tel:{{ Config::get('settings.phone') }}" class="phone_cpy">{{ Config::get('settings.phone') }}</a> -->
            <p>{{ App\Models\References\Caching::getSettingValueByKey('address') }}</p>
            <div class="pay_cpy">
                <img class="lazy" src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" data-src="/images/UzCard.svg" alt="UzCard">
                <img class="lazy img-md h-auto ml-2" style="max-width: 100px !important;" src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" data-src="{{ asset('images/paynet.jpg') }}" alt="Paynet">
                <img class="lazy img-md h-auto ml-2" src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" data-src="/images/paymeee.svg" alt="Payme" style="width: 55px">
                <img class="lazy img-md h-auto ml-2" src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" data-src="/images/clickk.jpeg" alt="Click" style="width: 55px">
            </div>
        </div>
    </div>
    @php
        foreach ($countersList as $counter) {
            if($counter['code_position'] == 0) echo $counter['code'];
        }
    @endphp
</footer>

<div class='to-top'>
    <a class='back-to-top ion-chevron-up' href='#'><i class="fas fa-angle-up"></i></a>
</div>
